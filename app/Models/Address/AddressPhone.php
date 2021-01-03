<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class AddressPhone extends Model
{
    protected $guarded = [];

    public function address(){
        return $this->belongsTo('App\Models\Address\Address');
    }
}
