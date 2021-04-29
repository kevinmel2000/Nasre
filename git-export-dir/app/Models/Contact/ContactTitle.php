<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactTitle extends Model
{
    protected $table = 'contact_titles';
    protected $fillable = ['name'];
}
