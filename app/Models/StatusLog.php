<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
	// use SoftDeletes;
 //    protected $dates = ['deleted_at'];
    protected $table ="status_log";
    protected $timestamp = 'false';
    protected $guarded = [];
}
