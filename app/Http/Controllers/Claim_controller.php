<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Claim_controller extends Controller
{
    public function index(){
    	$route_active = 'Claim';

    	return view('crm.transaction.claim.index',compact('route_active'));
    }
}
