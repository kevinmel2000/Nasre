<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipListTemp extends Model
{
    protected $guarded = [];
    protected $table = 'shiplist_temp';
    protected $fillable = ['insured_id','ship_code','ship_name'];

    public function insured(){
        return $this->belongsTo('App\Models\Insured', 'insured');
    }
}
