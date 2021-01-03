<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function contacts(){
        return $this->hasMany('App\Models\Contact\Contact');
    }

    public function first_contact(){
        return $this->hasOne('App\Models\Contact\Contact')->where(['is_primary'=>'yes']);
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address\Address');
    }

       // Each contact belongs To industry
    public function industry(){
        return $this->belongsTo('App\Models\Industry');
    }
}
