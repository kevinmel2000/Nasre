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
use App\Models\Currency;
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
use App\Models\InstallmentTemp;
use App\Models\InterestInsuredTemp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\StatusLog;
use App\Models\RetrocessionTemp;


class FeSlipController extends Controller
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

    public function getStateLookup(Request $request)
    {
        $states = DB::table("fe_lookup_location")
        ->join('states', 'fe_lookup_location.province_id', '=', 'states.id')
        ->where("fe_lookup_location.country_id",$request->country_id)
        ->pluck("states.name","fe_lookup_location.province_id");
        return response()->json($states);
    }

    public function getCityLookup(Request $request)
    {
        $cities = DB::table("fe_lookup_location")
        ->join('cities', 'fe_lookup_location.city_id', '=', 'cities.id')
        ->where("fe_lookup_location.province_id",$request->state_id)
        ->pluck("cities.name","fe_lookup_location.city_id");
        return response()->json($cities);
    }

    public function getAddressLookup(Request $request)
    {
        $address = DB::table("fe_lookup_location")
        ->where("city_id",$request->city_id)
        ->pluck("address","id");
        return response()->json($address);
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
         $route_active = 'Fire Engineering - Index';   
         $mydate = date("Y").date("m").date("d");
         $fe_ids = response()->json($country->modelKeys());
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($insured->modelKeys());

          return view('crm.transaction.fe_slip_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'fe')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'fe')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($insured->modelKeys());
        
          return view('crm.transaction.fe_slip_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }


    public function indexfeslip()
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','fe')->orderby('id','asc')->get();
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
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

        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();

        if($sliplastid != null){
            if($sliplastid < 10)
            {
                $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($sliplastid > 9 && $sliplastid < 100)
            {
                $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 99 && $sliplastid < 1000)
            {
                $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 999 && $sliplastid < 10000)
            {
                $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 9999 && $sliplastid < 100000)
            {
                $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + 1);
            }

            
        }
        else{
            $code_sl = "FE". $userid ."". $mydate . "0000" . strval(1);
        }

        $kondisi=false;
        $i=1;
        while($kondisi==false)
        {
            $slipdatatest=SlipTable::where('number',$code_sl)->first();
            if(empty($slipdatatest) || $slipdatatest==NULL)
            {
                $kondisi=true;
            }
            else
            {
                if($sliplastid < 10)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + $i);
                }
            }

            $i++;
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
        
        if(count($interestlist) != null){
            InterestInsuredTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($locationlist) != null){
            TransLocationTemp::where('insured_id', $code_ms)->delete();
        }

        if(count($deductiblelist) != null){
            DeductibleTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($extendcoveragelist) != null){
            ExtendCoverageTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($installmentlist) != null){
            InstallmentTemp::where('slip_id', $code_sl)->delete();
        }
        
        if(count($retrocessionlist) != null){
            RetrocessionTemp::where('slip_id', $code_sl)->delete();
        }

        return view('crm.transaction.fe_slip', compact(['user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function updatefeslip($idm)
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
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
        // dd($insureddata->number);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id',$insureddata->number)->first();
        $slipdata2=SlipTable::where('insured_id',$insureddata->number)->get();
        // dd($slipdata);

        if(!empty($slipdata))
        {      
                $code_sl=$slipdata->number;
                $slip = SlipTable::orderby('id','asc')->get();
                $sliplastid = count($slip);
                
                $kondisi=false;
                $i=1;
                while($kondisi==false)
                {
                    $slipdatatest=SlipTable::where('number',$code_sl)->first();
                    if(empty($slipdatatest) || $slipdatatest==NULL)
                    {
                        $kondisi=true;
                    }
                    else
                    {
                        if($sliplastid < 10)
                        {
                            $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                        }   
                        elseif($sliplastid > 9 && $sliplastid < 100)
                        {
                            $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 99 && $sliplastid < 1000)
                        {
                            $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 999 && $sliplastid < 10000)
                        {
                            $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 9999 && $sliplastid < 100000)
                        {
                            $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + $i);
                        }
                    }

                    $i++;
                }

        }
        else
        {
            $slip = SlipTable::orderby('id','asc')->get();
            $sliplastid = count($slip);

            if($sliplastid != null){
                if($sliplastid < 10)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + 1);
                }
    
                
            }
            else{
                $code_sl = "FE". $userid ."". $mydate . "0000" . strval(1);
            }


            $slipdata=SlipTable::orderBy('id', 'desc')->first();
        }


        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipupdate', compact(['user','userid','cnd','slipdata2','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function endorsementfeslip($ms,$sl)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
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
        
        $code_ms=$ms;
        $code_sl=$sl;
        
        $insureddata=Insured::where('number',$code_ms)->first();
        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();


        if($slipdata==NULL || empty($slipdata) || $code_ms==0 || $code_sl==0)
        {

            $insureddata=Insured::where('slip_type','fe')->orderby('id','desc')->first();
            $slipdata=SlipTable::where('insured_id',$insureddata->number)->orderby('id','desc')->first();
            
            $code_ms=$insureddata->number;
            $countendorsement =$slipdata->slip_idendorsementcount;
            if($slipdata->slip_idendorsementcount==NULL || $slipdata->slip_idendorsementcount=="")
            {
                $code_sl = $slipdata->number . '-END' . '000' . '1';
            }
            else 
            {
                if($countendorsement < 10)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 9 && $countendorsement < 100)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 99 && $countendorsement < 1000)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 999 && $countendorsement < 10000)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . ($countendorsement + 1);
                }
            }

            if($slipdata->prev_endorsement==NULL || $slipdata->prev_endorsement=="")
            {
                $slipdata->prev_endorsement=$sl;
            }
        
        
        }
        else
        {

            $countendorsement =$slipdata->slip_idendorsementcount;
            if($slipdata->slip_idendorsementcount==NULL || $slipdata->slip_idendorsementcount=="")
            {
                $code_sl = $slipdata->number . '-END' . '000' . '1';
            }
            else 
            {
                if($countendorsement < 10)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 9 && $countendorsement < 100)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 99 && $countendorsement < 1000)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 999 && $countendorsement < 10000)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . ($countendorsement + 1);
                }
            }

            if($slipdata->prev_endorsement==NULL || $slipdata->prev_endorsement=="")
            {
                $slipdata->prev_endorsement=$sl;
            }

        }

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipendorsement', compact(['user','cnd','slipdata2','countendorsement','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }

    public function detailfeslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
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
        // dd($insureddata->number);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id',$insureddata->number)->first();
        $slipdata2=SlipTable::where('insured_id',$insureddata->number)->get();
        // dd($slipdata);
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
            

        return view('crm.transaction.fe_slipdetail', compact(['user','slipdata2','cnd','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function getdetailSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->first();
    
       

        $interestdata=json_decode($slipdata->interest_insured);   
        $newarray=[];

        if(!empty($interestdata))
        {
            foreach($interestdata as $mydata)
            {
                $interestdatadesc= InterestInsured::where('id','=',$mydata->interest_id)->first();
                $mydata->description=$interestdatadesc->description;     
                
                array_push($newarray,$mydata);
            }  
        }     

        $newinterestdata=json_encode($newarray);


        $deductibledata=json_decode($slipdata->deductible_panel);   

        $newarraydeduct=[];

        if(!empty($deductibledata))
        {
            foreach($deductibledata as $mydata)
            {
                $deductdatadesc= DeductibleType::where('id','=',$mydata->deductibletype_id)->first();
                $mydata->deductibletype=$deductdatadesc->description;
                
                $currencydesc=Currency::where('id','=',$mydata->currency_id)->first();
                $mydata->currencydata=$currencydesc->symbol_name;
                
                
                array_push($newarraydeduct,$mydata);
            }     
        }  

        $newdeductdata=json_encode($newarraydeduct);


        $extendcoverdata=json_decode($slipdata->extend_coverage);   

        $newarrayextend=[];

        if(!empty($extendcoverdata))
        {
            foreach($extendcoverdata as $mydata)
            {
                $extenddesc= ExtendedCoverage::where('id','=',$mydata->extendcoverage_id)->first();
                $mydata->coveragetype=$extenddesc->description;
                
                array_push($newarrayextend,$mydata);
            }       
        }
        $newextenddata=json_encode($newarrayextend);

        $dateyeardata=  date("d/m/Y", strtotime($slipdata->prod_year));
      
        return response()->json(
            [
                'id' => $slipdata->id,
                'insured_id' => $slipdata->insured_id,
                'slip_type' => $slipdata->slip_type,
                'username' => $slipdata->username,
                'prod_year' => $dateyeardata,
                'number' => $slipdata->number,
                'slipuy' => $slipdata->uy,
                'uy' => $slipdata->uy,
                'status' => $slipdata->status,
                'endorsment' => $slipdata->endorsment,
                'selisih' => $slipdata->selisih,
                'source' => $slipdata->source,
                'source_2' => $slipdata->source_2,
                'currency'=> $slipdata->currency,
                'cob'=> $slipdata->cob,
                'koc'=> $slipdata->koc,
                'occupacy'=> $slipdata->occupacy,
                'build_const'=> $slipdata->build_const,
                'slip_no'=> $slipdata->slip_no,
                'cn_dn'=> $slipdata->cn_dn,
                'policy_no'=> $slipdata->policy_no,
                'attacment_file'=> $slipdata->attacment_file,
                'interest_insured'=> $newinterestdata,
                'total_sum_insured'=> $slipdata->total_sum_insured,
                'insured_type'=>$slipdata->insured_type,
                'insured_pct'=>$slipdata->insured_pct,
                'total_sum_pct'=>$slipdata->total_sum_pct,
                'deductible_panel'=>$newdeductdata,
                'extend_coverage'=>$newextenddata,
                'insurance_period_from'=>$slipdata->insurance_period_from,
                'insurance_period_to'=>$slipdata->insurance_period_to,
                'reinsurance_period_from'=>$slipdata->reinsurance_period_from,
                'reinsurance_period_to'=>$slipdata->reinsurance_period_to,
                'proportional'=>$slipdata->proportional,
                'layer_non_proportional'=>$slipdata->layer_non_proportional,
                'rate'=>$slipdata->rate,
                'share'=>$slipdata->share,
                'sum_share'=>$slipdata->sum_share,
                'basic_premium'=>$slipdata->basic_premium,
                'commission'=>$slipdata->commission,
                'grossprm_to_nr'=>$slipdata->grossprm_to_nr,
                'netprm_to_nr'=>$slipdata->netprm_to_nr,
                'installment_panel'=>$slipdata->installment_panel,
                'sum_commission'=>$slipdata->sum_commission,
                'retro_backup'=>$slipdata->retro_backup,
                'own_retention'=>$slipdata->own_retention,
                'sum_own_retention'=>$slipdata->sum_own_retention,
                'retrocession_panel'=>$slipdata->retrocession_panel,
                'slip_idendorsementcount'=>$slipdata->slip_idendorsementcount,
                'prev_endorsement'=>$slipdata->prev_endorsement,
                'condition_needed'=>$slipdata->condition_needed,
                'created_at'=>$slipdata->created_at,
                'updated_at'=>$slipdata->updated_at,
                'coinsurance_slip'=>$slipdata->coinsurance_slip
            ]
        );

    }

    public function getdetailEndorsementSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->first();

        $countendorsement =$slipdata->slip_idendorsementcount;

        if($slipdata->slip_idendorsementcount==NULL || $slipdata->slip_idendorsementcount=="")
        {
            $code_sl = $slipdata->number . '-END' . '000' . '1';
        }
        else 
        {
            if($countendorsement < 10)
            {
                $code_sl = substr($slipdata->number,0,16) . '-END' . '000' . ($countendorsement + 1);
            }
            elseif($countendorsement > 9 && $countendorsement < 100)
            {
                $code_sl = substr($slipdata->number,0,16) . '-END' . '00' . ($countendorsement + 1);
            }
            elseif($countendorsement > 99 && $countendorsement < 1000)
            {
                $code_sl = substr($slipdata->number,0,16) . '-END' . '0' . ($countendorsement + 1);
            }
            elseif($countendorsement > 999 && $countendorsement < 10000)
            {
                $code_sl = substr($slipdata->number,0,16) . '-END' . ($countendorsement + 1);
            }
        }


        $interestdata=json_decode($slipdata->interest_insured);   
        $newarray=[];

        if(!empty($interestdata))
        {
            foreach($interestdata as $mydata)
            {
                $interestdatadesc= InterestInsured::where('id','=',$mydata->interest_id)->first();
                $mydata->description=$interestdatadesc->description;     
                
                array_push($newarray,$mydata);
            }  
        }     

        $newinterestdata=json_encode($newarray);


        $deductibledata=json_decode($slipdata->deductible_panel);   

        $newarraydeduct=[];

        if(!empty($deductibledata))
        {
            foreach($deductibledata as $mydata)
            {
                $deductdatadesc= DeductibleType::where('id','=',$mydata->deductibletype_id)->first();
                $mydata->deductibletype=$deductdatadesc->description;
                
                $currencydesc=Currency::where('id','=',$mydata->currency_id)->first();
                $mydata->currencydata=$currencydesc->symbol_name;
                
                
                array_push($newarraydeduct,$mydata);
            }     
        }  

        $newdeductdata=json_encode($newarraydeduct);


        $extendcoverdata=json_decode($slipdata->extend_coverage);   

        $newarrayextend=[];

        if(!empty($extendcoverdata))
        {
            foreach($extendcoverdata as $mydata)
            {
                $extenddesc= ExtendedCoverage::where('id','=',$mydata->extendcoverage_id)->first();
                $mydata->coveragetype=$extenddesc->description;
                
                array_push($newarrayextend,$mydata);
            }       
        }
        $newextenddata=json_encode($newarrayextend);

        $dateyeardata=  date("d/m/Y", strtotime($slipdata->prod_year));

    
        return response()->json(
            [
                'id' => $slipdata->id,
                'code_sl'=>$code_sl,
                'insured_id' => $slipdata->insured_id,
                'slip_type' => $slipdata->slip_type,
                'username' => $slipdata->username,
                'prod_year' => $dateyeardata,
                'number' => $slipdata->number,
                'slipuy' => $slipdata->uy,
                'uy' => $slipdata->uy,
                'status' => $slipdata->status,
                'endorsment' => $slipdata->endorsment,
                'selisih' => $slipdata->selisih,
                'source' => $slipdata->source,
                'source_2' => $slipdata->source_2,
                'currency'=> $slipdata->currency,
                'cob'=> $slipdata->cob,
                'koc'=> $slipdata->koc,
                'occupacy'=> $slipdata->occupacy,
                'build_const'=> $slipdata->build_const,
                'slip_no'=> $slipdata->slip_no,
                'cn_dn'=> $slipdata->cn_dn,
                'policy_no'=> $slipdata->policy_no,
                'attacment_file'=> $slipdata->attacment_file,
                'interest_insured'=> $newinterestdata,
                'total_sum_insured'=> $slipdata->total_sum_insured,
                'insured_type'=>$slipdata->insured_type,
                'insured_pct'=>$slipdata->insured_pct,
                'total_sum_pct'=>$slipdata->total_sum_pct,
                'deductible_panel'=>$newdeductdata,
                'extend_coverage'=>$newextenddata,
                'insurance_period_from'=>$slipdata->insurance_period_from,
                'insurance_period_to'=>$slipdata->insurance_period_to,
                'reinsurance_period_from'=>$slipdata->reinsurance_period_from,
                'reinsurance_period_to'=>$slipdata->reinsurance_period_to,
                'proportional'=>$slipdata->proportional,
                'layer_non_proportional'=>$slipdata->layer_non_proportional,
                'rate'=>$slipdata->rate,
                'share'=>$slipdata->share,
                'sum_share'=>$slipdata->sum_share,
                'basic_premium'=>$slipdata->basic_premium,
                'commission'=>$slipdata->commission,
                'grossprm_to_nr'=>$slipdata->grossprm_to_nr,
                'netprm_to_nr'=>$slipdata->netprm_to_nr,
                'installment_panel'=>$slipdata->installment_panel,
                'sum_commission'=>$slipdata->sum_commission,
                'retro_backup'=>$slipdata->retro_backup,
                'own_retention'=>$slipdata->own_retention,
                'sum_own_retention'=>$slipdata->sum_own_retention,
                'retrocession_panel'=>$slipdata->retrocession_panel,
                'slip_idendorsementcount'=>$slipdata->slip_idendorsementcount,
                'prev_endorsement'=>$slipdata->prev_endorsement,
                'condition_needed'=>$slipdata->condition_needed,
                'created_at'=>$slipdata->created_at,
                'updated_at'=>$slipdata->updated_at,
                'coinsurance_slip'=>$slipdata->coinsurance_slip
            ]
        );

    }


    public function storefeinsured(Request $request)
    {   
        
        $validator = $request->validate([
            'fesnumber'=>'required',
            'fesinsured'=>'required',
            'fessuggestinsured'=>'required'
        ]);
        
        $costumcheck=Customer::where('company_name','=',$request->fessuggestinsured)->first();
        if($costumcheck==null)
        {

            Customer::create([
                'owner_id'=>'1',
                'industry_id'=>'27',
                'company_prefix' => $request->fesinsured,
                'company_name'=>$request->fessuggestinsured,
                'website'=>$request->fessuggestinsured,
                'company_suffix'=>$request->fessuffix
            ]);

        }

        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->fesnumber)->first();
            $locationlist= TransLocationTemp::where('insured_id','=',$request->fesnumber)->orderby('id','desc')->get();
            
            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->fesnumber,
                    'slip_type'=>'fe',
                    'insured_prefix' => $request->fesinsured,
                    'insured_name'=>$request->fessuggestinsured,
                    'insured_suffix'=>$request->fessuffix,
                    'share'=>$request->fesshare,
                    'share_from'=>$request->fessharefrom,
                    'share_to'=>$request->fesshareto,
                    'coincurance'=>$request->fescoincurance,
                    'location'=>$locationlist->toJson()
                ]);

                $notification = array(
                    'message' => 'Fire & Engginering Insured added successfully!',
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
                $insureddataup->coincurance=$request->fescoincurance;
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->save();


                $notification = array(
                    'message' => 'Fire & Engginering Insured Update successfully!',
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


    public function storeMultiFile(Request $request)
    {
         
       $validatedData = $request->validate([
        // 'files' => 'required'
        ]);
 
        if($request->TotalFiles > 0)
        { 
                for ($x = 0; $x < $request->TotalFiles; $x++) 
                {
        
                    if ($request->hasFile('files'.$x)) 
                        {
                            $file = $request->file('files'.$x);
        
                            $path = 'public/files';
                            //$file->move(base_path('\public\files'), $file->getClientOriginalName());
                            //$name = $file->getClientOriginalName();

                            $extension = $file->getClientOriginalExtension(); 
                            
                            if($extension=="csv" || $extension=="txt" || $extension=="xlx" || $extension=="xls" || $extension=="pdf")
                            {  
                                $name =  time() . rand(11111,99999).''.$file->getClientOriginalName();
                                $file->move(base_path('\public\files'),$name);
                                
                                $insert[$x]['filename'] = $name;
                                $insert[$x]['path'] = $path;
                                $insert[$x]['user_id'] = Auth::user()->name;
                                $insert[$x]['slip_id'] = $request->slip_id;
                                SlipTableFile::insert($insert);
                            }
                            else{
                                return response()->json(['message'=>'file type incorrect']);
                            }
                        }
                }
        
               
    
           return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
 
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }
 
    }


    public function storefeslip(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required'
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
                $currdate = date("Y-m-d");

                $slipdataup=SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>Auth::user()->name,
                    'insured_id'=>$request->code_ms,
                    'slip_type'=>'fe',
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
                    'build_const'=>$request->slipbld_const,
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
                    'insurance_period_to'=>$request->slipipto,
                    'reinsurance_period_from'=>$request->sliprpfrom,
                    'reinsurance_period_to'=>$request->sliprpto,
                    'proportional'=>$request->slipproportional,
                    'layer_non_proportional'=>$request->sliplayerproportional,
                    'rate'=>$request->sliprate,
                    'v_broker'=>$request->slipvbroker,
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
                    'message' => 'Fire & Engginering Slip added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $currdate = date("Y-m-d");

                $slipdataid=$slipdata->id;
                $slipdataup = SlipTable::findOrFail($slipdataid);
                
                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
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
                $slipdataup->build_const=$request->slipbld_const;
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
                $slipdataup->insurance_period_to=$request->slipipto;  
                $slipdataup->reinsurance_period_from=$request->sliprpfrom;  
                $slipdataup->reinsurance_period_to=$request->sliprpto;
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate;  
                $slipdataup->v_broker=$request->slipvbroker;
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
                    'message' => 'Fire & Engginering Slip Update successfully!',
                    'alert-type' => 'success'
                );
            }

            StatusLog::create([
                'status'=>$request->slipstatus,
                'user'=>Auth::user()->name,
                'insured_id'=>$request->code_ms,
                'slip_id'=>$request->slipnumber,
            ]);



            $slip = SlipTable::orderby('id','asc')->get();            
            $sliplastid = count($slip);

            $mydate = date("Y").date("m").date("d");
            $userid = Auth::user()->id;
            if($sliplastid != null){
                if($sliplastid < 10)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "FE". $userid ."". $mydate . "0000" . strval(1);
            }

            $kondisi=false;
            $i=1;
            while($kondisi==false)
            {
                $slipdatatest=SlipTable::where('number',$code_sl)->first();
                if(empty($slipdatatest) || $slipdatatest==NULL)
                {
                    $kondisi=true;
                }
                else
                {
                    if($sliplastid < 10)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + $i);
                    }
                }

                $i++;
            }

            return response()->json(
                [
                    'id' => $slipdataup->id,
                    'number' => $slipdataup->number,
                    'slipuy' => $slipdataup->uy,
                    'code_sl'=> $code_sl,
                    'slipstatus' => $slipdataup->status
                ]
            );

            //return back()->with($notification);

            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Fire & Engginering Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }



    public function storeendorsementfeslip(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->prevslipnumber)->first();
            
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->prevslipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->prevslipnumber)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$request->prevslipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->prevslipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->prevslipnumber)->orderby('id','desc')->get();             

            if($slipdata==null)
            {
                $notification = array(
                    'message' => 'Fire & Engginering Slip added Fail!',
                    'alert-type' => 'danger'
                );
            }
            else
            {
                $currdate = date("Y-m-d");

                $slipdataid=$slipdata->id;
                $slipdataup = SlipTable::findOrFail($slipdataid);
                
                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
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
                $slipdataup->build_const=$request->slipbld_const;
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
                $slipdataup->insurance_period_to=$request->slipipto;  
                $slipdataup->reinsurance_period_from=$request->sliprpfrom;  
                $slipdataup->reinsurance_period_to=$request->sliprpto;
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate; 
                $slipdataup->v_broker=$request->slipvbroker;
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


                if($slipdataup->slip_idendorsementcount==NULL || $slipdataup->slip_idendorsementcount=="")
                {
                    $countendorsement=1;
                }
                else 
                {
                    $countendorsement=$slipdataup->slip_idendorsementcount+1;
                }

                $slipdataup->slip_idendorsementcount=$countendorsement;
                
                
                $slipdataup->prev_endorsement=$request->prevslipnumber;
                $slipdataup->sum_own_retention=$request->slipsumor;

                $slipdataup->save();

                InterestInsuredTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
                InstallmentTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
                ExtendCoverageTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
                DeductibleTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
                RetrocessionTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));          
    

                $notification = array(
                    'message' => 'Fire & Engginering Slip Update successfully!',
                    'alert-type' => 'success'
                );
            }

            StatusLog::create([
                'status'=>$request->slipstatus,
                'user'=>Auth::user()->name,
                'insured_id'=>$request->code_ms,
                'slip_id'=>$request->slipnumber,
            ]);

           
            $slip = SlipTable::orderby('id','asc')->get();            
            $sliplastid = count($slip);

            $mydate = date("Y").date("m").date("d");
            $userid = Auth::user()->id;
            if($sliplastid != null){
                if($sliplastid < 10)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "FE". $userid ."". $mydate . "0000" . strval(1);
            }

            $kondisi=false;
            $i=1;
            while($kondisi==false)
            {
                $slipdatatest=SlipTable::where('number',$code_sl)->first();
                if(empty($slipdatatest) || $slipdatatest==NULL)
                {
                    $kondisi=true;
                }
                else
                {
                    if($sliplastid < 10)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "FE". $userid ."". $mydate . strval($sliplastid + $i);
                    }
                }

                $i++;
            }

            return response()->json(
                [
                    'id' => $slipdataup->id,
                    'number' => $slipdataup->number,
                    'slipuy' => $slipdataup->uy,
                    'code_sl'=> $code_sl,
                    'slipstatus' => $slipdataup->status
                ]
            );

            
            
            //return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Fire & Engginering Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    
    public function storelocationlist(Request $request)
    {

            $adrress = $request->adrress;
            $insured_id = $request->insuredID;
        
            if($adrress !='' && $insured_id != '')
            {    
                $locationlist = new TransLocationTemp();
                $locationlist->insured_id = $insured_id;
                $locationlist->lookup_location_id = $adrress;
                $locationlist->country_id=$request->country;
                $locationlist->state_id=$request->state;
                $locationlist->city_id=$request->city;
                $locationlist->address_location_id=$adrress;
                $locationlist->interest_id=$request->slipinterestid;
                $locationlist->cnno=$request->cnno;
                $locationlist->certno=$request->certno;
                $locationlist->refno=$request->refno;
                $locationlist->amountlocation=$request->amountlocation;
                $locationlist->save();

                $felookuplocations = FeLookupLocation::find($adrress);
                $locationlist2 = TransLocationTemp::where('id','=',$locationlist->id);

                return response()->json([
                    'id' => $locationlist->id,
                    'loc_code' => $felookuplocations->loc_code,
                    'address' => $felookuplocations->address,
                    'city_id' => $felookuplocations->city_id,
                    'postal_code' => $felookuplocations->postal_code,
                    'province_id' => $felookuplocations->province_id,
                    'latitude' => $felookuplocations->latitude,
                    'longtitude' => $felookuplocations->longtitude,
                    'state_name' => $felookuplocations->state->name,
                    'city_name' => $felookuplocations->city->name,
                    'interest_id'=> $request->slipinterestid,
                    'interest_name'=> $locationlist->interestdata->code.'-'.$locationlist->interestdata->description,
                    'cnno' => $request->cnno,
                    'certno' => $request->certno,
                    'refno' => $request->refno,
                    'amountlocation' => $request->amountlocation,
                ]);
            }
            else
            {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );
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
                'message' => 'Fire & Engginering Insured & Slip deleted successfully!',
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

    
    public function destroysliplocationlist($id)
    {
        $sliplistlocation = TransLocationTemp::find($id);
        $amountlocation = $sliplistlocation->amountlocation;
        $sliplistlocation->delete();
        
        return response()->json(['success'=>'Data has been deleted','amountlocation'=>$amountlocation]);
    }

    
}
