<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $guarded = [];
    protected $table = 'classification';
    protected $fillable = ['code','name'];

}
