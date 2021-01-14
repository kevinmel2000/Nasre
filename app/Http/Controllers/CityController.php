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
         $route_active = 'City Data Master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $city = City::orderby('id','desc')->paginate(10);
          $city_ids = response()->json($city->modelKeys());
          $state = State::orderby('id','asc')->get();
          return view('crm.master.city', compact('user','city','route_active','city_ids','state'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $city=City::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $city_ids = response()->json($city->modelKeys());
          $state = State::orderby('id','asc')->get();
          return view('crm.master.city', compact('user','city','route_active','city_ids','state'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required',
            'state'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            City::create([
                'name'=>$request->name,
                'state_id'=>$request->state,
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
    

    public function update(Request $request, City $city)
    {
        $validator = $request->validate([
            'namecity'=>'required|unique:currencies,code',
            'statecity'=>'required'
        ]);
        if($validator){
            $city->name = $request->namecity;
            $city->state_id = $request->statecity;
            $city->save();
            $notification = array(
                'message' => 'City updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
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