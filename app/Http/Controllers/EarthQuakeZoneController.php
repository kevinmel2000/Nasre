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
         $route_active = 'Earthquake Zone';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $earthquakezone = EarthQuakeZone::orderby('id','desc')->paginate(10);
          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $earthquakezone=EarthQuakeZone::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required',
            'flagdelete'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            EarthQuakeZone::create([
                'name'=>$request->name,
                'flag_delete'=>$request->flagdelete
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
    

    public function update(Request $request, $eqzone)
    {
        $validator = $request->validate([
            'name'=>'required',
            'flag_delete'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();
            $eqzones = EarthQuakeZone::find($eqzone);
            $eqzones->update($data);

            $notification = array(
                'message' => 'Earth QuakeZone updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy($id)
    {
        $earthquakezone = EarthQuakeZone::find($id);
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