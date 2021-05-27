<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koc extends Model
{
    protected $guarded = [];

    protected $table = 'koc';

    protected $fillable = ['code','description','abbreviation','parent_id'];
    
 
    public function kocparent()
    {
        return $this->belongsTo('App\Models\Koc', 'parent_id');
    }
}

