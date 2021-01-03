<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function owner(){
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer\Customer');
    }

    public function lead(){
        return $this->belongsTo('App\Models\Leads\Lead');
    }

}
