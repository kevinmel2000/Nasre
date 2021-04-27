<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = [];

    protected $fillable = ['symbol_name','code','country'];

    protected $table = "currencies";

    public function countryside(){
        return $this->belongsTo('App\Models\Country', 'country');
    }
}
