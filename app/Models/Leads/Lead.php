<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];

    // Each contact can have one or more addresses
    public function address()
    {
        return $this->hasOne('App\Models\Address\Address');
    }

    // Each contact have one primary phone (first number found in the addressPhones is the primary contact number)
    public function phone(){
        return $this->hasOne('App\Models\Address\AddressPhone');
    }

    // Each contact have one primary email
    public function email(){
        return $this->hasOne('App\Models\Address\AddressEmail');
    }

    public function contactTitle(){
        return $this->belongsTo('App\Models\Contact\ContactTitle','title_id');
    }

    // Each contact belongs To industry
    public function industry(){
        return $this->belongsTo('App\Models\Industry');
    }

    public function leadSource(){
        return $this->belongsTo('App\Models\Leads\LeadSource');
    }

    public function leadStatus(){
        return $this->belongsTo('App\Models\Leads\LeadStatus');
    }

    public function leadOwner(){
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function note(){
        return $this->hasMany('App\Models\Note');
    }
}
