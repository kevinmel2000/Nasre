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
         $route_active = 'KOC Data Master';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $koc = Koc::orderby('id','desc')->get();
          $kocparent = Koc::where('code','<',100)->orderby('code','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          
          return view('crm.master.koc', compact('user','koc','kocparent','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $koc=Koc::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $kocparent = Koc::where('parent_id','')->orderby('code','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          return view('crm.master.koc', compact('user','koc','kocparent','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function generatecode(request $request)
    {
        $koc_parent = Koc::where('id',$request->koc_code)->first();
        $koc = Koc::where('parent_id',$request->koc_code)->orderby('id','desc')->get();
        $lastid = count($koc);
        
        if($lastid > 0){
                $code_koc = $koc_parent->code . strval($lastid + 1);
        }
        elseif($lastid == 0){
            $code_koc =  $koc_parent->code  . strval(1);
        }
       

          return response()->json(
            [
                'autocode' => $code_koc
            ]
        );
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
            // dd($request);
            //exit();
            $user = Auth::user();
            Koc::create([
                'code'=>$request->code,
                'description'=> $request->description,
                'parent_id'=> $request->parent_id,
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
    

    public function update(Request $request, $koc)
    {
        $validator = $request->validate([
            'code'=>'required|unique:currencies,code',
            'description'=>'required',
            'abbreviation'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();

            // dd($data);
            $kocs = Koc::find($koc);
            $kocs->update($data);

            $notification = array(
                'message' => 'Koc updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);

        }
        else
        {
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