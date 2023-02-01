<?php

namespace App\Http\Controllers;

use App\House;
use App\Photo;
use App\Reservation;

use Log;

use Illuminate\Http\Request;


use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Zarinpal\Laravel\Facade\Zarinpal;
use Mail;
use SEO;
use Config;

use App\Jobs\SendEmailNotification;
use App\Jobs\SendSMSNotification;
use App\Jobs\SendAdminTelegramNotification;

class HouseController extends Controller
{
    /**
     * get house comments
     *
     * @return \Illuminate\Http\Response
     */
    public function getHouseComments($id)
    {
        $house  = House::findOrFail($id);
        $comments = $house->comments()->select('comments.id' , 'user_id', 'parent_id', 'house_id', 'comment', 'comments.created_at', 'name', 'family', 'picture')->leftJoin('users', 'comments.user_id', '=', 'users.id')->get(); 
        return $comments;
    }

	public function getHousePhotos($id)
    {
        $house  = House::findOrFail($id);
        $photos = $house->photos()->get();
        return $photos->toJson();
    }

    /**
     * Get similar houses
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function getSimilars($id)
    {
        $house = House::findOrFail($id);
        $houses = House::where('province', $house->province)->bookable()->whereNotIn('id', [$id])->orderBy('id', 'desc')->take(10)->get();
        return $houses->makeHidden(['address','request_from','tel','temp','disabled','non_bookable']);
    }

    /**
     * Get most popular houses
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function getMostPopulars()
    {
     	return Reservation::selectRaw('houses.id, title, type, rooms, max_accommodates, province, city, min_price, thumbnail_path, is_cover, count(*) AS reservations')->join('houses', 'reservations.house_id' , '=', 'houses.id')->join('photos', 'reservations.house_id', '=', 'photos.house_id')->groupBy('reservations.house_id')->whereNotIn('reservations.guest_user_id', [1, 2, 4, 649])->bookable()->where('is_cover', 1)->orderBy('reservations', 'desc')->paginate(20);
    }

    /**
     * Change cover photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function setCoverPhoto($id)
    {
        $photo = Photo::findOrFail($id);
        $house = $photo->house;
        $this->authorize('edit', $house);
        $cover_photos = Photo::where('house_id', $house->id)->where('is_cover', 1)->get();
        foreach ($cover_photos as $pre_cover_photo) {
            $pre_cover_photo->is_cover = 0;
            $pre_cover_photo->save();
        }
        $photo->is_cover = 1;
        $photo->save();
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
	public function store()
    {
        $user = Auth::user();

        $house = new House;
        $house->temp          = 1;
        $house->user_id       = $user->id;
        $house->request_from  = 'web';
        $house->save();

        return response()->json(['id' => $house->id], 200);
    }

	/**
     * Upload image
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addHousePhoto(Request $request, $id)
    {
        $house = House::findOrFail($id);
        $this->authorize('edit', $house);
        $this->validate($request, [
            'image' => 'required|image',
            ]);
        $image = $request->image;
        $photo = new Photo;
        $sha1 = sha1($image->getClientOriginalName()); //for avoiding conflicts
        $image_name = "house-".$house->id."-".date('Y-m-d-h-i-s')."-".$sha1.'.jpg';
        $photo->path = 'img/houses/' . $image_name;
        $photo->thumbnail_path = 'img/houses/thumb-' . $image_name;
        $path = public_path($photo->path);
        $path_thumbnail = public_path($photo->thumbnail_path);
        //Resize image
        ini_set('memory_limit','256M'); //Image manipulation is a memory-heavy task.
        $img_main = Image::make($image->getRealPath())->resize(1600,1200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($path);
        $img_thumb = Image::make($image->getRealPath())->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path_thumbnail);
        $house->photos()->save($photo);
        $img_main->destroy();
        $img_thumb->destroy();
        return response()->json([
            'status' => 'success',
            'id'     => $photo->id,
            'error'  => ''
        ],200);
    }

    public function removeHousePhoto(Request $request, $id)
    {
        $house = House::findOrFail($id);

        $this->authorize('edit', $house);

        $this->validate($request, [
            'img_id' => 'required|integer|min:0',
        ]);

        #check at least 1 photo
        $photos_count = $house->photos->count();
        if($photos_count < 2)
            return response()->json([
                'status' => 'failed',
                'error'  => 'Min number of photos is 1'], 404);
        
        $deleted_ids = Photo::destroy($request->img_id);
        if (! $deleted_ids)
        {
            return response()->json([
            'status' => 'failed',
            'error'  => 'photo not found!'], 404);
        }

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
   public function update(Request $request, $id)
    {
        $house = House::findOrFail($id);

        $this->authorize('edit', $house);

        #input validation
        $this->validate($request, [
            'type'              => 'required|in:apartment,villa,room',
            'title'             => 'required|string|max:40',
            'about'             => 'required|string|max:1023',
            'description'       => 'required|string|max:2047',
            'city'              => 'required|string|max:31',
            'province'          => 'required|string|max:31',
            'address'           => 'required|string|max:255',
            'accommodates'      => 'required|integer|min:1',
            'tel'               => 'digits_between:7,8',
            'longitude'         => 'required|numeric',
            'latitude'          => 'required|numeric',
            'single_beds'       => 'required|integer|min:0',
            'double_beds'       => 'required|integer|min:0',
            'floors'            => 'required|integer|min:1',
            'rooms'             => 'required|integer|min:0',
            'floor_no'          => 'required|integer',
            'min_price'         => 'required|integer|min:0',
            'median_price'      => 'required|integer|min:0',
            'max_price'         => 'integer|min:0',
            'land_area'         => 'required|integer|min:0',
            'building_area'     => 'required|integer|min:0',
            'extra_person'      => 'required|integer|min:0',
            'discount_days_level1'     => 'integer|min:1',
            'discount_days_level2'     => 'integer|min:1',
            'discount_rate_level1'     => 'numeric|min:1',
            'discount_rate_level2'     => 'numeric|min:1',
        	
            'furniture'         => 'required|boolean',
            'internet'          => 'required|boolean',
            'elevator'          => 'required|boolean',
            'indoor_pool'       => 'required|boolean',
            'outdoor_pool'      => 'required|boolean',
            'barbecue'          => 'required|boolean',
            'heating'           => 'required|boolean',
            'water_cooling'     => 'required|boolean',
            'split_cooling'     => 'required|boolean',
            'breakfast'         => 'required|boolean',
            'television'        => 'required|boolean',
            'parking'           => 'required|boolean',
            'european_wc'       => 'required|boolean',
            'kitchen_equipment' => 'required|boolean',
            'balcony'           => 'required|boolean',

            'detached'          => 'required|boolean',
            'in_complex'        => 'required|boolean',
            'janitor'           => 'required|boolean',
            'private_yard'      => 'required|boolean',
            'structure'         => 'required|in:flat,duplex,triplex',
            'max_accommodates'  => 'required|integer|min:1',
            'mountain'          => 'required|boolean',
            'forest'            => 'required|boolean',
            'coastal'           => 'required|boolean',
            'desert'            => 'required|boolean',
            'historic'          => 'required|boolean',
            'in_town'           => 'required|boolean',
            'summer'            => 'required|boolean',
            'rural'             => 'required|boolean',
            'receiver'          => 'required|boolean',
            'bathroom'          => 'required|boolean',
            'rule_cermony'      => 'required|boolean',
            'rule_pets'         => 'required|boolean',
            'rule_checkin'      => 'required|integer|min:0',
            'rule_checkout'     => 'required|integer|min:0',
            'rule_minimum_days' => 'required|integer|min:0',
            'rules_desc'        => 'string|max:2047',
            'village'           => 'string|max:31',
            'price_desc'        => 'string|max:2047',
            'peak_days'         => 'required|string',
            'unavailable_days'  => 'required|string',
            'place_desc'        => 'string|max:2047',
        ]);

        #send notifications
        if($house->temp) #Send notif for the first time
        {
            $this->dispatch(new SendAdminTelegramNotification('emails.newhouse', ['house' => $house], 'ثبت خانه جدید #edit'));
            
            #Send Email to Admin
            $this->dispatch(new SendEmailNotification('emails.newhouse', ['house' => $house], 'ثبت خانه جدید', ['info@shab.ir','security@shab.ir']));

            #SMS to host
            $this->dispatch(new SendSMSNotification(getHostNewHouseSms($house), array($house->user->mobile)));
        }
        else
        {
            $this->dispatch(new SendAdminTelegramNotification('emails.newhouse', ['house' => $house], 'ویرایش خانه #edit'));

            #Send Email to Admin
            $this->dispatch(new SendEmailNotification('emails.newhouse', ['house' => $house], 'ویرایش خانه', ['info@shab.ir','security@shab.ir']));
        }

        #Check image
        if($house->photos->count() < 1)
            return abort(503);

        #update itmes
        $house->type              = $request->type;
        $house->title             = $request->title;
        $house->about             = $request->about;
        $house->description       = $request->description;
        $house->city              = $request->city;
        $house->province          = $request->province;
        $house->address           = $request->address;
        $house->accommodates      = $request->accommodates;
        if(isset($request['tel']))
        {
            $house->tel           = $request->tel;
        } 
        $house->longitude         = $request->longitude;
        $house->latitude          = $request->latitude;
        $house->single_beds       = $request->single_beds;
        $house->double_beds       = $request->double_beds;
        $house->beds              = $request->single_beds + 2 * $request->double_beds;
        $house->floors            = $request->floors;
        $house->rooms             = $request->rooms;
        $house->floor_no          = $request->floor_no;
        $house->min_price         = $request->min_price;
        $house->median_price      = $request->median_price;
        if(isset($request['max_price']))
        {
	       $house->max_price         = $request->max_price;
        }
        $house->land_area         = $request->land_area;
        $house->building_area     = $request->building_area;
        if(isset($request['village']))
        {
           $house->village           = $request->village;
        }
        $house->detached          = $request->detached;
        $house->in_complex        = $request->in_complex;
        $house->janitor           = $request->janitor;
        $house->private_yard      = $request->private_yard;
        $house->structure         = $request->structure;
        $house->max_accommodates  = $request->max_accommodates;
        $house->mountain          = $request->mountain;
        $house->forest            = $request->forest;
        $house->coastal           = $request->coastal;
        $house->desert            = $request->desert;
        $house->historic          = $request->historic;
        $house->in_town           = $request->in_town;
        $house->summer            = $request->summer;
        $house->rural             = $request->rural;
        if(isset($request['place_desc']))
        {
            $house->place_desc        = $request->place_desc;
        }
        $house->receiver          = $request->receiver;
        $house->suna              = $request->suna;
        $house->indoor_pool       = $request->indoor_pool;
        $house->outdoor_pool      = $request->outdoor_pool;
        $house->pool              = $house->indoor_pool || $house->outdoor_pool;
        $house->bathroom             = $request->bathroom;
        $house->rule_checkin         = $request->rule_checkin;
        $house->rule_checkout        = $request->rule_checkout;
        $house->rule_cermony         = $request->rule_cermony;
        $house->rule_pets            = $request->rule_pets;
        $house->rule_minimum_days    = $request->rule_minimum_days;
        if(isset($request['rules_desc']))
        {
            $house->rules_desc           = $request->rules_desc;
        }
        if(isset($request['discount_days_level1']))
        {
            $house->discount_days_level1 = $request->discount_days_level1;
        }
        if(isset($request['discount_rate_level1']))
        {
            $house->discount_rate_level1 = $request->discount_rate_level1;
        }
        if(isset($request['discount_days_level2']))
        {
            $house->discount_days_level2 = $request->discount_days_level2;
        }    
        if(isset($request['discount_rate_level2']))
        {
            $house->discount_rate_level2 = $request->discount_rate_level2;
        }
        if(isset($request['price_desc']))
        {
            $house->price_desc           = $request->price_desc;
        }
        $house->peak_days            = $request->peak_days;
        $house->unavailable_days     = $request->unavailable_days;

        $house->furniture            = $request->furniture;
        $house->internet             = $request->internet;
        $house->elevator             = $request->elevator;
        $house->barbecue             = $request->barbecue;
        $house->heating              = $request->heating;
        $house->water_cooling        = $request->water_cooling;
        $house->split_cooling        = $request->split_cooling;
        $house->breakfast            = $request->breakfast;
        $house->television           = $request->television;
        $house->parking              = $request->parking;
        $house->european_wc          = $request->european_wc;
        $house->kitchen_equipment    = $request->kitchen_equipment;
        $house->balcony              = $request->balcony;
        $house->extra_person         = $request->extra_person;        
        $house->temp                 = 0;
        $house->save();
        
        return redirect()->route('dashboard-houses');
    }

    /**
     * Display the specified resource.
     *
     * @param  House $house
     * @return \Illuminate\Http\Response
     */
    public function showHouse(House $house)
    {
        if ($house->temp == 1)
            return abort(404);

        $type = '';
        switch ($house->type) {
            case 'villa':
                $type = 'ویلا';
                break;
            case 'apartment':
                $type = 'آپارتمان';
                break;
            case 'room':
                $type = 'سوئیت';
                break;
        }

        $shomal = '';
        if($house->province == 'مازندران' || $house->province == 'گرگان' || $house->province == 'گیلان')
            $shomal = ', شمال';

        SEO::setTitle('اجاره '.$type.' در '.$house->city.', '.$house->province.$shomal.' - '.$house->title);
        $last_modified = date_create($house->updated_at);
        SEO::setDescription(date_format($last_modified, 'M d, Y').' - اجاره '.$type.' در '.$house->city.$shomal.'، '.$house->province.' با '.($house->min_price * 1000).' تومان. '.$house->about);

        SEO::opengraph()->setTitle($house->title.' - اجاره '.$type.' در '.$house->city.'، '.$house->province.$shomal);
        SEO::opengraph()->setType('website');
        SEO::opengraph()->setUrl('https://www.shab.ir/houses/show/'.$house->id);

        $house_photo = $house->photos()->get()->first();
        if(!empty($house_photo))
            SEO::opengraph()->addImage('https://www.shab.ir/'.$house_photo->path);
        SEO::opengraph()->setDescription($house->about);
        SEO::opengraph()->addProperty('locale', 'fa_IR');

        return view('house', ['house' => $house, 'reservations_count' => $house->reservations->count()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = Auth::user()->houses()->orderBy('id', 'desc')->paginate(1000);
        SEO::setTitle('آگهی‌های من - سایت شب');
        return view('userpanel',['page' => 'myhouses', 'houses' => $houses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newhouse');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $house = House::findOrFail($id);
        $this->authorize('edit', $house);
        return view('newhouse', ['house' => $house]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $house = House::findOrFail($id);
        $this->authorize('edit', $house);
        House::destroy($id);
        return redirect()->route('dashboard-houses');
    }

    public function verify_payment(Request $request)
    {
        if($request['Status'] == 'OK')
        {
            #Get authority and find corresponding reserve
            $reserve = Reservation::where('authority', '=', $request['Authority'])->firstOrFail();
            $result = Zarinpal::verify('OK', $reserve->fee, $request['Authority']);
            
            if($result['Status'] == 'success')
            {
                #change verified state to 1 and save ref-id
                $reserve->verified = 1;
                $reserve->refid = $result['RefID'];
                $reserve->save();

                #TODO: send sms for host
                #TODO: send sms for guest
                #send sms for admin
                //sendSMS('یک رزرو جدید در سامانه ثبت شد. شماره خانه: '.$reserve->house_id , array('09124490751', '09128268729'));
                $this->dispatch(new SendSMSNotification('یک رزرو جدید در سامانه ثبت شد. شماره خانه: '.$reserve->house_id, array('09124490751', '09128268729')));

                //sendSMS('رزرو شما با موفقیت در سایت شب ثبت گردید. همکاران ما به زودی برای هماهنگی بیشتر با شما تماس خواهند گرفت.' , array($reserve->guest->mobile));
                $this->dispatch(new SendSMSNotification('درخواست رزرو شما با موفقیت در سایت شب ثبت گردید. همکاران ما به زودی برای هماهنگی بیشتر با شما تماس خواهند گرفت.', array($reservation->guest->mobile)));

                #Telegram notification
                //sendToTelegram('emails.reserve', ['reserve' => $reserve], 'رزرو جدید');
                $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'رزرو جدید #reserve'));

                #notification email for admin
                /*
                Mail::send('emails.reserve', ['reserve' => $reserve], function ($message) {
                    $message->subject('رزرو جدید');
                    $message->from('automated@shab.ir', 'Shab.ir');
                    $message->to(['info@shab.ir']);
                });
                */
                $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'رزرو جدید', ['info@shab.ir','security@shab.ir']));

                /*
                Mail::send('emails.reserve', ['id' => $reserve->house_id, 'checkin' => date('r', $reserve->checkin), 'checkout' => date('r',$reserve->checkout), 'guests' => $reserve->guests, 'guest_name' => ($reserve->guest->name).' '.($reserve->guest->family), 'guest_mobile' => $reserve->guest->mobile, 'host_name' => ($reserve->host->name).' '.($reserve->host->family), 'host_mobile' => $reserve->host->mobile], function ($message) {
                    $message->subject('رزرو جدید');
                    $message->from('automated@shab.ir', 'Shab.ir');
                    $message->to('info@shab.ir');
                });
                */
                #TODO: notification email for host
                #TODO: notification email for guest
                
                return redirect()->route('trips'); 
            }
            else
                return redirect()->back()->with('status', 'Transaction failed');
        }
        else{
            #remove reserve
            $reserve = Reservation::where('authority', '=', $request['Authority'])->firstOrFail();
            $house_id = $reserve->house_id;
            $reserve->delete();
            return redirect("houses/show/$house_id");
            #return redirect()->back()->with('status', 'Transaction canceled by user');
        }
    }

     /**
     * Show all houses for admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllHouses()
    {
        $houses = House::all()->paginate(25);
        return view('houselist', ['houses' => $houses]);
    }

    public function test()
    {
        $reservation = Reservation::findOrFail(1);

        $this->dispatch(new SendSMSNotification(getHostPaidInvoiceSms($reservation), array($reservation->host->mobile)));

        return "success";
    }
}
