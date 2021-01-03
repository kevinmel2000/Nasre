<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  protected $guarded = [];

  public function owner(){
    return $this->belongsTo('App\Models\User', 'uploaded_by');
  }

}
