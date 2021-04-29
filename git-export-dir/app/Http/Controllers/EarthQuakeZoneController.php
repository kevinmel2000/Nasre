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

            $earthquakezonecount = EarthQuakeZone::orderby('id','asc')->get();
            $lastid = count($earthquakezonecount);
            if($lastid != null){
                // $code_st = $mydate . strval($lastid + 1);

                if($lastid < 9){
                    $code_eqz = '00000' . strval($lastid + 1);
                }elseif($lastid > 8 && $lastid < 99){
                    $code_eqz = '0000' . strval($lastid + 1);
                }elseif($lastid > 98 && $lastid < 999){
                    $code_eqz = '000' . strval($lastid + 1);
                }elseif($lastid > 998 && $lastid < 9999){
                    $code_eqz = '00' . strval($lastid + 1);
                }elseif($lastid > 9998 && $lastid < 99999){
                    $code_eqz = '0' . strval($lastid + 1);
                }elseif($lastid > 99998 ){
                    $code_eqz =  strval($lastid + 1);
                }
            }
            else{
                $code_eqz = '00000' . strval(1);
            }
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $earthquakezone = EarthQuakeZone::orderby('id','desc')->paginate(10);
          $country = Country::orderby('id','asc')->get();

          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','country','code_eqz','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $earthquakezone=EarthQuakeZone::where('name', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $earthquakezone_ids = response()->json($earthquakezone->modelKeys());
          return view('crm.master.earthquakezone', compact('user','earthquakezone','route_active','earthquakezone_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'ezname'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            // dd($request);
            EarthQuakeZone::create([
                'name'=>$request->ezname,
                'code'=>$request->ezcode,
                'country_id'=>$request->ezcountry
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
            'nameez'=>'required'
        ]);

        // dd($eqzone);

        if($validator){
            
            $data=$request->all();
            $eqzones = EarthQuakeZone::find($eqzone);
            $eqzones->code = $request->codeez;
            $eqzones->name = $request->nameez;
            $eqzones->country_id = $request->countryez;
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