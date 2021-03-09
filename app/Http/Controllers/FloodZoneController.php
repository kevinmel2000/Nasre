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
            $floodzonecount = FloodZone::orderby('id','asc')->get();
            $lastid = count($floodzonecount);
            if($lastid != null){
                // $code_st = $mydate . strval($lastid + 1);

                if($lastid < 10){
                    $code_flz = '00000' . strval($lastid + 1);
                }elseif($lastid > 9 && $lastid < 100){
                    $code_flz = '0000' . strval($lastid + 1);
                }elseif($lastid > 99 && $lastid < 1000){
                    $code_flz = '000' . strval($lastid + 1);
                }elseif($lastid > 999 && $lastid < 10000){
                    $code_flz = '00' . strval($lastid + 1);
                }elseif($lastid > 9999 && $lastid < 100000){
                    $code_flz = '0' . strval($lastid + 1);
                }elseif($lastid > 99999 ){
                    $code_flz =  strval($lastid + 1);
                }
            }
            else{
                $code_flz = '00000' . strval(1);
            }
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $floodzone = FloodZone::orderby('id','desc')->paginate(10);
          $country = Country::orderby('id','asc')->get();
          
          $floodzone_ids = response()->json($floodzone->modelKeys());
          return view('crm.master.floodzone', compact('user','country','code_flz','floodzone','route_active','floodzone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            'flzname'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            FloodZone::create([
                'name'=>$request->flzname,
                'code'=>$request->flzcode,
                'country_id'=>$request->flzcountry
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
            'nameflz'=>'required'
        ]);
        if($validator){
            
            //$floodzone->name = $request->nameflood;
            //$floodzone->flag_delete = $request->flagdeleteflood;
            //$floodzone->save();

            $data=$request->all();
            $floodzones = FloodZone::find($floodzone);
            $floodzones->code = $request->codeflz;
            $floodzones->name = $request->nameflz;
            $floodzones->country_id = $request->countryflz;
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