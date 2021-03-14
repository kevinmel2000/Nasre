<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class TransPropertyTemp extends Model
{
    //
    protected $guarded = [];

    protected $table = 'trans_property_temp';

    public function propertytypedata() 
    {
		return $this->belongsTo('App\Models\PropertyType','property_type_id'); 
    }
}
