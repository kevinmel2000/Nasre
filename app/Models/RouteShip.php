<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteShip extends Model
{
    protected $table = "route";
    protected $guarded =[];

    public function ship_port()
    {
        return $this->belongsTo('App\Models\ShipPort', 'from');
    }
}
