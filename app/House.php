<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Request;
use Log;

class House extends Model
{
    use \Conner\Tagging\Taggable;

    protected $appends = ['bookmarked', 'photo', 'photos'];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
     /**
     * Get header photo of the house.
     *
     * @return array of base64
     */
    public function getPhotoAttribute()
    {
        $cover_photo = $this->photos()->where('is_cover', 1)->first();
        if(is_null($cover_photo))
            return $this->photos()->first();

        return $cover_photo;
    }

    /**
     * Get photos of the house.
     *
     * @return array of base64
     */
    public function getPhotosAttribute()
    {
        return \App\Photo::where('house_id',$this->id)->orderBy('is_cover','desc')->get();
    }

    /* Get if the house is bookmarked by the user.
     *
     * @return boolean
     */
    public function getBookmarkedAttribute()
    {
        $user = Auth::user();
        if(!empty($user))
            $bookmark = Bookmark::where('user_id', $user->id)->where('house_id', $this->id)->first();        

        return empty($bookmark)?"0":"1";
    }

    public function calendars()
    {
        return $this->hasMany('App\Calendar');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function statistics()
    {
        return $this->hasOne('App\HouseStatistics');
    }

    public function discounts()
    {
        return $this->belongsToMany('App\Discount');
    }

    /**
     * Scope a query to only include bookable houses.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBookable($query)
    {
        return $query->where('temp', 0)->where('disabled', 0)->where('non_bookable', '0');
    }
}
