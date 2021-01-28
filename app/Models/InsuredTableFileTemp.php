<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class InsuredTableFileTemp extends Model
{
    //
    protected $guarded = [];

    protected $table = 'insured_table_file_temp';

    public function insured() 
    {
		return $this->belongsTo('App\Models\Insured','insured_id'); 
    }
}
