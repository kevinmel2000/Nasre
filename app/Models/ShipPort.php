<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipPort extends Model
{
    protected $table = "ship_port";
    protected $guarded =[];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }


}
