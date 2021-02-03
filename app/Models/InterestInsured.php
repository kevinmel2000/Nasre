<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestInsured extends Model
{
    protected $table = "interest_insured";
    protected $guarded = [];

    public function cob()
    {
        return $this->belongsTo('App\Models\COB', 'cob_id');
    }
}
