<?php

namespace App\Http\Controllers\Office;

use App\Models\SMTP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechSettingsController extends Controller
{
    public function index()
    {
        $route_active = 'tech_setting';
        $smtp = SMTP::first();
        return view('crm.office.tech_setting', compact(['route_active', 'smtp']));
    }
}
