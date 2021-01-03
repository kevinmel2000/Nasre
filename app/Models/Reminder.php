<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function lead(){
        return $this->belongsTo('App\Models\Leads\Lead');
    }

    public function contact(){
        return $this->belongsTo('App\Models\Contact\Contact');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer\Customer');
    }
}
