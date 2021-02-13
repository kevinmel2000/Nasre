<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Customer\Customer;
use App\Models\FeLookupLocation;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\SlipTableFileTemp;
use App\Models\TransLocation;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\CedingBroker;
use App\Models\ConditionNeeded;
use App\Models\ShipListTemp;
use App\Policies\FelookupLocationPolicy;
use App\Models\TransLocationTemp;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\Insured;
use App\Models\InterestInsured;
use App\Models\InterestInsuredTemp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Currency;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\InstallmentTemp;
use App\Models\StatusLog;
use App\Models\RetrocessionTemp;

class FinancialLineSlipController extends Controller
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
         $route_active = 'Financial Lines - Index';   
         $mydate = date("Y").date("m").date("d");
         $fe_ids = response()->json($country->modelKeys());
         
        
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'fl')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

          return view('crm.transaction.fl_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'fl')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

        
          return view('crm.transaction.fl_slip_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }


    public function indexflslip()
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $route_active = 'Financial Lines - Slip Entry';
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
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','ceding')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();

        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();


        $fl_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $sliplastid = count($slip);

        
        if($lastid != null){
            if($lastid < 10)
            {
                $code_ms = "IN" . $userid ."". $mydate . "0000" . strval($lastid + 1);
            }   
            elseif($lastid > 9 && $lastid < 100)
            {
                $code_ms = "IN" . $userid ."". $mydate . "000" . strval($lastid + 1);
            }
            elseif($lastid > 99 && $lastid < 1000)
            {
                $code_ms = "IN" . $userid ."". $mydate . "00" . strval($lastid + 1);
            }
            elseif($lastid > 999 && $lastid < 10000)
            {
                $code_ms = "IN" . $userid ."". $mydate . "0" . strval($lastid + 1);
            }
            elseif($lastid > 9999 && $lastid < 100000)
            {
                $code_ms = "IN" . $userid ."". $mydate  . strval($lastid + 1);
            }


        }
        else{
            $code_ms = "IN" . $userid ."". $mydate . "0000" . strval(1);
        }

        if($sliplastid != null){
            if($sliplastid < 10)
            {
                $code_sl = "FL". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($sliplastid > 9 && $sliplastid < 100)
            {
                $code_sl = "FL". $userid ."". $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 99 && $sliplastid < 1000)
            {
                $code_sl = "FL". $userid ."". $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 999 && $sliplastid < 10000)
            {
                $code_sl = "FL". $userid ."". $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 9999 && $sliplastid < 100000)
            {
                $code_sl = "FL". $userid ."". $mydate . strval($sliplastid + 1);
            }

            
        }
        else{
            $code_sl = "FL". $userid ."". $mydate . "0000" . strval(1);
        }


        $interestinsured= InterestInsured::orderby('id','asc')->get();
        
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();

        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();


        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
       

        return view('crm.transaction.fl_slip', compact(['user','cnd','statuslist','retrocessionlist','installmentlist','deductibletype','extendcoveragelist','deductiblelist','extendedcoverage','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fl_ids','code_ms','code_sl','costumer']));
    
    }

    

    public function updateflslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
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
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $code_sl=$slipdata->number;

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fl_slipupdate', compact(['user','cnd','statuslist','filelist','slipdata','insureddata','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function detailflslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
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
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $code_sl=$slipdata->number;

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fl_slipdetail', compact(['user','cnd','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }

    public function storeflinsured(Request $request)
    {
        $validator = $request->validate([
            'flnumber'=>'required',
            'flinsured'=>'required',
            'flsuggestinsured'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->flnumber)->first();
            $locationlist= TransLocationTemp::where('insured_id','=',$request->flnumber)->orderby('id','desc')->get();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->flnumber,
                    'slip_type'=>'fl',
                    'insured_prefix' => $request->flinsured,
                    'insured_name'=>$request->flsuggestinsured,
                    'insured_suffix'=>$request->flsuffix,
                    'share'=>$request->flshare,
                    'share_from'=>$request->flsharefrom,
                    'share_to'=>$request->flshareto,
                    'coincurance'=>$request->flcoinsurance,
                    'obligee'=>$request->flobligee,
                    'principal'=>$request->flprincipal,
                    'location'=>$locationlist->toJson()
                ]);

                $notification = array(
                    'message' => 'Financial Line  Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->insured_prefix=$request->flinsured;
                $insureddataup->slip_type='fl';
                $insureddataup->insured_name=$request->flsuggestinsured;
                $insureddataup->insured_suffix=$request->flsuffix;
                $insureddataup->share=$request->flshare;
                $insureddataup->share_from=$request->flsharefrom;
                $insureddataup->share_to=$request->flshareto;
                $insureddataup->coincurance=$request->flcoinsurance;
                $insureddataup->obligee=$request->flobligee;
                $insureddataup->principal=$request->flprincipal;
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->save();


                $notification = array(
                    'message' => 'Financial Line Insured Update successfully!',
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
                'message' => 'Financial Line Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }


    public function storeflslip(Request $request,$code_ms)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
            'slipuy'=>'required',
            'slipstatus'=>'required',
            'slippolicy_no'=>'required',
            'slipcndn'=>'required',
            'slipno'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             

            if($slipdata==null)
            {
                $currdate = date("Y/m/d");

                SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>Auth::user()->name,
                    'insured_id'=>$request->code_ms,
                    'slip_type'=>'fl',
                    'prod_year' => $currdate,
                    'uy'=>$request->slipuy,
                    'status'=>$request->slipstatus,
                    'endorsment'=>$request->sliped,
                    'selisih'=>$request->slipsls,
                    'source'=>$request->slipcedingbroker,
                    'source_2'=>$request->slipceding,
                    'currency'=>$request->slipcurrency,
                    'cob'=>$request->slipcob,
                    'koc'=>$request->slipkoc,
                    'occupacy'=>$request->slipoccupacy,
                    'build_cost'=>$request->slipbld_const,
                    'slip_no'=>$request->slipno,
                    'cn_dn'=>$request->slipcndn,
                    'policy_no'=>$request->slippolicy_no,
                    'attacment_file'=>'',
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'extend_coverage'=>$extendcoveragelist->toJson(),
                    'insurance_period_from'=>$request->slipipfrom,
                    'insurance_perido_to'=>$request->slipipto,
                    'reinsurance_period_from'=>$request->sliprpfrom,
                    'reinsurance_period_to'=>$request->sliprpto,
                    'proportional'=>$request->slipproportional,
                    'layer_non_proportional'=>$request->sliplayerproportional,
                    'rate'=>$request->sliprate,
                    'share'=>$request->slipshare,
                    'sum_share'=>$request->slipsumshare,
                    'basic_premium'=>$request->slipbasicpremium,
                    'commission'=>$request->slipcommission,
                    'grossprm_to_nr'=>$request->slipgrossprmtonr,
                    'netprm_to_nr'=>$request->slipnetprmtonr,
                    'sum_commission'=>$request->slipsumcommission,
                    'installment_panel'=>$installmentlist->toJson(),
                    'retrocession_panel'=>$retrocessionlist->toJson(),
                    'retro_backup'=>$request->sliprb,
                    'own_retention'=>$request->slipor,
                    'sum_own_retention'=>$request->slipsumor

                ]);
                
                $notification = array(
                    'message' => 'Financial Line Slip added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $currdate = date("Y/m/d");

                $slipdataid=$slipdata->id;
                $slipdataup = SlipTable::findOrFail($slipdataid);
                
                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
                $slipdataup->slip_type='fl';
                $slipdataup->prod_year=$currdate;
                $slipdataup->uy=$request->slipuy;
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment=$request->sliped;
                $slipdataup->selisih=$request->slipsls;
                $slipdataup->source=$request->slipcedingbroker;
                $slipdataup->source_2=$request->slipceding;
                $slipdataup->currency=$request->slipcurrency;
                $slipdataup->cob=$request->slipcob;
                $slipdataup->koc=$request->slipkoc;
                $slipdataup->occupacy=$request->slipoccupacy;
                $slipdataup->build_cost=$request->slipbld_const;
                $slipdataup->slip_no=$request->slipno; 
                $slipdataup->cn_dn=$request->slipcndn; 
                $slipdataup->policy_no=$request->slippolicy_no; 
                $slipdataup->attacment_file=''; 
                $slipdataup->interest_insured=$interestlist->toJSon();
                $slipdataup->total_sum_insured=$request->sliptotalsum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->extend_coverage=$extendcoveragelist->toJson();  
                $slipdataup->insurance_period_from=$request->slipipfrom;  
                $slipdataup->insurance_perido_to=$request->slipipto;  
                $slipdataup->reinsurance_period_from=$request->sliprpfrom;  
                $slipdataup->reinsurance_period_to=$request->sliprpto;
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate;  
                $slipdataup->share=$request->slipshare;
                $slipdataup->sum_share=$request->slipsumshare;
                $slipdataup->basic_premium=$request->slipbasicpremium;
                $slipdataup->commission=$request->slipcommission; 
                $slipdataup->grossprm_to_nr=$request->slipgrossprmtonr; 
                $slipdataup->netprm_to_nr=$request->slipnetprmtonr; 
                $slipdataup->sum_commission=$request->slipsumcommission;  
                $slipdataup->installment_panel=$installmentlist->toJson();   
                $slipdataup->retrocession_panel=$retrocessionlist->toJson(); 
                $slipdataup->retro_backup=$request->sliprb;
                $slipdataup->own_retention=$request->slipor;
                $slipdataup->sum_own_retention=$request->slipsumor;
  
                
                $slipdataup->save();


                $notification = array(
                    'message' => 'Financial Line Slip Update successfully!',
                    'alert-type' => 'success'
                );
            
            }

            StatusLog::create([
                'status'=>$request->slipstatus,
                'user'=>Auth::user()->name,
                'insured_id'=>$request->code_ms,
                'slip_id'=>$request->slipnumber,
            ]);


            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Financial Line Slip added Failed!',
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
                'message' => 'Financial Line Insured & Slip  deleted successfully!',
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
