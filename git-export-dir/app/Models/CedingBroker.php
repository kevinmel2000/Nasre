<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CedingBroker extends Model
{
    protected $guarded = [];

    protected $table = 'ceding_broker';

    protected $fillable = ['code','name','company_name','address','country','type'];

    public function countryside(){
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function companytype(){
        return $this->belongsTo('App\Models\CompanyType', 'type');
    }

}

