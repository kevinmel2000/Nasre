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
          $country = Country::orderby('id','asc')->get();

          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids','country'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $cedingbroker=CedingBroker::where('code', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $cedingbroker_ids = response()->json($cedingbroker->modelKeys());
          $country = Country::orderby('id','asc')->get();

          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids','country'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }


    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required|max:5|unique:currencies,code',
            'name'=>'required',
            'companyname'=>'required',
            'address'=>'required',
            'crccountry'=>'required',
            'type'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            CedingBroker::create([
                'code'=>$request->code,
                'name' => $request->name,
                'company_name'=>$request->companyname,
                'address'=>$request->address,
                'country'=>$request->crccountry,
                'type'=>$request->type
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


    public function destroy($id)
    {
      $cedingbrokers = CedingBroker::find($id);
      
      if($cedingbrokers->delete())
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

    public function destroy2(CedingBroker $cedingbroker)
    {
        if($cedingbroker->delete())
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