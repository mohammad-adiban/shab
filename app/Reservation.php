<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['refid', 'authority', 'created_at', 'updated_at'];

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function host()
    {
        return $this->belongsTo('App\User', 'host_user_id');
    }

    public function guest()
    {
        return $this->belongsTo('App\User', 'guest_user_id');
    }

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function review()
    {
        return $this->hasOne('App\Invoice');
    }
}
