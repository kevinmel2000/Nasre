<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\FloodZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FloodZoneController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'floodzone_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $floodzone = FloodZone::orderby('id','desc')->get();
          $floodzone_ids = response()->json($koc->modelKeys());
          return view('crm.master.floodzone', compact('user','floodzone','route_active','floodzone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $floodzone=FloodZone::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $floodzone_ids = response()->json($koc->modelKeys());
          return view('crm.master.floodzone', compact('user','floodzone','route_active','floodzone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required|max:5|unique:currencies,code',
            'description'=>'required',
            'abbreviation'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            FloodZone::create([
                'code'=>$request->code,
                'description'=>$request->description,
                'abbreviation'=>$request->abbreviation
            ]);
            $notification = array(
                'message' => 'Flood Zone added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function destroy(FloodZone $floodzone)
    {
        if($floodzone->delete())
        {
            $notification = array(
                'message' => 'Flood Zone deleted successfully!',
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