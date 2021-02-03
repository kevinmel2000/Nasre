<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Insured;
use App\Models\Customer\Customer;
use App\Models\FeLookupLocation;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\SlipTableFileTemp;
use App\Models\InsuredTableFile;
use App\Models\InsuredTableFileTemp;
use App\Models\InsuredTableFormat;
use App\Models\InsuredTableFormatTemp;
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
use App\Models\User;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HeMotorSlipController extends Controller
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
         $route_active = 'HE & Motor - Index';   
         $mydate = date("Y").date("m").date("d");
         $fe_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', 'LIKE', 'hem%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

          return view('crm.transaction.hem_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', 'LIKE', 'hem%')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

        
          return view('crm.transaction.hem_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }


    public function indexhemslip()
    {
        
        $user = Auth::user();
        $route_active = 'HE & Motor - Slip Entry';
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
        $hem_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $sliplastid = count($slip);

        if($lastid != null){
            if($lastid < 10)
            {
                $code_ms = "IN" . $mydate . "0000" . strval($lastid + 1);
            }   
            elseif($lastid > 9 && $lastid < 100)
            {
                $code_ms = "IN" . $mydate . "000" . strval($lastid + 1);
            }
            elseif($lastid > 99 && $lastid < 1000)
            {
                $code_ms = "IN" . $mydate . "00" . strval($lastid + 1);
            }
            elseif($lastid > 999 && $lastid < 10000)
            {
                $code_ms = "IN" . $mydate . "0" . strval($lastid + 1);
            }
            elseif($lastid > 9999 && $lastid < 100000)
            {
                $code_ms = "IN" . $mydate  . strval($lastid + 1);
            }


        }
        else{
            $code_ms = "IN" . $mydate . "0000" . strval(1);
        }

        if($sliplastid != null){
            if($lastid < 10)
            {
                $code_sl =  "HEM". $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($lastid > 9 && $lastid < 100)
            {
                $code_sl =  "HEM". $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($lastid > 99 && $lastid < 1000)
            {
                $code_sl =  "HEM". $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($lastid > 999 && $lastid < 10000)
            {
                $code_sl =  "HEM". $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($lastid > 9999 && $lastid < 100000)
            {
                $code_sl = "HEM". $mydate . strval($sliplastid + 1);
            }

            
        }
        else{
            $code_sl =  "HEM" . $mydate . "0000" . strval(1);
        }



        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();


        return view('crm.transaction.hem_slip', compact(['user','cnd','locationlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','hem_ids','code_ms','code_sl','costumer']));
    }

    
    public function storeheminsured(Request $request)
    {
        $validator = $request->validate([
            'hemnumber'=>'required',
            'heminsured'=>'required',
            'hemsuggestinsured'=>'required',
            'hemsuffix'=>'required',
            'hemshare'=>'required',
            'hemsharefrom'=>'required',
            'hemshareto'=>'required',
            'hemcoinsurance'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->hemnumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->hemnumber,
                    'slip_type'=>'hem',
                    'insured_prefix' => $request->heminsured,
                    'insured_name'=>$request->hemsuggestinsured,
                    'insured_suffix'=>$request->hemsuffix,
                    'share'=>$request->hemshare,
                    'share_from'=>$request->hemsharefrom,
                    'share_to'=>$request->hemshareto,
                    'coincurance'=>$request->hemcoinsurance
                ]);

                $notification = array(
                    'message' => 'He & Motor Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->insured_prefix=$request->hemsinsured;
                $insureddataup->insured_name=$request->hemsuggestinsured;
                $insureddataup->insured_suffix=$request->hemsuffix;
                $insureddataup->share=$request->hemshare;
                $insureddataup->share_from=$request->hemsharefrom;
                $insureddataup->share_to=$request->hemshareto;
                $insureddataup->coincurance=$request->hemcoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'He & Motor Insured Update successfully!',
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


    public function storehemslip(Request $request,$code_ms)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
            'fesinsured'=>'required',
            'fessuggestinsured'=>'required',
            'fessuffix'=>'required',
            'fesshare'=>'required',
            'fessharefrom'=>'required',
            'fesshareto'=>'required',
            'fescoinsurance'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();

            if($slipdata==null)
            {
                Insured::create([
                    'number'=>$request->slipnumber,
                    'slip_type'=>'fe',
                    'insured_prefix' => $request->fesinsured,
                    'insured_name'=>$request->fessuggestinsured,
                    'insured_suffix'=>$request->fessuffix,
                    'share'=>$request->fesshare,
                    'share_from'=>$request->fessharefrom,
                    'share_to'=>$request->fesshareto,
                    'coincurance'=>$request->coincurance
                ]);

                $notification = array(
                    'message' => 'Hem Motor Slip added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);

                $insureddataup->insured_prefix=$request->fesinsured;
                $insureddataup->insured_name=$request->fessuggestinsured;
                $insureddataup->insured_suffix=$request->fessuffix;
                $insureddataup->share=$request->fesshare;
                $insureddataup->share_from=$request->fessharefrom;
                $insureddataup->share_to=$request->fesshareto;
                $insureddataup->coincurance=$request->coincurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Hem & Motor Slip Update successfully!',
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
                'message' => 'Hem & Motor Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }


    public function update(Request $request, $felookuplocation)
    {
        $validator = $request->validate([
            'loc_code'=>'required|max:15,code',
            'address'=>'required',
            'country_id'=>'required',
            'postal_code'=>'required',
            'eq_zone'=>'required',
            'flood_zone'=>'required'
        ]);

        if($validator){
            
            /*
            $felookuplocation->loc_code = $request->loccodefe;
            $felookuplocation->address = $request->addressfe;
            $felookuplocation->longtitude = $request->longtitudefe;
            $felookuplocation->latitude = $request->latitudefe;
            $felookuplocation->postal_code = $request->postal_codefe;
            $felookuplocation->country_id = $request->countryfe;
            $felookuplocation->province_id = $request->statefe;
            $felookuplocation->city_id = $request->cityfe;
            $felookuplocation->eq_zone = $request->eqzonefe;
            $felookuplocation->flood_zone = $request->floodzonefe;
            $felookuplocation->insured = $request->insuredfe;
            $felookuplocation->save();
            */

            $data=$request->all();
            $felookuplocations = FeLookupLocation::find($felookuplocation);
            $felookuplocations->update($data);

            $notification = array(
                'message' => 'Fire & Engineering Lookup Location updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
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
                'message' => 'He & Motor Insured & Slip deleted successfully!',
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
