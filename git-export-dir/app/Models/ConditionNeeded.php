<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionNeeded extends Model
{
    protected $guarded = [];
    protected $table = 'condition_needed';
    
    public function cob()
    {
        return $this->belongsTo('App\Models\COB', 'cob_id');
    }
}
