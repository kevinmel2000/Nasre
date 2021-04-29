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
         $route_active = 'Golf Field Hole';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $golffieldhole = GolfFieldHole::orderby('id','desc')->get();
          $golffieldhole_ids = response()->json($golffieldhole->modelKeys());
          $lastid = count($golffieldhole);

          if($lastid != null){
            // $code_gfh = $mydate . strval($lastid + 1);

            if($lastid < 9){
                $code_gfh = '00000' . strval($lastid + 1);
            }elseif($lastid > 8 && $lastid < 99){
                $code_gfh = '0000' . strval($lastid + 1);
            }elseif($lastid > 98 && $lastid < 999){
                $code_gfh = '000' . strval($lastid + 1);
            }elseif($lastid > 998 && $lastid < 9999){
                $code_gfh = '00' . strval($lastid + 1);
            }elseif($lastid > 9998 && $lastid < 99999){
                $code_gfh = '0' . strval($lastid + 1);
            }elseif($lastid > 99998 ){
                $code_gfh =  strval($lastid + 1);
            }
        }
        else{
            $code_gfh = '00000' . strval(1);
            // $code_gfh = $mydate . strval($lastid->id + 1);
        }


          return view('crm.master.golffieldhole', compact('user','golffieldhole','route_active','golffieldhole_ids','code_gfh'))->with('i', ($request->input('page', 1) - 1) * 10);
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
            'code'=>'required|unique:currencies,code',
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


    public function update(Request $request, GolfFieldHole $golf)
    {
        $validator = $request->validate([
            'codegolf'=>'required|unique:currencies,code',
            'golffieldgolf'=>'required',
            'holenumbergolf'=>'required'
        ]);

        if($validator){
            $golf->code = $request->codegolf;
            $golf->golf_field = $request->golffieldgolf;
            $golf->hole_number = $request->holenumbergolf;
            $golf->save();
            $notification = array(
                'message' => 'Golf Field Hole updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(GolfFieldHole $golf)
    {
        if($golf->delete())
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