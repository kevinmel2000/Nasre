<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function contact(){
        return $this->belongsTo('App\Models\Contact\Contact');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer\Customer');
    }

    public function currency(){
        return $this->belongsTo('App\Models\Currency');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'invoice_owner_id');
    }

    public function invoiceProducts(){
        return $this->hasMany('App\Models\InvoiceProduct');
    }

    public function payment_mode(){
        return $this->belongsTo('App\Models\PaymentMode');
    }

}
