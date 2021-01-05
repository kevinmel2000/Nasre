<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\CedingBroker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CedingBrokerController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'cedingbroker_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $felookuplocation = FeLookupLocation::orderby('id','desc')->get();
          $felookuplocation_ids = response()->json($felookuplocation->modelKeys());
          return view('crm.master.felookuplocation', compact('user','felookuplocation','route_active','felookuplocation_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $felookuplocation_ids = response()->json($felookuplocation->modelKeys());
          return view('crm.master.felookuplocation', compact('user','felookuplocation','route_active','felookuplocation_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    
}