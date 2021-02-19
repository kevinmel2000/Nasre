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
         $route_active = 'Flood Zone Master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $floodzone = FloodZone::orderby('id','desc')->paginate(10);
          $floodzone_ids = response()->json($floodzone->modelKeys());
          return view('crm.master.floodzone', compact('user','floodzone','route_active','floodzone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $floodzone=FloodZone::where('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $floodzone_ids = response()->json($floodzone->modelKeys());
          return view('crm.master.floodzone', compact('user','floodzone','route_active','floodzone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            FloodZone::create([
                'name'=>$request->name,
                'flag_delete'=>$request->flagdelete
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
    
    public function update(Request $request, $floodzone)
    {
        $validator = $request->validate([
            'name'=>'required',
            'flag_delete'=>'required'
        ]);
        if($validator){
            
            //$floodzone->name = $request->nameflood;
            //$floodzone->flag_delete = $request->flagdeleteflood;
            //$floodzone->save();

            $data=$request->all();
            $floodzones = FloodZone::find($floodzone);
            $floodzones->update($data);

            $notification = array(
                'message' => 'FloodZone updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    
    public function destroy($id)
    {
        $floodzone = FloodZone::find($id);
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