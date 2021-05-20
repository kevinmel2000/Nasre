<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipListTemp extends Model
{
    protected $guarded = [];
    protected $table = 'shiplist_detail';
    protected $fillable = ['insured_id','ship_code','ship_name'];

    public function insured(){
        return $this->belongsTo('App\Models\Insured', 'insured');
    }

    public function cedingdata(){
        return $this->belongsTo('App\Models\CedingBroker', 'ceding_id');
    }
}
