<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestInsuredTemp extends Model
{
    protected $table = "interest_insured_detail";

    protected $guarded = [];

    public function interestinsureddata()
    {
        return $this->belongsTo('App\Models\InterestInsured', 'interest_id');
    }
}
