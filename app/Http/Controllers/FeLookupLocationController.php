<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\FeLookupLocation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeLookupLocationController extends Controller
{

    public function getCountries(){
        $countries = DB::table('countries')->get();
        return response()->json([
            'message'=>'success',
            'countries'=>$countries
        ]);
    }

    public function getStates(Request $request, $id){
        if($request->ajax())
            return DB::table('states')->where(['country_id'=> $id])->get();
        else{
            return 0;
        }
    } 
    
    public function getCities(Request $request, $id){
        if($request->ajax())
            return DB::table('cities')->where(['state_id'=> $id])->get();
        else{
            return 0;
        }
    } 

    
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'felookuplocation_master';   

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
