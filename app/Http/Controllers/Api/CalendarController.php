<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Calendar;
use App\House;
use DateTime;

class CalendarController extends Controller
{
    public function addCalendar(Request $request)
    {
        $this->validate($request, [
            'house'        => 'required|integer|min:1',
            'date'  	   => 'required|date',
            'price'		   => 'integer|min:1',
            'disabled'     => 'boolean',
        ]);

        #Authorization
        $house = House::findOrFail($request['house']);
        $this->authorize('edit', $house);

        $calendar = $house->calendars()->where('date', $request->date)->first();
        if(is_null($calendar))
            $calendar = new Calendar;

        $calendar->date           = $request->date;    
        
        if(!empty($request['price']))
        {
            $calendar->price 	  = $request->price;
        }
        else
            in_weekend(new DateTime($request->date)) ? $house->median_price : $house->min_price;

        if(!empty($request['disabled']))
        {
           $calendar->disabled = $request->disabled;
        }

        $calendar->house_id = $house->id;
        $calendar->save();
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

   	public function editCalendar(Request $request, $id)
    {
		$this->validate($request, [
            'price'		   => 'integer|min:1',
            'disabled'  => 'boolean',
        ]);

        #Authorization
        $calendar = Calendar::findOrFail($id);
        $this->authorize('edit', $calendar->house()->first());

        if(isset($request['price']))
        {
           $calendar->price 	  = $request->price;
        }

        if(isset($request['disabled']))
        {
           $calendar->disabled = $request->disabled;
        }

        $calendar->save();
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

    public function getCalendar(Request $request)
    {
		$this->validate($request, [
            'house' => 'required|integer|min:1',
            'start'	=> 'required|date',
        ]);

        $house = House::findOrFail($request['house']);

        $calendars = $house->calendars()->where('date','>=', $request->start)->orderBy('date','asc')->take(31)->get();
        return $calendars->makeHidden(['created_at','updated_at'])->toJson();
    }
}
