<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\EarthQuakeZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EarthQuakeZoneController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'earthquakezone_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $earthquakezone = EarthQuakeZone::orderby('id','desc')->get();
          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $earthquakezone=EarthQuakeZone::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            EarthQuakeZone::create([
                'code'=>$request->code,
                'description'=>$request->description,
                'abbreviation'=>$request->abbreviation
            ]);
            $notification = array(
                'message' => 'Earth Quake Zone added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function destroy(EarthQuakeZone $earthquakezone)
    {
        if($earthquakezone->delete())
        {
            $notification = array(
                'message' => 'Earth Quake Zone deleted successfully!',
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