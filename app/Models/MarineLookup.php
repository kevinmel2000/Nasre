<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarineLookup extends Model
{
    protected $guarded = [];
    protected $table = 'marine_lookup';

    public function countryside(){
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function shiptype(){
        return $this->belongsTo('App\Models\ShipType', 'ship_type');
    }

    public function classify(){
        return $this->belongsTo('App\Models\Classification', 'classification');
    }

    public function construct(){
        return $this->belongsTo('App\Models\Construction', 'construction');
    }
}
