<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KocController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'koc_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $koc = Koc::orderby('id','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          return view('crm.master.koc', compact('user','koc','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $koc=Koc::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          return view('crm.master.koc', compact('user','koc','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    
}