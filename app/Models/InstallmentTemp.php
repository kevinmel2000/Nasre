<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentTemp extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "installment_panel_detail";

    protected $guarded = [];

}
