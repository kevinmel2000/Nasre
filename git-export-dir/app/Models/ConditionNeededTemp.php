<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionNeededTemp extends Model
{
	
    protected $table = "condition_needed_detail";
    protected $guarded = [];

    public function conditionneeded()
    {
        return $this->belongsTo('App\Models\ConditionNeeded', 'condition_id');
    }
}
