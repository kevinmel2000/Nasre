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
          $natureofloss = NatureOfLoss::orderby('number')->get();
          $lastid = count($natureofloss);
          $natureofloss_ids = response()->json($natureofloss->modelKeys());

            if($lastid != null)
            {

                if($lastid < 9){
                    $number_natureofloss = '0' . strval($lastid + 1);
                }   
                elseif($lastid > 8 && $lastid < 99){
                    $number_natureofloss = strval($lastid + 1);
                } 
                
            }
            else
            {
                $number_natureofloss = '0' . strval(1);
                
            }
          
          return view('crm.master.natureofloss', compact('user','natureofloss','route_active','number_natureofloss','natureofloss_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $natureofloss=NatureOfLoss::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $natureofloss_ids = response()->json($koc->modelKeys());
          return view('crm.master.natureofloss', compact('user','natureofloss','route_active','natureofloss_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }


    public function generatecode(request $request)
    {
            $natureofloss = NatureOfLoss::where('number',$request->number_natureofloss)->orderby('id','desc')->get();
            $lastid = count($natureofloss);
         
            $parentlastcode = substr($natureofloss->number,2) ;
            $sumlastcode = strval($parentlastcode + 1);

                if($parentlastcode < 9)
                {
                    $number_natureofloss = $natureofloss->number . '0' . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_natureofloss
                        ]
                    );
                }
                elseif($parentlastcode > 8 && $parentlastcode < 100)
                {
                    $number_natureofloss = $natureofloss->number . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_natureofloss
                        ]
                    );
                }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'number'=>'required|unique',
            'accident'=>'required',
            'keterangan'=>'required'
        ]);
        
        if($validator)
        {
            // dd($request);
            //exit();
            $user = Auth::user();
            NatureOfLoss::create([
                'number'=>$request->number,
                'keterangan'=> $request->nama,
                'accident'=> $request->accident
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
    

    public function update(Request $request, $natureoflossdata)
    {
        $validator = $request->validate([
            'number'=>'required|unique',
            'accident'=>'required',
            'keterangan'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();

            // dd($data);
            $natureofloss = NatureOfLoss::find($natureoflossdata);
            $natureofloss->update($data);

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


    public function destroy(NatureOfLoss $natureoflossdata)
    {
        if($natureoflossdata->delete())
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