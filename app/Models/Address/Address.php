<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    public function contact(){
        return $this->belongsTo('App\Models\Contact\Contact');
    }

    public function lead(){
        return $this->belongsTo('App\Models\Leads\Lead');
    }

    public function addressPhones(){
        return $this->hasMany('App\Models\Address\AddressPhone');
    }

    public function addressEmails(){
        return $this->hasMany('App\Models\Address\AddressEmail');
    }
}
