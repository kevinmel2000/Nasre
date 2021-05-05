<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;\
use Illuminate\Database\Eloquent\SoftDeletes;

class RetrocessionTemp extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "retrocession_panel_detail";

    protected $guarded = [];

}
