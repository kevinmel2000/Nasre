<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Customer\Customer;
use App\Models\FeLookupLocation;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\PropertyType;
use App\Models\SlipTableFileTemp;
use App\Models\User;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\TransLocation;
use App\Models\Currency;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\KOC;
use App\Models\CedingBroker;
use App\Models\ConditionNeeded;
use App\Models\ShipListTemp;
use App\Policies\FelookupLocationPolicy;
use App\Models\TransLocationTemp;
use App\Models\TransProperty;
use App\Models\TransPropertyTemp;
use App\Models\Insured;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MovePropSlipController extends Controller
{

    public function getCountries(){
        $countries = DB::table('countries')->get();
        return response()->json([
            'message'=>'success',
            'countries'=>$countries
        ]);
    }

    public function getStates(Request $request, $id){
        if($request->ajax())
            return DB::table('states')->where(['country_id'=> $id])->get();
        else{
            return 0;
        }
    } 
    
    public function getCities(Request $request, $id){
        if($request->ajax())
            return DB::table('cities')->where(['state_id'=> $id])->get();
        else{
            return 0;
        }
    }

    public function getStateList(Request $request)
    {
        $states = DB::table("states")
        ->where("country_id",$request->country_id)
        ->pluck("name","id");
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $cities = DB::table("cities")
        ->where("state_id",$request->state_id)
        ->pluck("name","id");
        return response()->json($cities);
    }


    public function getCostumers(Request $request){

        $search = $request->search;
  
        if($search == ''){
           $costumers = Customer::orderby('company_name','asc')->select('id','company_name')->limit(10)->get();
        }else{
           $costumers = Customer::orderby('company_name','asc')->select('id','company_name')->where('company_name', 'like', '%' .$search . '%')->limit(10)->get();
        }
  
        $response = array();
        foreach($costumers as $costumer){
           $response[] = array("value"=>$costumer->id,"label"=>$costumer->company_name);
        }
  
        return response()->json($response);
     }
    
    public function index(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Moveable Property - Index';   
         $mydate = date("Y").date("m").date("d");
         $fe_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'mp')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

          return view('crm.transaction.mp_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'mp')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

        
          return view('crm.transaction.mp_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }


    public function indexmpslip()
    {
        $user = Auth::user();
        $route_active = 'Moveable Property - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        
        $country = Country::orderby('id','asc')->get();
        $city = City::orderby('id','asc')->get();
        $state = State::orderby('id','asc')->get();
        $costumer=Customer::orderby('id','asc')->get();

        
        $currdate = date("Y/m/d");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::orderby('id','asc')->get();
        $koc = KOC::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','ceding')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $mp_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $sliplastid = count($slip);

        if($lastid != null){
            $code_ms = 'mp'.$mydate . strval($lastid + 1);
            $code_sl = 'mp'.$mydate . strval($sliplastid + 1);

        }
        else{
            $code_sl = 'mp'.$mydate . strval($sliplastid + 1);
            $code_ms = 'mp'.$mydate . strval(1);
        }

        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();


        return view('crm.transaction.mp_slip', compact(['user','cnd','locationlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','mp_ids','code_ms','code_sl','costumer']));
    }

  

    public function storempinsured(Request $request)
    {
        $validator = $request->validate([
            'mpnumber'=>'required',
            'mpinsured'=>'required',
            'mpsuggestinsured'=>'required',
            'mpsuffix'=>'required',
            'mpshare'=>'required',
            'mpsharefrom'=>'required',
            'mpshareto'=>'required',
            'mpcoinsurance'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->mpnumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->mpnumber,
                    'slip_type'=>'mp',
                    'insured_prefix' => $request->mpinsured,
                    'insured_name'=>$request->mpsuggestinsured,
                    'insured_suffix'=>$request->mpsuffix,
                    'share'=>$request->mpshare,
                    'share_from'=>$request->mpsharefrom,
                    'share_to'=>$request->mpshareto,
                    'coincurance'=>$request->mpcoinsurance
                ]);

                $notification = array(
                    'message' => 'Moveable Property Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->insured_prefix=$request->mpinsured;
                $insureddataup->insured_name=$request->mpsuggestinsured;
                $insureddataup->insured_suffix=$request->mpsuffix;
                $insureddataup->share=$request->mpshare;
                $insureddataup->share_from=$request->mpsharefrom;
                $insureddataup->share_to=$request->mpshareto;
                $insureddataup->coincurance=$request->mpcoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Moveable Property Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }

           

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Fire & Engginering Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }


    public function destroy($id)
    {
        $insured = Insured::find($id);
        if($insured->delete())
        {
            $slip = SlipTable::where('insured_id', '=', $id);
            $slip->delete();

            $notification = array(
                'message' => 'Moveable Property Insured & Slip  deleted successfully!',
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
