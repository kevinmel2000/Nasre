<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedCoverage extends Model
{
    protected $table = "extended_coverage";
    protected $guarded =[];

    public function cob()
    {
        return $this->belongsTo('App\Models\COB', 'cob_id');
    }
}
