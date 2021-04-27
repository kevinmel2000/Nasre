<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    protected $guarded = [];
    protected $table = 'construction';
    protected $fillable = ['code','name'];

}
