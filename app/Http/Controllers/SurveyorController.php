<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\Surveyor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyorController extends Controller
{   
    

    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'Surveyor Master';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $surveyor = Surveyor::orderby('number')->get();
         
          $lastid = count($surveyor);
          $surveyor_ids = response()->json($surveyor->modelKeys());

            if($lastid != null)
            {

                if($lastid < 9){
                    $number_surveyor = '0' . strval($lastid + 1);
                }   
                elseif($lastid > 8 && $lastid < 99){
                    $number_surveyor = strval($lastid + 1);
                } 
            }
            else{
                $number_surveyor = '0' . strval(1);
                
            }
            
            return view('crm.master.surveyor', compact('user','surveyor','route_active','number_surveyor','surveyor_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
            //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
            $surveyor=Surveyor::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $surveyor_ids = response()->json($surveyor->modelKeys());
            return view('crm.master.surveyor', compact('user','surveyor','route_active','surveyor_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function generatecode(request $request)
    {
        $surveyor = Surveyor::where('number',$request->koc_code)->orderby('id','desc')->get();
        $lastid = count($surveyor);
         
        $parentlastcode = substr($surveyor->number,2) ;
        $sumlastcode = strval($parentlastcode + 1);

            if($parentlastcode < 9)
            {
                $number_surveyor = $surveyor->number . '0' . strval($parentlastcode + 1);
                return response()->json(
                    [
                        'autocode' => $number_surveyor
                    ]
                );
            }
            elseif($parentlastcode > 8 && $parentlastcode < 100)
            {
                $number_surveyor = $surveyor->number . strval($parentlastcode + 1);
                return response()->json(
                    [
                        'autocode' => $number_surveyor
                    ]
                );
            }
       
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'number'=>'required',
            'keterangan'=>'required'
        ]);
        
        if($validator)
        {
            //dd($request);
            //exit();
            
            $user = Auth::user();
            Surveyor::create([
                'number'=>$request->number,
                'keterangan'=> $request->keterangan
            ]);

            $notification = array(
                'message' => 'Surveyor added successfully!',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function update(Request $request, $surveyor)
    {
        $validator = $request->validate([
            'number'=>'required',
            'keterangan'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();

            // dd($data);
            $surveyors = Surveyor::find($surveyor);
            $surveyors->update($data);

            $notification = array(
                'message' => 'Surveyor updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);

        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }


    public function destroy($id)
    {
        $surveyor = Surveyor::find($id);
        if($surveyor->delete())
        {
            $notification = array(
                'message' => 'Surveyor deleted successfully!',
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