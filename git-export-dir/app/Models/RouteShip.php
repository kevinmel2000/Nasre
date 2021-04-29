<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteShip extends Model
{
    protected $table = "route";
    protected $guarded =[];

    public function route_from()
    {
        return $this->belongsTo('App\Models\ShipPort', 'from');
    }

    public function route_to()
    {
        return $this->belongsTo('App\Models\ShipPort', 'to');
    }

    public function route_transit()
    {
        return $this->belongsTo('App\Models\ShipPort', 'transit_1');
    }

    public function route_transit_2()
    {
        return $this->belongsTo('App\Models\ShipPort', 'transit_2');
    }
}
