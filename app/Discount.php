<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $fillable=['name','code','description','percent'];
   
    public function houses()
    {
        return $this->belongsToMany('App\House');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
