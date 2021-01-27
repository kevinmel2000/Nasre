<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class InsuredTableFile extends Model
{
    //
    protected $guarded = [];

    protected $table = 'insured_table_file';

    public function insured() 
    {
		return $this->belongsTo('App\Models\Insured','insured_id'); 
    }
}
