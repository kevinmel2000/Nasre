<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\GolfFieldHole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GolfFieldHoleController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'golffieldhole_master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $golffieldhole = GolfFieldHole::orderby('id','desc')->get();
          $golffieldhole_ids = response()->json($golffieldhole->modelKeys());
          return view('crm.master.golffieldhole', compact('user','golffieldhole','route_active','golffieldhole_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $golffieldhole=GolfFieldHole::where('code', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $golffieldhole_ids = response()->json($golffieldhole->modelKeys());
          return view('crm.master.golffieldhole', compact('user','golffieldhole','route_active','golffieldhole_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required|max:5|unique:currencies,code',
            'golffield'=>'required',
            'holenumber'=>'required'
        ]);

        if($validator)
        {
            $user = Auth::user();
            GolfFieldHole::create([
                'code'=>$request->code,
                'golf_field'=>$request->golffield,
                'hole_number'=>$request->holenumber
            ]);
            $notification = array(
                'message' => 'Golf Field Hole  added successfully!',
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
                'message' => 'Golf Field Hole deleted successfully!',
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