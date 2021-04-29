<?php

namespace App\Models\Contact;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];
    // Each contact have one primary phone (first number found in the addressPhones is the primary contact number)
    public function phone(){
        return $this->hasOne('App\Models\Address\AddressPhone');
    }

    public function language(){
        return $this->belongsTo('App\Models\Language');
    }

    // Each contact have one primary email
    public function email(){
        return $this->hasOne('App\Models\Address\AddressEmail');
    }

    public function title(){
        return $this->belongsTo('App\Models\Contact\ContactTitle');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer\Customer');
    }
 
}
