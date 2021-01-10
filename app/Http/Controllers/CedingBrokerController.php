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
          $cedingbroker = CedingBroker::orderby('id','desc')->get();
          $cedingbroker_ids = response()->json($cedingbroker->modelKeys());
          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $cedingbroker=CedingBroker::where('code', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $cedingbroker_ids = response()->json($cedingbroker->modelKeys());
          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }

         public function store(Request $request)
         {
             $validator = $request->validate([
                 'crccode'=>'required|max:5|unique:currencies,code',
                 'crcsymbolname'=>'required',
                 'crccountry'=>'required'
             ]);
             
             if($validator)
             {
                 $user = Auth::user();
                 Currency::create([
                     'symbol_name'=>$request->crcsymbolname,
                     'is_base_currency' => '',
                     'code'=>$request->crccode,
                     'country'=>$request->crccountry
                 ]);
                 $notification = array(
                     'message' => 'Ceding broker added successfully!',
                     'alert-type' => 'success'
                 );
                 return back()->with($notification);
             }
             else
             {
                 return back()->with($validator)->withInput();
             }
         }
     
         public function destroy(Country $country)
         {
             if($country->delete())
             {
                 $notification = array(
                     'message' => 'Ceding Broker deleted successfully!',
                     'alert-type' => 'success'
                 );
                 return back()->with($notification);
             }
             else
             {
                 $notification = array(
                     'message' => 'Contact admin!',
                     'alert-type' => 'error'
                 );
                 return back()->with($notification);
             }
         }
    }

    
}