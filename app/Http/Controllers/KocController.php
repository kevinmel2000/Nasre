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

class KocController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'koc_master';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $koc = Koc::orderby('id','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          $lastid = Koc::select('id')->latest()->first();

          if($lastid != null){
            if($lastid->id == 9){
                $code_koc = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 10){
                $code_koc = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 99){
                $code_koc = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 100){
                $code_koc = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id == 999){
                $code_koc = $mydate . strval($lastid->id + 1);
            }elseif($lastid->id >= 1000){
                $code_koc = $mydate . strval($lastid->id + 1);
            }else{
                $code_koc = $mydate . strval($lastid->id + 1);
            }
        }
        else{
            $code_koc = $mydate . strval($lastid->id + 1);
        }


          return view('crm.master.koc', compact('user','koc','route_active','koc_ids','code_koc'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $koc=Koc::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          return view('crm.master.koc', compact('user','koc','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required|unique:currencies,code',
            'description'=>'required',
            'abbreviation'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            Koc::create([
                'code'=>$request->code,
                'description'=>$request->description,
                'abbreviation'=>$request->abbreviation
            ]);
            $notification = array(
                'message' => 'Koc added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function update(Request $request, Koc $koc)
    {
        $validator = $request->validate([
            'codekoc'=>'required|unique:currencies,code',
            'descriptionkoc'=>'required',
            'abbreviationkoc'=>'required'
        ]);
        if($validator){
            $koc->code = $request->codekoc;
            $koc->description = $request->descriptionkoc;
            $koc->abbreviation = $request->abbreviationkoc;
            $koc->save();
            $notification = array(
                'message' => 'Koc updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }


    public function destroy(Koc $koc)
    {
        if($koc->delete())
        {
            $notification = array(
                'message' => 'Koc deleted successfully!',
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