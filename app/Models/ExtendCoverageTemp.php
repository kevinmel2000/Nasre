<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendCoverageTemp extends Model
{
    protected $table = "extendcoverage_temp";

    protected $guarded = [];

    public function extendcoverage()
    {
        return $this->belongsTo('App\Models\ExtendedCoverage', 'extendcoverage_id');
    }
}
