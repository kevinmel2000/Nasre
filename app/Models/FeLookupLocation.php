<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeLookupLocation extends Model
{
    protected $guarded = [];

    protected $table = 'fe_lookup_location';

    protected $fillable = ['loc_code','address','longtitude','latitude'];

    public function country() 
    {
		return $this->belongsTo('App\Models\Country','country_id'); 
    }

    public function state() 
    {
		return $this->belongsTo('App\Models\State','province_id'); 
    }

    public function city() 
    {
		return $this->belongsTo('App\Models\City','city_id'); 
    }
}

