<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family', 'email', 'password', 'mobile',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'family', 'picture', 'mobile', 'email', 'credit', 'created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function houses()
    {
        return $this->hasMany('App\House');
    }
   
    public function reservations()
    {
        return $this->hasMany('App\Reservation', 'host_user_id');
    }

    public function trips()
    {
        return $this->hasMany('App\Reservation', 'guest_user_id');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\Bookmark');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function discounts()
    {
        return $this->belongsToMany('App\Discount');
    }

    public function account()
    {
        return $this->hasOne('App\Account');
    }
}
