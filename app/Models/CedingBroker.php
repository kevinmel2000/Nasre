<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CedingBroker extends Model
{
    protected $guarded = [];

    protected $table = 'ceding_broker';

    protected $fillable = ['code'];

}

