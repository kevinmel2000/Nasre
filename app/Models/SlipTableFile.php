<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class SlipTableFile extends Model
{
    //
    protected $guarded = [];

    protected $table = 'slip_table_file';

    public function sliptable() 
    {
		return $this->belongsTo('App\Models\SlipTable','slip_id'); 
    }
}
