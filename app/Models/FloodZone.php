<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloodZone extends Model
{
    protected $guarded = [];

    protected $table = 'flood_zone';

    protected $fillable = ['name','flag_delete'];
    
 
}

