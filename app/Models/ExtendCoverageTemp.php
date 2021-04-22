<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendCoverageTemp extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "extended_coverage_detail";

    protected $guarded = [];

    public function extendcoveragedata()
    {
        return $this->belongsTo('App\Models\ExtendedCoverage', 'extendcoverage_id');
    }
}
