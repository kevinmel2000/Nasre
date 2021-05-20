<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTypeTemp extends Model
{
    protected $table = "property_type_detail";

    protected $guarded = [];

    public function propertytypedata() 
    {
		 return $this->belongsTo('App\Models\PropertyType','property_type_id'); 
    }
}

