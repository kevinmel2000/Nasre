<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeductibleTemp extends Model
{
    protected $table = "deductible_temp";

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }

    public function DeductibleType()
    {
        return $this->belongsTo('App\Models\DeductibleType', 'deductibletype_id');
    }
}
