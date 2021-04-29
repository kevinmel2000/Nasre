<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipType extends Model
{
    protected $guarded = [];
    protected $table = 'ship_type';
    protected $fillable = ['code','name'];
}
