<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon; // for time
use App\House;
use SEO;
use DB;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SearchController extends Controller
{
	public function searchTag($tag)
    {
        $houses = House::with($tag);
        if($houses->count() > 0)
        {
            SEO::setTitle('شب | اجاره ویلا، اجاره آپارتمان، اجاره سوئیت '.$tag);
            SEO::setDescription('سایت شب | جامع ترین سایت اجاره ویلا در ایران، اجاره ویلا '.$tag.'، اجاره آپارتمان '.$tag.'، اجاره سوئیت '.$tag.'، اجاره روزانه ویلا '.$tag);
        }
        else
            SEO::setTitle('شب | اجاره ویلا، اجاره ویلا در شمال، اجاره سوئیت، کرایه ویلا');

        return view('search');
    }

    public function searchCity($city)
    {
        $houses = House::where('city', 'like', '%'.urldecode($city).'%');
        if($houses->count() > 0)
        {
            SEO::setTitle('شب | اجاره ویلا، اجاره آپارتمان، اجاره سوئیت در '.$city);
            SEO::setDescription('سایت شب | جامع ترین سایت اجاره ویلا در ایران، اجاره ویلا در '.$city.'، اجاره آپارتمان در '.$city.'، اجاره سوئیت در '.$city.'، اجاره روزانه ویلا در '.$city);
        }
        else
            SEO::setTitle('شب | اجاره ویلا، اجاره ویلا در شمال، اجاره سوئیت، کرایه ویلا');

        $seo_content = "";
        if($city == 'تهران')
            $seo_content = '<h2 style="font-size:15px">اجاره ویلا در تهران، اجاره ویلا در اطرف تهران</h2><br>
امروزه با پیشرفت گردشگری، بسیار از افراد علاقمند به اقامت در اطرف تهران  گردشگری در اطرف تهران، اقدام به سفر در شهرهایی نظیر، کردان، لواسان، فیروزکوه و... می کنند.<br>
<h2 style="font-size:15px">سایت شب، <a href="https://www.shab.ir/search?province=البرز,تهران">اجاره ویلا در اطراف تهران</a> را برای شما فراهم کرده است.</h2><br>
برای <a href="https://www.shab.ir/search?province=البرز,تهران">اقامت در اطرف تهران</a>، <a href="https://www.shab.ir/search?province=البرز,تهران">به ویلاهای اطراف تهران</a> خوب است سری بزنید به <a href="https://www.shab.ir/search/city/طالقان">اجاره ویلا در طالقان</a>، <a href="https://www.shab.ir/search/city/لواسان">اجاره ویلا در لواسان</a>، <a href="https://www.shab.ir/search/city/كردان>اجاره ویلا در کردان</a><br>
<h3 style="font-size:14px">اجاره ویلاهای استخردار در اطراف تهران</h3>';

        return view('search', ['seo_content' => $seo_content]);
    }

    public function searchProvince($province)
    {
        $houses = House::where('province', 'like', '%'.urldecode($province).'%');
        if($houses->count() > 0)
        {
            SEO::setTitle('شب | اجاره ویلا، اجاره آپارتمان، اجاره سوئیت در '.$province);
            SEO::setDescription('سایت شب | جامع ترین سایت اجاره ویلا در ایران، اجاره ویلا در '.$province.'، اجاره آپارتمان در '.$province.'، اجاره سوئیت در '.$province.'، اجاره روزانه ویلا در '.$province);
        }
        else
            SEO::setTitle('شب | اجاره ویلا، اجاره ویلا در شمال، اجاره سوئیت، کرایه ویلا');

        return view('search');
    }

    public function searchProvinceCity($province, $city)
    {
        $houses = House::where('province', 'like', '%'.urldecode($province).'%')->where('city', 'like', '%'.urldecode($city).'%');
        if($houses->count() > 0)
        {
            SEO::setTitle('شب | اجاره ویلا، اجاره آپارتمان، اجاره سوئیت در '.$province.'، '.$city);
            SEO::setDescription('سایت شب | جامع ترین سایت اجاره ویلا در ایران، اجاره ویلا در '.$city.', '.$province.'، اجاره آپارتمان در '.$city.', '.$province.'، اجاره سوئیت در '.$city.', '.$province.'، اجاره روزانه ویلا در '.$city.', '.$province);
        }
        else
            SEO::setTitle('شب | اجاره ویلا، اجاره ویلا در شمال، اجاره سوئیت، کرایه ویلا');

        return view('search');
    }

	public function showSearch(Request $request)
    {
        $this->validate($request, [
            'destination'  => 'string',
            'city'         => 'string|max:63',
        ]);

        if(is_null($request->destination) && is_null($request->city))
            SEO::setTitle('شب | سایت اجاره ویلا در شمال | جست و جو');
        else
        {
            SEO::setTitle('شب | سایت اجاره ویلا در شمال | اجاره ویلا در '.$request->destination.$request->city);
        }
        
        return view('search');
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

    public function search(Request $request)
    {
        //$result = DB::table('houses')->paginate(20);
        #TODO: input validation
        $this->validate($request, [
            'id'    	   => 'integer|min:1',
            'guests'       => 'integer|max:1000',
            'destination'  => 'string',
            'city'  	   => 'string|max:63',
            'province'     => 'string|max:63',
            'price_max'    => 'integer|min:1',
            'price_min'    => 'integer|min:1',
            //'checkin'      => 'integer|min:0',
            //'checkout'     => 'integer|min:0',
            'rooms'        => 'integer|min:0',
            'beds'  	   => 'integer|min:0',
            'tag'  	   	   => 'string|max:63',
            'min_accommodates' => 'integer|min:0',
            'phrase'  	   => 'string|max:128',
            'price_order'  => 'integer',
            'sortby'        => 'integer',
        ]);

        $houses = House::query();

        $room_types = array('villa','apartment','room');

        $structures = array('duplex','triplex','flat');

		$amenities = array('furniture','internet','elevator','indoor_pool','outdoor_pool','barbecue','heating','water_cooling','split_cooling','breakfast','television','parking','european_wc','kitchen_equipment','balcony','receiver','bathroom','pool', 'green_space', 'local_breakfast', 'bicycle', 'pool');

		$place =  array('detached','in_complex','janitor','private_yard','mountain','forest','coastal','desert','historic','in_town','summer','rural');

        $rules = array('rule_cermony', 'rule_pets');

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
        $houses->where($filter_place);

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
        
		if(isset($request['phrase']))
		{
	        #Search in users's name, family
	        $result_ids = House::bookable()->leftJoin('users', 'houses.user_id', '=', 'users.id')->where(function ($query) use ($request) {
	            $query->where('name', 'like', '%'.urldecode($request['phrase']).'%')->orWhere('family', 'like', '%'.urldecode($request['phrase']).'%');
	        })->pluck('houses.id');

			#Search in house's id, title
	        $houses->where(function ($query) use ($request, $result_ids) {
	                    $query->where('title', 'like', '%'.urldecode($request['phrase']).'%')->orWhere('houses.id', 'like', '%'.urldecode($request['phrase']).'%')->orWhereIn('houses.id', $result_ids);
	                });
	    }

        if(isset($request['guests']))
            $houses->where('max_accommodates', '>=', urldecode($request['guests']));

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

        switch ($request['price_order']) {
            case '0':
                $price_type = 'min_price';
                break;
            case '1':
                $price_type = 'median_price';
                break;
            case '2':
                $price_type = 'max_price';
                break;
            default:
                $price_type = 'min_price';
                break;
        }

        if(isset($request['price_max']))
            $houses->where($price_type, '<=', $request['price_max']);

        if(isset($request['price_min']))
            $houses->where($price_type, '>=', $request['price_min']);

		if(isset($request['bedroom_count']))
			$houses->where('rooms', urldecode($request['bedroom_count']));

		if(isset($request['bed_count']))
			$houses->where('beds', '>=', urldecode($request['bed_count']));

		if(isset($request['id']))
			$houses->where('id', $request->id);

		if(isset($request['tag']))
			$houses->withAnyTag($request->tag);

		if(isset($request['min_accommodates']))
            $houses->where('max_accommodates', '>=',$request->min_accommodates);

        //$result = $houses->where('temp', 0)->where('disabled', 0)->with('statistics')->orderBy('id', 'desc')->paginate(20);

        $houses->bookable()->leftJoin('house_statistics','houses.id','=','house_statistics.house_id')->select('houses.id','houses.title','houses.type','houses.about','houses.description','houses.city','houses.province','houses.max_accommodates','houses.longitude','houses.latitude','houses.max_price','houses.median_price','houses.min_price','houses.beds','houses.created_at','houses.updated_at','houses.rooms' ,'houses.accommodates' ,'houses.extra_person','house_statistics.house_id','house_statistics.reviews','house_statistics.cleanliness','house_statistics.value','house_statistics.accuracy','house_statistics.accessibility','house_statistics.neighborhood','house_statistics.host','house_statistics.photos','house_statistics.requests','house_statistics.reservations','house_statistics.views','house_statistics.bookmarks','house_statistics.rank');

        //newest==1
        //expensive==2
        //cheapest==3
        //top_reviews==4
        //top_photos==5
        //top_requests==6
        //top_reserves==7
        //top_views==8
        //top_likes==9
        //top_rank==10
        if(isset($request->sortby)){
            switch ($request->sortby){
                case (1):
                    $houses->orderBy('houses.created_at','desc');
                    break;
                case (2):
                    $houses->orderBy($price_type,'desc');
                    break;
                case (3):
                    $houses->orderBy($price_type,'asc');
                    break;
                case (4):
                    $houses->orderBy('reviews','desc');
                    break;
                case (5):
                    $houses->orderBy('photos','desc');
                    break;
                case (6):
                    $houses->orderBy('requests','desc');
                    break;
                case (7):
                    $houses->orderBy('reservations','desc');
                    break;
                case (8):
                    $houses->orderBy('views','desc');
                    break;
                case (9):
                    $houses->orderBy('bookmarks','desc');
                    break;
                case (10):
                    $houses->orderBy('rank','desc');
                    break;
            }
        }
        else{
            $houses->orderBy('rank','desc')->orderBy('houses.id','desc');
        }
        
        $result = $houses->paginate(18);

/*
        foreach ($result as &$key) {
                $key->image = $key->photos()->where('is_cover', 1)->first()['thumbnail_path'];
                $key->user_picture = $key->user()->get()->first()['picture'];
        }
*/
        return $result;
    }
 
   public function getHouses() {
        $houses = House::query(); // create query from model
		$allOptions = Input::all(); // input recieved from ajax call
		if(isset($allOptions['singles'])) {
			$singleOptions = $allOptions['singles'];
			$matchType = array();
			if(isset($allOptions['duplicates']['room_type'])) {
				$type = $allOptions['duplicates']['room_type']; 	
				foreach ($type as $key => $value) { // adds types to array
					array_push($matchType, $value);
				}
			} 
			if(isset($allOptions['duplicates']['amenities'])) {
				$amenities = $allOptions['duplicates']['amenities'];
				foreach ($amenities as $key => $value) { // adds amenities to array
					$matchAmenities[$value] = true;
				}
			} 
			if(!empty($singleOptions['des'])) {
				$singleOptions['des'] = trim(urldecode($singleOptions['des']));
				if(strpos($singleOptions['des'], ',') !== false) {
					$desArray = explode(',', $singleOptions['des'], 2);
					$city = trim($desArray[0]);
					$province = trim($desArray[1]);
					$houses->where('city', 'like', $city);
					$houses->where('province', 'like', $province);
				}
				else {
		            $houses->where(function ($query) use ($singleOptions) {
						$query->where('city', 'like', $singleOptions['des'])->orWhere('province', 'like', $singleOptions['des']);
		            });
				}
			}
			// 	$houses->where('checkin', '<=', urldecode($singleOptions['checkin']));
			// Log::info($city[0]);

			// if(isset($singleOptions['checkout']))
			// 	$houses->where('checkout', '>=', urldecode($singleOptions['checkout']));

			if(isset($singleOptions['bedroom_count']))
				$houses->where('rooms', '>=', urldecode($singleOptions['bedroom_count']));

			if(!empty($singleOptions['guests']))
				$houses->where('accommodates', '>=', urldecode($singleOptions['guests']));

			if(isset($singleOptions['bed_count']))
				$houses->where('beds', '>=', urldecode($singleOptions['bed_count']));
			if(isset($singleOptions['price_max']))
				$houses->where('min_price', '<=', urldecode($singleOptions['price_max']));
			if(isset($singleOptions['price_min']))
				$houses->where('min_price', '>=', urldecode($singleOptions['price_min']));

			if(isset($allOptions['duplicates']['amenities']))
				$houses->where($matchAmenities);

			if(isset($allOptions['duplicates']['room_type']))
				$houses->wherein('type',$matchType);

			if(isset($singleOptions['area_type']))
				$houses->where('area_type',urldecode($singleOptions['area_type']));

			#$result = $houses->orderBy('id', 'desc')->get();
			$result = $houses->bookable()->orderBy('id', 'desc')->paginate(18);

			foreach ($result as &$key) {
				$key->image = $key->photos()->get()->first()['thumbnail_path'];
				$key->user_picture = $key->user()->get()->first()['picture'];
			}

			#$result = array('items' => $result, 'length' => sizeof($result));
			return $result;
		}
		else {
			return array('items'=> array());
		}

    }

    private function isFree($checkin, $checkout, $house_checkin, $house_checkout) {
    	if(($checkin  >= $house_checkin and $checkin  <= $house_checkout) or
    	   ($checkout >= $house_checkin and $checkout <= $house_checkout) or
    	   ($checkin  <= $house_checkin and $checkout >= $house_checkout))
    		return false;
    	else
    		return true;
    }
}
	
