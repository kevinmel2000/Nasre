<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GolfFieldHole extends Model
{
    protected $guarded = [];

    protected $table = 'golf_field_hole';

    protected $fillable = ['code'];

}

