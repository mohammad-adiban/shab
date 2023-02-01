<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\House;
use App\Photo;
use App\Reservation;
use App\Bookmark;
use App\Message;
use App\Comment;

use Illuminate\Support\Facades\DB;

use JWTAuth;

use Intervention\Image\ImageManagerStatic as Image;
use Mail;
use App\Jobs\SendEmailNotification;
use App\Jobs\SendSMSNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendPushNotification;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use UrlShortener;

use Log;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

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
    
    /**
     * Get cities list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCities(Request $request)
    {
        $provinces = House::distinct()->select('province')->bookable()->orderBy('province', 'asc')->get();
        $cities = array();
        foreach ($provinces as $province) {
            $available_cities = House::distinct()->select('city')->bookable()->where('province', $province['province'])->orderBy('city', 'asc')->get()->makeHidden(['photo','bookmarked']);
            $cities[$province['province']] = $available_cities;
            $i = 0;
            foreach ($available_cities as $city) {
                $cities[$province['province']][$i]['count'] = House::where('city', $city['city'])->bookable()->get()->count();
                $i++;
            }
        }
        return $cities;
    }

    /**
     * Main page search box, search for house ids, house titles and hosts' names
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchBox(Request $request)
    {
        $this->validate($request, [
            'phrase'  => 'required|string|max:128',
            'page'    =>  'required|integer|min:0',
        ]);

        #Search in house's id, title
        $results_1 = House::select('houses.id', 'title', 'province', 'city', 'max_accommodates', 'type', 'rooms', 'min_price', 'longitude', 'latitude')->bookable()->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.urldecode($request['phrase']).'%')->orWhere('id', 'like', '%'.urldecode($request['phrase']).'%');
                });

        #Search in users's name, family
        $results_2 = House::select('houses.id', 'title', 'province', 'city', 'max_accommodates', 'type', 'rooms', 'min_price', 'longitude', 'latitude')->bookable()->leftJoin('users', 'houses.user_id', '=', 'users.id')->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%'.urldecode($request['phrase']).'%')->orWhere('family', 'like', '%'.urldecode($request['phrase']).'%');
                });

        $final_results = $results_2->union($results_1)->get();

        #manual pagination because of union and paginator problem
        return new Paginator($final_results, count($final_results), 20);
    }

    /**
     * Get similar houses
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function getSimilars(Request $request, $id)
    {
        $house = House::findOrFail($id);
        $houses = House::where('province', $house->province)->bookable()->whereNotIn('id', [$id])->orderBy('id', 'desc')->take(10)->get();
        return $houses->makeHidden(['address','request_from','tel','temp','disabled', 'non_bookable']);
    }

    /**
     * Get most popular houses
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function getMostPopulars(Request $request)
    {
        return Reservation::selectRaw('houses.id, title, type, rooms, max_accommodates, province, city, min_price, thumbnail_path, is_cover, count(*) AS reservations')->join('houses', 'reservations.house_id' , '=', 'houses.id')->join('photos', 'reservations.house_id', '=', 'photos.house_id')->groupBy('reservations.house_id')->whereNotIn('reservations.guest_user_id', [1, 2, 4, 649])->bookable()->where('is_cover', 1)->orderBy('reservations', 'desc')->paginate(20);
    }

    public function addTag(Request $request, $id)
    {
        #Check admin
        $user = JWTAuth::parseToken()->authenticate();
        if($user->id != 19 && $user->id != 1) #Ahmad & Mohammadreza
            return response()->json(['permission_denied'], 403);

        $this->validate($request, [
            'tag' => 'required|string|max:64',
        ]);        
        $house = House::findOrFail($id);
        $house->tag($request->tag);
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

    public function removeTag(Request $request, $id)
    {
        #Check admin
        $user = JWTAuth::parseToken()->authenticate();
        if($user->id != 19 && $user->id != 1) #Ahmad & Mohammadreza
            return response()->json(['permission_denied'], 403);

        $this->validate($request, [
            'tag' => 'required|string|max:64',
        ]);

        $house = House::findOrFail($id);
        $house->untag($request->tag);
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

    public function search(Request $request)
    {
        //$result = DB::table('houses')->paginate(20);
        $this->validate($request, [
            'id'               => 'integer|min:1',
            'guests'           => 'integer|max:1000',
            'destination'      => 'string',
            'price_max'        => 'integer|min:1',
            'price_min'        => 'integer|min:1',
            'checkin'          => 'integer|min:0',
            'checkout'         => 'integer|min:0',
            'rooms'            => 'integer|min:0',
            'beds'             => 'integer|min:0',
            'tag'              => 'string|max:64',
            'min_accommodates' => 'integer|min:0',
        ]);

        $room_types = array('villa','apartment','room');

        #TODO: structure
        $structures = array('duplex','triplex','flat');

		$amenities = array('furniture','internet','elevator','indoor_pool','outdoor_pool','barbecue','heating','water_cooling','split_cooling','breakfast','television','parking','european_wc','kitchen_equipment','balcony','receiver','bathroom', 'pool');
		$place =  array('detached','in_complex','janitor','private_yard','mountain','forest','coastal','desert','historic','in_town','summer','rural');

        $rules = array('rule_cermony', 'rule_pets');

        $houses = House::query();

		$filter_amenities = array();
        foreach ($amenities as $amenity) {
        	if($request[$amenity])
        		$filter_amenities[$amenity] = true;
        }
        $houses->where($filter_amenities);
        
        $filter_place = array();
		foreach ($place as $item) {
        	if($request[$item])
        		$filter_place[$item] = true;
        }

        $filter_room_types = array();
        foreach ($room_types as $room_type) {
            if($request[$room_type])
                array_push($filter_room_types, $room_type);
        }
        if(count($filter_room_types) > 0)
            $houses->wherein('type', $filter_room_types);

        $filter_rules = array();
        foreach ($rules as $rule) {
            if($request[$rule])
                $filter_rules[$rule] = true;
        }       
        $houses->where($filter_rules);

        $houses->where($filter_place);
        if(!isset($request['guests']))
            $houses->where('max_accommodates', '>=', urldecode($request['guests']));

        if(isset($request['bedroom_count']))
            $houses->where('rooms', urldecode($request['bedroom_count']));

        if(isset($request['bed_count']))
            $houses->where('beds', '>=', urldecode($request['bed_count']));

        #TODO: add search in village
        if(isset($request['city']))
        {
            $cities = explode(',', urldecode($request['city']));
            $houses->wherein('city', $cities);
            //$houses->where('city', 'like', urldecode($request['city']));
        }

        if(isset($request['province']))
        {
            $provinces = explode(',', urldecode($request['province']));
            $houses->wherein('province', $provinces);
            //$houses->where('province', 'like', urldecode($request['province']));
        }
        
        if(isset($request['destination']))
        {
            $destinations = explode(',', urldecode($request['destination']));
            if(count($destinations) != 1)
                $houses->where(function ($query) use ($destinations) {
                    $query->wherein('city', $destinations);//->orWherein('province', $destinations);
                });
            else
                $houses->where(function ($query) use ($request) {
                    $query->where('city', 'like', urldecode($request['destination']));
                    //$query->where('city', 'like', '%'.urldecode($request['destination']).'%')->orWhere('province', 'like', '%'.urldecode($request['destination']).'%');
                });
        }

        if(isset($request['price_max']))
            $houses->where('max_price', '<=', $request['price_max']);

        if(isset($request['price_min']))
            $houses->where('min_price', '>=', $request['price_min']);

        if(isset($request['id']))
            $houses->where('id', $request->id);

        if(isset($request['tag']))
            $houses->withAnyTag($request->tag);

        if(isset($request['min_accommodates']))
            $houses->where('max_accommodates', '>=',$request->min_accommodates);

        $result = $houses->bookable()->orderBy('id', 'desc')->paginate(20);

        foreach ($result as &$key) {
                $key->image = $key->photos()->where('is_cover', 1)->first()['thumbnail_path'];
                $key->user_picture = $key->user()->get()->first()['picture'];
        }
        return $result->makeHidden(['address','request_from','tel','temp','disabled', 'non_bookable']);
    }

    public function store(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

        $house = new House;
        $house->temp          = 1;
        $house->user_id       = $user->id;
        $house->request_from  = 'api';
        $house->save();
        return response()->json(['id' => $house->id], 200);
    }

    public function update(Request $request, $id)
    {
        $house = House::findOrFail($id);

        #TODO: change response type to json
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
            'max_price'         => 'required|integer|min:0',
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
        #Telegram notification
        if($house->temp) #Send notif for the first time
        {
            $this->dispatch(new SendAdminTelegramNotification('emails.newhouse', ['house' => $house], 'ثبت خانه جدید از اپلیکیشن #edit'));
            
            #Send Email to Admin
            $this->dispatch(new SendEmailNotification('emails.newhouse', ['house' => $house], 'ثبت خانه جدید از اپلیکیشن', ['info@shab.ir','security@shab.ir']));
        }
        else
        {
            $this->dispatch(new SendAdminTelegramNotification('emails.newhouse', ['house' => $house], 'ویرایش خانه از اپلیکیشن  #edit'));

            #Send Email to Admin
            $this->dispatch(new SendEmailNotification('emails.newhouse', ['house' => $house], 'ویرایش خانه از اپلیکیشن #edit', ['info@shab.ir','security@shab.ir']));
        }


        #update itmes
        $house->type              = $request->type;
        $house->title             = $request->title;
        $house->about             = $request->about;
        $house->description       = $request->description;
        $house->city              = $request->city;
        $house->province          = $request->province;
        $house->address           = $request->address;
        $house->accommodates      = $request->accommodates;
        if(!empty($request['tel']))
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
        $house->max_price         = $request->max_price;
        $house->land_area         = $request->land_area;
        $house->building_area     = $request->building_area;
        if(!empty($request['village']))
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
        if(!empty($request['place_desc']))
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
        if(!empty($request['rules_desc']))
        {
            $house->rules_desc           = $request->rules_desc;
        }
        if(!empty($request['discount_days_level1']))
        {
            $house->discount_days_level1 = $request->discount_days_level1;
        }
        if(!empty($request['discount_rate_level1']))
        {
            $house->discount_rate_level1 = $request->discount_rate_level1;
        }
        if(!empty($request['discount_days_level2']))
        {
            $house->discount_days_level2 = $request->discount_days_level2;
        }    
        if(!empty($request['discount_rate_level2']))
        {
            $house->discount_rate_level2 = $request->discount_rate_level2;
        }
        if(!empty($request['price_desc']))
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
        
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

    public function addHousePhoto(Request $request, $id)
    {
        #TODO: change request type to json
        $house = House::findOrFail($id);

        #TODO: change request type to json
        $this->authorize('edit', $house);

        $this->validate($request, [
            'image' => 'required|image',
            ]);
        $image = $request->image;
        //$image = $request->image;
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
        #TODO: change request type to json
        $house = House::findOrFail($id);

        #TODO: change request type to json
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

    public function getHouse($id)
    {
        $house = House::findOrFail($id);
        if(!isBookable($house))
            return response()->json(["status" => "failed", "error" => "not found or disabled"], 404);

        #Check house owner
        $user = JWTAuth::parseToken()->authenticate();
        if($user->id == $house->user_id)
            return $house->toJson();

        return $house->makeHidden(['tel', 'request_from', 'available_from', 'available_to', 'created_at', 'updated_at'])->toJson();
    }

    public function getHousePhotos($id)
    {
        $house  = House::findOrFail($id);
        $photos = $house->photos()->get();
        return $photos->toJson();
    }

    public function getHouseOwner($id)
    {
        #TODO: hide secret fields
        #TODO: not sending temp objects
        $house   = House::findOrFail($id);
        $profile = $house->user()->get()->first();

        return $profile->makeHidden(['mobile', 'username', 'email', 'tel', 'address', 'birthdate', 'gender', 'cardno', 'created_at', 'updated_at'])->toJson();
    }


    public function reserveByTel(Request $request, $id)
    {
        $this->validate($request, [
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            'guests'   => 'required|integer',
            'text'     => 'required|string|max:2047',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $house = House::findOrFail($id);

        if($request->guests > $house->accommodates)
            return response()->json([
                'status' => 'failed',
                'error'  => 'The accommodates of this house is not enough'
            ]);

        if($user->trips()->where('verified', 0)->whereDay('created_at', '=', date('Y-m-d'))->count() > 5)
            return response()->json([
                'status' => 'failed',
                'error'  => 'Your maximum requests exceeeds the limit!'
            ]);

        $reservation = new Reservation;
        $reservation->checkin       = $request->checkin;
        $reservation->checkout      = $request->checkout;
        $reservation->guests        = $request->guests;
        $reservation->verified      = 0;

        $reservation->guest_user_id = $user->id;
        $reservation->host_user_id  = $house->user->id;
        $reservation->house_id      = $house->id;

        $reservation->save();

        $message = new Message;
        $message->from_user_id = $user->id;
        $message->reservation_id = $reservation->id;
        $message->text = $request['text'];
        $message->save();

        #SMS to admins
        //$this->dispatch(new SendSMSNotification('یک درخواست رزرو جدید از اپلیکیشن در سامانه ثبت شد. شماره خانه: '.$reservation->house_id, array('09124490751', '09128268729', '09123401226')));

        #SMS to guest
        $this->dispatch(new SendSMSNotification('درخواست رزرو شما با موفقیت در سایت شب ثبت گردید. همکاران ما به زودی برای هماهنگی بیشتر با شما تماس خواهند گرفت.', array($reservation->guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو از اپلیکیشن #reserve'));

        #Email to admins
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو از اپلیکیشن', ['info@shab.ir','security@shab.ir']));

        return response()->json(['status' => 'success']);
    }

    public function setBookmark($id) {
        $user = JWTAuth::parseToken()->authenticate();
        $bookmark = Bookmark::where('user_id', $user->id)->where('house_id', $id)->first();
        if(empty($bookmark)) {
            Bookmark::create(array('user_id' => $user->id, 'house_id' => $id));
        }
        else {
            Bookmark::destroy($bookmark->id);
        }
        return response()->json(['status' => 'success']);
    }

    public function getBookmarks() {
        $user = JWTAuth::parseToken()->authenticate();
        $bookmarks = $user->bookmarks()->with('house')->orderBy('id', 'desc')->paginate(20);
        return $bookmarks->toJson();
    }

    public function destroy($id)
    {
        $house = House::findOrFail($id);
        $this->authorize('edit', $house);
        House::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function disableHouse($id)
    {
        $house = House::findOrFail($id);
        $this->authorize('edit', $house);
        if($house->disabled)
            $house->disabled= 0;
        else
            $house->disabled = 1;
        $house->save();
        return response()->json(['status' => 'success']);
    }

    public function test(Request $request)
    {                            
        $short_url = UrlShortener::shorten('http://google.com');
        return response()->json(['status' => 'success', 'url' => $short_url]);
    }
    
    /**
     * Change cover photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function setCoverPhoto(Request $request, $id)
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
}
