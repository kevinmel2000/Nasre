<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class TransLocationTemp extends Model
{
    //
    protected $guarded = [];

    protected $table = 'trans_location_temp';

    public function insured() 
    {
		return $this->belongsTo('App\Models\Insured','insured_id'); 
    }

    public function felookuplocation() 
    {
		return $this->belongsTo('App\Models\FeLookupLocation','lookup_location_id'); 
    }
}
