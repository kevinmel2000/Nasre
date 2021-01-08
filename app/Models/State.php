<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];

    protected $table = 'states';

    public function country() 
    {
		return $this->belongsTo('App\Models\Country','country_id'); 
    }

    public function city()
    {
      return $this->hasMany('App\Models\City','state_id');
    }
}
