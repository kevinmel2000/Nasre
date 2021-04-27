<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoleDetail extends Model
{
    protected $table = "hole_detail_temp";

    protected $guarded = [];

    public function golffieldhole()
    {
        return $this->belongsTo('App\Models\GolfFieldHole', 'golffieldhole_id');
    }
}
