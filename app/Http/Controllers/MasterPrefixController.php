<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Models\MasterPrefix;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MasterPrefixController extends Controller
{   

    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'Master Prefix';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $prefixdata = MasterPrefix::orderby('code')->get();
          $lastid = count($prefixdata);
          $prefixdata_ids = response()->json($prefixdata->modelKeys());

            if($lastid != null)
            {

                if($lastid < 9){
                    $number_prefixdata = '0' . strval($lastid + 1);
                }   
                elseif($lastid > 8 && $lastid < 99){
                    $number_prefixdata = strval($lastid + 1);
                } 
                
            }
            else
            {
                $number_prefixdata = '0' . strval(1);
                
            }
          
          return view('crm.master.masterprefix', compact('user','prefixdata','route_active','number_prefixdata','prefixdata_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $prefixdata=MasterPrefix::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $prefixdata_ids = response()->json($prefixdata->modelKeys());
          return view('crm.master.masterprefix', compact('user','prefixdata','route_active','prefixdata_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }


    public function generatecode(request $request)
    {
            $prefixdata = MasterPrefix::where('code',$request->number_prefix)->orderby('id','desc')->get();
            $lastid = count($prefixdata);
         
            $parentlastcode = substr($prefixdata->code,2) ;
            $sumlastcode = strval($parentlastcode + 1);

                if($parentlastcode < 9)
                {
                    $number_prefixdata = $prefixdata->code . '0' . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_prefixdata
                        ]
                    );
                }
                elseif($parentlastcode > 8 && $parentlastcode < 100)
                {
                    $number_prefixdata = $prefixdata->code . strval($parentlastcode + 1);
                    return response()->json(
                        [
                            'autocode' => $number_prefixdata
                        ]
                    );
                }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required',
            'prefix'=>'required'
        ]);
        
        if($validator)
        {
            // dd($request);
            //exit();
            $user = Auth::user();
            MasterPrefix::create([
                'code'=>$request->code,
                'prefix'=> $request->prefix
            ]);
            $notification = array(
                'message' => 'Master prefix added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }
    

    public function update(Request $request, $masterprefixdata)
    {
        $validator = $request->validate([
            'code'=>'required',
            'prefix'=>'required'
        ]);

        if($validator){
            
            $data=$request->all();

            // dd($data);
            $masterprefix = MasterPrefix::find($masterprefixdata);
            $masterprefix->update($data);

            $notification = array(
                'message' => 'Master Prefix updated successfully!',
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
        $masterprefixdata = MasterPrefix::find($id);
        if($masterprefixdata->delete())
        {
            $notification = array(
                'message' => 'Master Prefix Data deleted successfully!',
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