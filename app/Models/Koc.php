<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koc extends Model
{
    protected $guarded = [];

    protected $table = 'koc';

    protected $fillable = ['code','description','abbreviation'];
    
 
    public function koc()
    {
        return $this->belongsTo('App\Models\Koc', 'parent_id');
    }
}

