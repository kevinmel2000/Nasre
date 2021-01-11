<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koc extends Model
{
    protected $guarded = [];

    protected $table = 'koc';

    protected $fillable = ['code','description','abbreviation'];
    
 
}

