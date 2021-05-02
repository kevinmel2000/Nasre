<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Models\TransLocation;
use App\Models\Currency;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use Illuminate\Support\Facades\Auth;


class Claim_controller extends Controller
{
    public function index()
    {
    	$route_active = 'Claim';

    	return view('crm.transaction.claim.index',compact('route_active'));
    }

    public function indexclaim()
    {

    }

    public function storeclaiminsured(Request $request)
    {

    }

}

