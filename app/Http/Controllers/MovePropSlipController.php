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
use App\Models\SlipTableFileTemp;
use App\Models\User;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
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
use App\Models\TransProperty;
use App\Models\TransPropertyTemp;
use App\Models\Insured;
use App\Models\InterestInsured;
use App\Models\InterestInsuredTemp;
use App\Models\InstallmentTemp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\PropertyType;
use App\Models\PropertyTypeTemp;
use App\Models\StatusLog;
use App\Models\RetrocessionTemp;

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
        $userid = Auth::user()->id;
        $route_active = 'Moveable Property - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        
        $country = Country::orderby('id','asc')->get();
        $city = City::orderby('id','asc')->get();
        $state = State::orderby('id','asc')->get();
        $costumer=Customer::orderby('id','asc')->get();

        
       $currdate = date("Y-m-d");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','mp')->orderby('id','asc')->get();
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();
        $propertytype= PropertyType::orderby('id','asc')->get();
        
        $mp_ids = response()->json($insured->modelKeys());
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
                $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($sliplastid > 9 && $sliplastid < 100)
            {
                $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 99 && $sliplastid < 1000)
            {
                $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 999 && $sliplastid < 10000)
            {
                $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 9999 && $sliplastid < 100000)
            {
                $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + 1);
            }

            
        }
        else{
            $code_sl = "MP". $userid ."". $mydate . "0000" . strval(1);
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
                    $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + $i);
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


        $propertytypelist=PropertyTypeTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
       
        if(count($interestlist) != null){
            InterestInsuredTemp::where('slip_id', $code_sl)->delete();
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
        
        return view('crm.transaction.mp_slip', compact(['user','statuslist','slipdata','slipdata2','propertytypelist','propertytype','retrocessionlist','interestinsured','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','deductibletype','cnd','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','mp_ids','code_ms','code_sl','costumer']));
    }

  
    public function updatempslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

       $currdate = date("Y-m-d");
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
        $propertytype= PropertyType::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id','=',$code_ms)->get();
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
                    $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + $i);
                }
            }

            $i++;
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
        $propertytypelist=PropertyTypeTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

        return view('crm.transaction.mp_slipupdate', compact(['user','cnd','slipdata2','propertytype','filelist','propertytypelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function endorsementmpslip($ms,$sl)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

       $currdate = date("Y-m-d");
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
        $propertytype= PropertyType::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $code_ms=$ms;
        $code_sl=$sl;

        $insureddata=Insured::where('number',$code_ms)->first();
        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();


        if($slipdata==NULL || empty($slipdata) || $code_ms==0 || $code_sl==0)
        {

            $countendorsement =$slipdata->slip_idendorsementcount;
            $insureddata=Insured::where('slip_type','fe')->orderby('id','desc')->first();
            $slipdata=SlipTable::where('insured_id',$insureddata->number)->orderby('id','desc')->first();
            
            $code_ms=$insureddata->number;
   
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
        $propertytypelist=PropertyTypeTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

        return view('crm.transaction.mp_slipendorsement', compact(['user','cnd','slipdata2','propertytype','countendorsement','filelist','propertytypelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function detailmpslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

       $currdate = date("Y-m-d");
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
        $propertytype= PropertyType::orderby('id','asc')->get();
        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();
        
        $code_sl=$slipdata->number;

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
                    $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + $i);
                }
            }

            $i++;
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
        $propertytypelist=PropertyTypeTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();


        return view('crm.transaction.mp_slipdetail', compact(['user','cnd','slipdata2','filelist','propertytype','propertytypelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function storempinsured(Request $request)
    {
        $validator = $request->validate([
            'mpnumber'=>'required',
            'mpinsured'=>'required',
            'mpsuggestinsured'=>'required'
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
            
            $insureddata= Insured::where('number','=',$request->mpnumber)->first();
            $locationlist= TransLocationTemp::where('insured_id','=',$request->flnumber)->orderby('id','desc')->get();
            $propertytypelist= PropertyTypeTemp::where('insured_id','=',$request->flnumber)->orderby('id','desc')->get();

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
                    'coincurance'=>$request->mpcoinsurance,
                    'location'=>$locationlist->toJson(),
                    'property_type'=>$propertytypelist->toJson()
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
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->property_type=$propertytypelist->toJson();
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


    public function storempslip(Request $request,$code_ms)
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
                    'message' => 'Moveable Property Slip added successfully!',
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
                    'message' => 'Moveable Property Slip Update successfully!',
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
                    $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "MP". $userid ."". $mydate . "0000" . strval(1);
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
                        $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + $i);
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
                'message' => 'Moveable Property Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }


    public function storeendorsementmpslip(Request $request,$code_ms)
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
                    'message' => 'Moveable Property Slip added fail!',
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
                $slipdataup->prev_endorsement=$request->prevslipnumber;

                if($slipdataup->slip_idendorsementcount==NULL || $slipdataup->slip_idendorsementcount=="")
                {
                    $countendorsement=1;
                }
                else 
                {
                    $countendorsement=$slipdataup->slip_idendorsementcount+1;
                }

                $slipdataup->slip_idendorsementcount=$countendorsement;

                $slipdataup->sum_own_retention=$request->slipsumor;
                
                $slipdataup->save();


                
            InterestInsuredTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
            InstallmentTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
            ExtendCoverageTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
            DeductibleTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
            RetrocessionTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));          


                $notification = array(
                    'message' => 'Moveable Property Slip Update successfully!',
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
                    $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "MP". $userid ."". $mydate . "0000" . strval(1);
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
                        $code_sl = "MP". $userid ."". $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "MP". $userid ."". $mydate . strval($sliplastid + $i);
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
                'message' => 'Moveable Property Slip added Failed!',
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
