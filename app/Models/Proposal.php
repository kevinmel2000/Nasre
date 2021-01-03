<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $guarded = [];

    public function lead(){
        return $this->belongsTo('App\Models\Leads\Lead');
    }

    public function contact(){
        return $this->belongsTo('App\Models\Contact\Contact');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer\Customer');
    }

    public function currency(){
        return $this->belongsTo('App\Models\Currency');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'assigned_to');
    }

    public function proposalProducts(){
        return $this->hasMany('App\Models\ProposalProduct');
    }
}
