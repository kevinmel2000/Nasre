<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class COB extends Model
{
    //
    protected $guarded = [];

    protected $table = 'cob';

    public function cobparent()
    {
        return $this->belongsTo('App\Models\COB', 'parent_id');
    }
}
