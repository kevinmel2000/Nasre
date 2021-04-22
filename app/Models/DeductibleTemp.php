<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeductibleTemp extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "deductible_type_detail";

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
