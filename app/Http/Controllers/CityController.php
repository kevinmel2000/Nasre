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

class CityController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'city_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $city = City::orderby('id','desc')->get();
          $city_ids = response()->json($koc->modelKeys());
          return view('crm.master.city', compact('user','city','route_active','city_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $city=City::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $city_ids = response()->json($koc->modelKeys());
          return view('crm.master.city', compact('user','city','route_active','city_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            City::create([
                'code'=>$request->code,
                'description'=>$request->description,
                'abbreviation'=>$request->abbreviation
            ]);
            $notification = array(
                'message' => 'City added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function destroy(City $city)
    {
        if($city->delete())
        {
            $notification = array(
                'message' => 'City deleted successfully!',
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