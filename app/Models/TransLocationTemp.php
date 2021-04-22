<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class TransLocationTemp extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    protected $table = 'trans_location_detail';

    public function insured() 
    {
		return $this->belongsTo('App\Models\Insured','insured_id'); 
    }

    public function felookuplocation() 
    {
		return $this->belongsTo('App\Models\FeLookupLocation','lookup_location_id'); 
    }
    
    public function interestdata()
    {  
       return $this->belongsTo('App\Models\InterestInsured', 'interest_id');
    }

    public function risklocationdetail()
    {  
       return $this->hasMany('App\Models\RiskLocationDetail', 'translocation_id');
    }
}
