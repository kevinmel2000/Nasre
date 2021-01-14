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
         $route_active = 'Ceding / Broker';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $cedingbroker = CedingBroker::orderby('id','desc')->paginate(10);
          $cedingbroker_ids = response()->json($cedingbroker->modelKeys());
          $country = Country::orderby('id','asc')->get();
          $lastid = CedingBroker::select('id')->latest()->first();

          if($lastid != null){
            if($lastid->id == 9){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 10){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 99){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 100){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 999){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 1000){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }else{
                $code_ceding = $mydate . strval($lastid->id + 1);
            }
        }
        else{
            $code_ceding = $mydate . strval($lastid->id + 1);
        }

          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids','country','code_ceding'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $cedingbroker=CedingBroker::where('code', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $cedingbroker_ids = response()->json($cedingbroker->modelKeys());
          $country = Country::orderby('id','asc')->get();

          $lastid = CedingBroker::select('id')->latest()->first();

          if($lastid != null){
            if($lastid->id == 9){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 10){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 99){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 100){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 999){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 1000){
                $code_ceding = $mydate . strval($lastid->id + 1);
            }else{
                $code_ceding = $mydate . strval($lastid->id + 1);
            }
        }
        else{
            $code_ceding = $mydate . strval($lastid->id + 1);
        }

          return view('crm.master.cedingbroker', compact('user','cedingbroker','route_active','cedingbroker_ids','country','code_ceding'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }


    public function store(Request $request)
    {
        $validator = $request->validate([
            'codebroker'=>'required|max:12',
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
                'code'=>$request->codebroker,
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


    public function update(Request $request, CedingBroker $broker)
    {
        $validator = $request->validate([
            'codebroker'=>'required|max:12|unique:currencies,code',
            'namebroker'=>'required',
            'companynamebroker'=>'required',
            'addressbroker'=>'required',
            'crccountrybroker'=>'required',
            'typebroker'=>'required'
        ]);
        if($validator){
            $broker->code = $request->codebroker;
            $broker->name = $request->namebroker;
            $broker->company_name = $request->companynamebroker;
            $broker->address = $request->addressbroker;
            $broker->country = $request->crccountrybroker;
            $broker->type = $request->typebroker;
            $broker->save();
            $notification = array(
                'message' => 'Ceding Broker updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
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