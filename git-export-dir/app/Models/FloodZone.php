<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloodZone extends Model
{
    protected $guarded = [];

    protected $table = 'flood_zone';

    protected $fillable = ['name','code','country_id'];

    public function country() 
    {
		return $this->belongsTo('App\Models\Country','country_id'); 
    }
    
 
}

