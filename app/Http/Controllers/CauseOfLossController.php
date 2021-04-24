<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\MasterCauseOfLoss;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CauseOfLossController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'Cause Of Loss Master';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $causeofloss = MasterCauseOfLoss::orderby('number')->get();
          $lastid = count($causeofloss);
          $causeofloss_ids = response()->json($causeofloss->modelKeys());

          if($lastid != null){

            if($lastid < 9){
                $number_causeofloss = '0' . strval($lastid + 1);
            }   
            elseif($lastid > 8 && $lastid < 99){
                $number_causeofloss = strval($lastid + 1);
            } 
           
        }
        else
        {
            $number_causeofloss = '0' . strval(1);
            
        }
          
          return view('crm.master.causeofloss', compact('user','causeofloss','route_active','number_causeofloss','causeofloss_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          $causeofloss=MasterCauseOfLoss::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $causeoflossparent = MasterCauseOfLoss::where('id','')->orderby('number','desc')->get();
          $causeofloss_ids = response()->json($causeofloss->modelKeys());
          return view('crm.master.causeofloss', compact('user','causeofloss','route_active','number_causeofloss','causeofloss_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    
    public function generatecode(request $request)
    {
        $causeofloss = MasterCauseOfLoss::where('number',$request->number_causeofloss)->orderby('id','desc')->get();
        $lastid = count($causeofloss);
        
            $parentlastcode = substr($causeofloss->number,2) ;
            $sumlastcode = strval($parentlastcode + 1);

                if($parentlastcode < 9)
                {
                    $number_causeofloss = $causeofloss->number . '0' . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_causeofloss
                        ]
                    );
                }
                elseif($parentlastcode > 8 && $parentlastcode < 100)
                {
                    $number_causeofloss = $causeofloss->number . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_causeofloss
                        ]
                    );
                }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'number'=>'required|unique',
            'nama'=>'required',
            'keterangan'=>'required'
        ]);
        
        if($validator)
        {
            // dd($request);
            //exit();
            $user = Auth::user();
            MasterCauseOfLoss::create([
                'number'=>$request->number,
                'keterangan'=> $request->keterangan,
                'nama'=> $request->nama
            ]);
            $notification = array(
                'message' => 'MasterCauseOfLoss  added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function update(Request $request, $masteroflossdata)
    {
        $validator = $request->validate([
            'number'=>'required|unique',
            'nama'=>'required',
            'keterangan'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();

            // dd($data);
            $masterofloss = MasterCauseOfLoss::find($masteroflossdata);
            $masterofloss->update($data);

            $notification = array(
                'message' => 'MasterCauseOfLoss  updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);

        }
        else
        {
            return back()->with($validator)->withInput();
        }

    }


    public function destroy(MasterCauseOfLoss  $masterofloss)
    {
        
        if($masterofloss->delete())
        {
            $notification = array(
                'message' => 'MasterCauseOfLoss  deleted successfully!',
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