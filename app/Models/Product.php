<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function productgroup(){
        return $this->belongsTo('App\Models\ProductGroup', 'product_group_id');
    }
}
