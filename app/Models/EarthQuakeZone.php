<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarthQuakeZone extends Model
{
    protected $guarded = [];

    protected $table = 'earthquake_zone';

    protected $fillable = ['name','flag_delete'];
 
}

