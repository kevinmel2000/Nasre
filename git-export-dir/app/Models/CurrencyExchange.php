<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class CurrencyExchange extends Model
{
    //
    protected $guarded = [];

    protected $table = "currencies_exc";

    public function curr(){
        return $this->belongsTo('App\Models\Currency', 'currency');
    }
}
