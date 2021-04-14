<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insured extends Model
{
    protected $table = "insured";
    protected $guarded =[];

    public function routeship()
    {
        return $this->belongsTo('App\Models\RouteShip', 'route');
    }

    public function ship_list()
    {
        return $this->belongsTo('App\Models\ShipPort', 'ship_detail');
    }

    public function lookuplocation()
    {
        return $this->belongsTo('App\Models\FeLookupLocation', 'location');
    }

}
