<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendCoverageTemp extends Model
{
    protected $table = "extended_coverage_detail";

    protected $guarded = [];

    public function extendcoveragedata()
    {
        return $this->belongsTo('App\Models\ExtendedCoverage', 'extendcoverage_id');
    }
}
