<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    //
    protected $guarded = [];

    protected $table = 'occupation';

    public function cobs()
    {
        return $this->belongsTo('App\Models\COB', 'cob');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\Occupation', 'parent_id');
    }

    public function latest($column = 'created_at')
    {
        return $this->orderBy($column, 'desc');
    } 
}
