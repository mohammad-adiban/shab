<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Calendar;
use App\House;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;

class CalendarController extends Controller
{
    public function disableCalendarInterval(Request $request, $from, $to)
    {
        $this->validate($request, [
            'house' => 'required|integer|min:1',
        ]);

        #Authorization
        $house = House::findOrFail($request['house']);
        if(Auth::user()->id != 4 && Auth::user()->id != 1) #Ahmad & Foad
            return response()->json(['permission_denied'], 403);

        $interval = DateInterval::createFromDateString('1 day');

        $checkin_dt = new DateTime($from);
        $checkout_dt = new DateTime($to);

        $period  = new DatePeriod($checkin_dt, $interval, $checkout_dt);

        foreach ($period as $dt)
        {
            $cal = Calendar::where('house_id', $house->id)->where('date', $dt->format("Y-m-d"))->first();
            if(is_null($cal))
            {
                $calendar = new Calendar;
                $calendar->house_id = $house->id;
                $calendar->date = $dt->format("Y-m-d");
                $calendar->price = in_weekend($dt) ? $house->median_price : $house->min_price;
                $calendar->unavailable = 1;
                $calendar->save();
            }
            else
            {
                $cal->unavailable = 1;
                $cal->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ]);
    }

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

        $calendar->date 	  	  = $request->date;

        if(isset($request['price']))
        {
            $calendar->price 	  = $request->price;
        }
        else
            in_weekend(new DateTime($request->date)) ? $house->median_price : $house->min_price;

        if(isset($request['disabled']))
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

        $calendars = $house->calendars()->where('date','>=', $request->start)->orderBy('date','asc')->get();
        return array_merge(['calendars' => $calendars->makeHidden(['created_at','updated_at'])->toArray()], ['peak_days' => getPeakDays()]);
    }
}
