<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class RiskLocationDetail extends Model
{
    //
    protected $guarded = [];

    protected $table = 'risk_location_detail';

    public function translocation() 
    {
		return $this->belongsTo('App\Models\TransLocation','translocation_id'); 
    }
    
    public function translocationtemp()
    {  
       return $this->belongsTo('App\Models\TransLocationTemp', 'translocation_id');
    }
}
