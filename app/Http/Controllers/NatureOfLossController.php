<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\NatureOfLoss;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NatureOfLossController extends Controller
{   

    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'Nature Of Loss Master';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $koc = NatureOfLoss::orderby('code')->get();
          $kocparent = NatureOfLoss::whereRaw('LENGTH(code) < 9')->orderby('code','desc')->get();
        //   $kocparent = NatureOfLoss::orderby('code')->get();
          $countparent= NatureOfLoss::where('parent_id',null)->where('code','<',100)->orderby('code','desc')->get();
          // dd($countparent);
          $lastid = count($countparent);
          $koc_ids = response()->json($koc->modelKeys());

          if($lastid != null){

            if($lastid < 9){
                $code_koc = '0' . strval($lastid + 1);
            }   
            elseif($lastid > 8 && $lastid < 99){
                $code_koc = strval($lastid + 1);
            } 
            
        }
        else{
            $code_koc = '0' . strval(1);
            
        }
          
          return view('crm.master.koc', compact('user','koc','kocparent','route_active','code_koc','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $koc=NatureOfLoss::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $kocparent = NatureOfLoss::where('parent_id','')->orderby('code','desc')->get();
          $koc_ids = response()->json($koc->modelKeys());
          return view('crm.master.koc', compact('user','koc','kocparent','route_active','koc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function generatecode(request $request)
    {
        $koc_parent = NatureOfLoss::where('id',$request->koc_code)->first();
        $koc = NatureOfLoss::where('parent_id',$request->koc_code)->orderby('id','desc')->get();
        $koclastparent = NatureOfLoss::where('parent_id',$request->koc_code)->orderby('id','desc')->first();
        $lastid = count($koc);
        
        if(!$koclastparent){
            $code_koc =  $koc_parent->code . '0' . strval(0);
            return response()->json(
                [
                    'autocode' => $code_koc
                ]
            );
        }
        else{
            
            $parentlastcode = substr($koclastparent->code,2) ;
            $sumlastcode = strval($parentlastcode + 1);

                if($parentlastcode < 9){
                    $code_koc = $koc_parent->code . '0' . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $code_koc
                        ]
                    );
                }elseif($parentlastcode > 8 && $parentlastcode < 100){
                    $code_koc = $koc_parent->code . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $code_koc
                        ]
                    );
                }
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
            // dd($request);
            //exit();
            $user = Auth::user();
            NatureOfLoss::create([
                'code'=>$request->code,
                'description'=> $request->description,
                'parent_id'=> $request->parent_id,
                'abbreviation'=>$request->abbreviation
            ]);
            $notification = array(
                'message' => 'NatureOfLoss added successfully!',
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
            $kocs = NatureOfLoss::find($koc);
            $kocs->update($data);

            $notification = array(
                'message' => 'NatureOfLoss updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);

        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }


    public function destroy(NatureOfLoss $koc)
    {
        if($koc->delete())
        {
            $notification = array(
                'message' => 'NatureOfLoss deleted successfully!',
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