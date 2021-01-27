<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class SlipTableFileTemp extends Model
{
    //
    protected $guarded = [];

    protected $table = 'slip_table_file_temp';

    public function sliptable() 
    {
		return $this->belongsTo('App\Models\SlipTable','slip_id'); 
    }
}
