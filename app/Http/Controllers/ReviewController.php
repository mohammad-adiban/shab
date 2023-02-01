<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Reservation;
use App\Review;
use App\House;
use Auth;
use SEO;

use App\Jobs\SendAdminTelegramNotification;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('guest-reservation', $reservation);

        #check trip status
        if($reservation->status != 3)
            return redirect()->route('trips')->with('review', 'رزرو شما نهایی نشده است.');

        #check trip checkout time
        if($reservation->checkout > time())
            return redirect()->route('trips')->with('review', 'هنوز سفر شما به اتمام نرسیده است.');

        SEO::setTitle('شب | نظرسنجی جدید ');

        return view('userpanel.review', ['reservation' => $reservation]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('guest-reservation', $reservation);

        #check duplication
        if(Review::where('reservation_id', $id)->count() > 0)
            return redirect()->route('trips')->with('review', 'قبلا برای این سفر نظرتان را ثبت کرده اید.');

        #check trip status
        if($reservation->status != 3)
            return redirect()->route('trips')->with('review', 'رزرو شما نهایی نشده است.');

        #check trip checkout time
        if($reservation->checkout > time())
            return redirect()->route('trips')->with('review', 'هنوز سفر شما به اتمام نرسیده است.');

        $user = Auth::user();

        $this->validate($request, [
            'host'           =>  'required|integer|min:0|max:5',
            'value'          =>  'required|integer|min:0|max:5',
            'accuracy'       =>  'required|integer|min:0|max:5',
            'cleanliness'    =>  'required|integer|min:0|max:5',
            'neighborhood'   =>  'required|integer|min:0|max:5',
            'accessibility'  =>  'required|integer|min:0|max:5',
            'description'    =>  'required|string|max:4096',
        ]);

        $review = new Review;
        $review->reservation_id = $request->reservation;
        $review->host           = $request->host;
        $review->value          = $request->value;
        $review->accuracy       = $request->accuracy;
        $review->cleanliness    = $request->cleanliness;
        $review->neighborhood   = $request->neighborhood;
        $review->accessibility  = $request->accessibility;
        $review->description    = $request->description;
        $review->user_id        = $user->id;
        $review->confirmed      = 1;
        $review->save();

        #Update house statistics
        $this->updateReviewStatistics($review);
        $this->incrementReviewStatistics($review);

        #Notif
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['review' => $review], 'ثبت نظر جدید از وب #review'));

        return redirect()->route('trips')->with('review', 'OK');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);

        $this->authorize('guest-reservation', $review->reservation);

        SEO::setTitle('شب | ویرایش نظر ');

        return view('userpanel.review', ['review' => $review]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $this->authorize('guest-reservation', $review->reservation);

        $this->validate($request, [
            'host'           =>  'required|integer|min:0|max:5',
            'value'          =>  'required|integer|min:0|max:5',
            'accuracy'       =>  'required|integer|min:0|max:5',
            'cleanliness'    =>  'required|integer|min:0|max:5',
            'neighborhood'   =>  'required|integer|min:0|max:5',
            'accessibility'  =>  'required|integer|min:0|max:5',
            'description'    =>  'required|string|max:4096',
        ]);

        $review->host           = $request->host;
        $review->value          = $request->value;
        $review->accuracy       = $request->accuracy;
        $review->cleanliness    = $request->cleanliness;
        $review->neighborhood   = $request->neighborhood;
        $review->accessibility  = $request->accessibility;
        $review->description    = $request->description;
        $review->save();

        #Update house statistics
        $this->updateReviewStatistics($review);
        
        #Notif
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['review' => $review], 'ویرایش نظر از وب #review'));

        return redirect()->route('trips')->with('review-edit', 'OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * get house reviews
     *
     * @return \Illuminate\Http\Response
     */
    public function getHouseReviews($id)
    {
        $house  = House::findOrFail($id);

        $reviews = Review::where('confirmed', 1)->whereIn('reservation_id', $house->reservations()->pluck('id'))->select('reviews.id', 'user_id', 'description','reviews.created_at', 'checkin', 'name', 'family', 'picture')->leftJoin('users', 'reviews.user_id', '=', 'users.id')->leftJoin('reservations', 'reviews.reservation_id', '=', 'reservations.id')->orderBy('id', 'desc')->paginate(1000);

        return $reviews;
    }

    function updateReviewStatistics($review)
    {
        $stats = \App\HouseStatistics::firstOrNew(['house_id' => $review->reservation->house_id]);
        $stats->cleanliness   = $stats->cleanliness   + ($review->cleanliness   - $stats->cleanliness  ) / ($stats->reviews + 1);
        $stats->value         = $stats->value         + ($review->value         - $stats->value        ) / ($stats->reviews + 1);
        $stats->accuracy      = $stats->accuracy      + ($review->accuracy      - $stats->accuracy     ) / ($stats->reviews + 1);
        $stats->accessibility = $stats->accessibility + ($review->accessibility - $stats->accessibility) / ($stats->reviews + 1);
        $stats->neighborhood  = $stats->neighborhood  + ($review->neighborhood  - $stats->neighborhood ) / ($stats->reviews + 1);
        $stats->host          = $stats->host          + ($review->host          - $stats->host)          / ($stats->reviews + 1);
        $stats->rank          = $stats->rank          + (($stats->cleanliness + $stats->value + $stats->accuracy + $stats->accessibility + $stats->neighborhood + $stats->host) / 6 - $stats->rank)          / ($stats->reviews + 1);
        $stats->save();
    }

    function incrementReviewStatistics($review)
    {
        $stats = \App\HouseStatistics::firstOrNew(['house_id' => $review->reservation->house_id]);
        $stats->increment('reviews');
    }
}
