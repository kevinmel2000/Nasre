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
use App\Models\Koc;
use App\Models\CedingBroker;
use App\Models\ConditionNeeded;
use App\Models\ShipListTemp;
use App\Policies\FelookupLocationPolicy;
use App\Models\TransLocationTemp;
use App\Models\User;
use App\Models\EarthQuakeZone;
use App\Models\InterestInsured;
use App\Models\InterestInsuredTemp;
use App\Models\FloodZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\InstallmentTemp;
use App\Models\StatusLog;
use App\Models\RetrocessionTemp;
use App\Models\RiskLocationDetail;

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
        $userid = Auth::user()->id;
        $route_active = 'HE & Motor - Slip Entry';
        $mydate = date("Y").date("m").date("d");

        $country = Country::orderby('id','asc')->get();
        $city = City::orderby('id','asc')->get();
        $state = State::orderby('id','asc')->get();
        $costumer=Customer::orderby('id','asc')->get();


        $currdate = date("d/m/Y");
        $currdate2 = date("Y-m-d");

        $insured = Insured::orderby('id','asc')->get();
        $insured_now = Insured::whereDate('created_at',$currdate2)->orderby('id','asc')->get();


        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','hem')->orderby('id','asc')->get();
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $hem_ids = response()->json($insured->modelKeys());
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        //$lastid = count($insured);
        //$hem_ids = response()->json($insured->modelKeys());
        $lastid = count($insured_now);
        $sliplastid = count($slip);

        if($lastid != null){
            if($lastid < 9)
            {
                $code_ms = "IN" .  $mydate . "0000" . strval($lastid + 1);
            }   
            elseif($lastid > 8 && $lastid < 99)
            {
                $code_ms = "IN" .  $mydate . "000" . strval($lastid + 1);
            }
            elseif($lastid > 98 && $lastid < 999)
            {
                $code_ms = "IN" .  $mydate . "00" . strval($lastid + 1);
            }
            elseif($lastid > 998 && $lastid < 9999)
            {
                $code_ms = "IN" .  $mydate . "0" . strval($lastid + 1);
            }
            elseif($lastid > 9998 && $lastid < 99999)
            {
                $code_ms = "IN" .  $mydate  . strval($lastid + 1);
            }


        }
        else{
            $code_ms = "IN" .  $mydate . "0000" . strval(1);
        }

        
        $checkinsured = Insured::where('number',$code_ms)->first();

        if($checkinsured){
                // $deleteinsured= Insured::where('number','=',$code_ms)->delete();
            if($checkinsured->share_to != null){
                
                $deleteinsured= Insured::where('number','=',$code_ms)->delete();
            }else{
                $deleteinsured= Insured::where('number','=',$code_ms)->delete();
            }
        }

        $insureddataup = Insured::create([
            'number'=>$code_ms,
            'slip_type'=>'hem',
            'count_endorsement'=>0
            
        ]);


        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();
        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slip_now = SlipTable::whereDate('created_at',$currdate2)->where('slip_type','hem')->where('insured_id',$code_ms)->orderby('id','asc')->get();
        $sliplastid = count($slip_now);

        if($sliplastid != null){
            if($sliplastid < 9)
            {
                $code_sl = "HEM".  $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($sliplastid > 8 && $sliplastid < 99)
            {
                $code_sl = "HEM".  $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 98 && $sliplastid < 999)
            {
                $code_sl = "HEM".  $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 998 && $sliplastid < 9999)
            {
                $code_sl = "HEM".  $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 9998 && $sliplastid < 99999)
            {
                $code_sl = "HEM".  $mydate . strval($sliplastid + 1);
            }

            
        }
        else{
            $code_sl = "HEM".  $mydate . "0000" . strval(1);
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
                if($sliplastid < 9)
                {
                    $code_sl = "HEM".  $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 8 && $sliplastid < 99)
                {
                    $code_sl = "HEM".  $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 98 && $sliplastid < 999)
                {
                    $code_sl = "HEM".  $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 998 && $sliplastid < 9999)
                {
                    $code_sl = "HEM".  $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9998 && $sliplastid < 99999)
                {
                    $code_sl = "HEM".  $mydate . strval($sliplastid + $i);
                }
            }

            $i++;
        }

        $checkdataslip= SlipTable::where('number',$code_sl)->first();

        if($checkdataslip){
            if($checkdataslip->total_sum_insured != null){
                $deleteinsured= SlipTable::where('number','=',$code_sl)->delete();
            }
        }
        
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();
        $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->delete();


        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  



        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
       
        if(count($interestlist) != null){
            InterestInsuredTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($locationlist) != null){
            TransLocationTemp::where('insured_id', $code_ms)->delete();
        }

        if(count($deductiblelist) != null){
           // DeductibleTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($extendcoveragelist) != null){
            //ExtendCoverageTemp::where('slip_id', $code_sl)->delete();
        }

        if(count($installmentlist) != null){
            //InstallmentTemp::where('slip_id', $code_sl)->delete();
        }
        
        if(count($retrocessionlist) != null){
            //RetrocessionTemp::where('slip_id', $code_sl)->delete();
        }
        
        return view('crm.transaction.hem_slip', compact(['user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','deductibletype','extendedcoverage','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','hem_ids','code_ms','code_sl','costumer']));
    }


    public function updatehemslip($idm)
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
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();


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
                        if($sliplastid < 9)
                        {
                            $code_sl = "HEM".  $mydate . "0000" . strval($sliplastid + $i);
                        }   
                        elseif($sliplastid > 8 && $sliplastid < 99)
                        {
                            $code_sl = "HEM".  $mydate . "000" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 98 && $sliplastid < 999)
                        {
                            $code_sl = "HEM".  $mydate . "00" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 998 && $sliplastid < 9999)
                        {
                            $code_sl = "HEM".  $mydate . "0" . strval($sliplastid + $i);
                        }
                        elseif($sliplastid > 9998 && $sliplastid < 99999)
                        {
                            $code_sl = "HEM".  $mydate . strval($sliplastid + $i);
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
                if($sliplastid < 9)
                {
                    $code_sl = "HEM".  $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 8 && $sliplastid < 99)
                {
                    $code_sl = "HEM".  $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 98 && $sliplastid < 999)
                {
                    $code_sl = "HEM".  $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 998 && $sliplastid < 9999)
                {
                    $code_sl = "HEM".  $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9998 && $sliplastid < 99999)
                {
                    $code_sl = "HEM".  $mydate . strval($sliplastid + 1);
                }
    
                
            }
            else{
                $code_sl = "HEM".  $mydate . "0000" . strval(1);
            }

            $slipdata=SlipTable::orderBy('id', 'desc')->first();
        }

        $checkdataslip= SlipTable::where('number',$code_sl)->first();

        if($checkdataslip){
            if($checkdataslip->total_sum_insured != null){
                $deleteinsured= SlipTable::where('number','=',$code_sl)->delete();
            }
        }

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  



        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.hem_slipupdate', compact(['user','userid','slipdata2','cnd','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function endorsementhemslip($ms,$sl)
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
                if($countendorsement < 9)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 8 && $countendorsement < 99)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 98 && $countendorsement < 999)
                {
                    $code_sl = substr($slipdata->number,0,16) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 998 && $countendorsement < 9999)
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
                if($countendorsement < 9)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 8 && $countendorsement < 99)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 98 && $countendorsement < 9999)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 998 && $countendorsement < 99999)
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
        
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  



        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.hem_slipendorsement', compact(['user','slipdata2','cnd','filelist','countendorsement','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function detailhemslip($idm)
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
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id','=',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();
        $code_sl=$slipdata->number;
        $sliplastid = count($slip);

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
                if($sliplastid < 9)
                {
                    $code_sl = "HEM".  $mydate . "0000" . strval($sliplastid + $i);
                }   
                elseif($sliplastid > 8 && $sliplastid < 99)
                {
                    $code_sl = "HEM".  $mydate . "000" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 98 && $sliplastid < 999)
                {
                    $code_sl = "HEM".  $mydate . "00" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 998 && $sliplastid < 9999)
                {
                    $code_sl = "HEM".  $mydate . "0" . strval($sliplastid + $i);
                }
                elseif($sliplastid > 9998 && $sliplastid < 99999)
                {
                    $code_sl = "HEM".  $mydate . strval($sliplastid + $i);
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
        
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  



        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.hem_slipdetail', compact(['user','slipdata2','cnd','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    
    public function storeheminsured(Request $request)
    {
        $validator = $request->validate([
            'hemnumber'=>'required',
            'heminsured'=>'required',
            'hemsuggestinsured'=>'required'
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
            
            $insureddata= Insured::where('number','=',$request->hemnumber)->first();
            $locationlist= TransLocationTemp::where('insured_id','=',$request->hemnumber)->orderby('id','desc')->get();

            $sum_amount = DB::table('risk_location_detail')
            ->join('trans_location_detail','trans_location_detail.id','=','risk_location_detail.translocation_id')
            ->where('trans_location_detail.insured_id',$request->hemnumber)
            ->sum('risk_location_detail.amountlocation');

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->hemnumber,
                    'slip_type'=>'hem',
                    'insured_prefix' => $request->heminsured,
                    'insured_name'=>$request->hemsuggestinsured,
                    'insured_suffix'=>$request->hemsuffix,
                    'share'=>$sum_amount,
                    'share_from'=>$request->hemsharefrom,
                    'share_to'=>$request->hemshareto,
                    'coincurance'=>$request->hemcoinsurance,
                    'location'=>$locationlist->toJson(),
                    'uy'=>$request->hemuy,
                    'count_endorsement'=>0
                ]);

                $notification = array(
                    'message' => 'He & Motor Insured added successfully!',
                    'alert-type' => 'success',
                    'count_endorsement' => $insureddataup->count_endorsement,
                    'ceding_share' => $sum_amount
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->insured_prefix=$request->hemsinsured;
                $insureddataup->insured_name=$request->hemsuggestinsured;
                $insureddataup->insured_suffix=$request->hemsuffix;
                $insureddataup->share=$sum_amount;
                $insureddataup->share_from=$request->hemsharefrom;
                $insureddataup->share_to=$request->hemshareto;
                $insureddataup->coincurance=$request->hemcoinsurance;
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->uy=$request->hemuy;
                $insureddataup->save();


                $notification = array(
                    'message' => 'He & Motor Insured Update successfully!',
                    'alert-type' => 'success',
                    'count_endorsement' => $insureddataup->count_endorsement,
                    'ceding_share' => $sum_amount
                );
            }

           

            return response($notification);
            //return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Hem & Motor Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }



    public function storehemslip(Request $request)
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
                    'date_transfer'=> date("Y-m-d", strtotime($request->slipdatetransfer)),
                    'status'=>$request->slipstatus,
                    'endorsment'=>0,
                    'selisih'=>'false',
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
                    //'attacment_file'=>json_encode($attachmentlist),
                    'attacment_file'=>'',
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'share_tsi'=>$request->slipsharetotalsum,
                    'type_tsi'=>$request->sliptypetotalsum,
                    'type_share_tsi'=>$request->sliptypetsishare,
                    'total_day'=>$request->sliptotalday,
                    'total_year'=>$request->sliptotalyear,
                    'sum_total_date'=>$request->slipdatesum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'extend_coverage'=>$extendcoveragelist->toJson(),
                    'insurance_period_from'=>date("Y-m-d", strtotime($request->slipipfrom)),
                    'insurance_period_to'=>date("Y-m-d", strtotime($request->slipipto)),
                    'reinsurance_period_from'=>date("Y-m-d", strtotime($request->sliprpfrom)),
                    'reinsurance_period_to'=>date("Y-m-d", strtotime($request->sliprpto)),
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
                    'sum_own_retention'=>$request->slipsumor,
                    'wpc'=>$request->wpc

                ]);

                $notification = array(
                    'message' => 'Hem & Motor Slip added successfully!',
                    'alert-type' => 'success'
                );

                //$insdata = Insured::where('number',$request->code_ms)->where('slip_type','fe')->first();
                $insdata = Insured::where('number',$request->code_ms)->first();
                // $old_sumshare = $request->slipoldsumshare;
    
                $old_nasre_share = $insdata->share_from;
                $new_nasre_share = $request->insured_share;

    
                if($new_nasre_share != $new_nasre_share){
                    $msdata = Insured::findOrFail($insdata->id);
    
                    $msdata->share_from=$new_nasre_share;
                    $msdata->save();
                }

                $old_number = $slipdataup->number;
                $newnumber = substr($old_number, 10,15);
                $codenumber = substr($old_number, 0,10);

                if(intval($newnumber) < 9)
                {
                    $count = substr($newnumber,14);
                    $new_number = $codenumber . "0000" . strval(intval($count) + 1);
                }   
                elseif(intval($newnumber) > 8 && intval($newnumber) < 99)
                {
                    $count = substr($newnumber,13);
                    $new_number = $codenumber . "000" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 98 && intval($newnumber) < 999)
                {
                    $count = substr($newnumber,12);
                    $new_number = $codenumber . "00" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 998 && intval($newnumber) < 9999)
                {
                    $count = substr($newnumber,11);
                    $new_number = $codenumber . "0" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 9998 && intval($newnumber) < 99999)
                {
                    $count = substr($newnumber,10);
                    $new_number = $codenumber  . strval(intval($count) + 1);
                }

                $checkdataslip= SlipTable::where('number',$new_number)->first();
                
                if($checkdataslip){
                    if($checkdataslip->total_sum_insured != null){
                        //$deleteinsured= SlipTable::where('number','=',$new_number)->delete();
                    }
                    else
                    {
                        $deleteinsured= SlipTable::where('number','=',$new_number)->delete();  
                        $slipdataup2 =SlipTable::create([
                            'insured_id'=>$slipdataup->insured_id,
                            'number'=>$new_number,
                            'slip_type'=>'fe'
                        ]); 
                    }
                }
            
    
                return response()->json(
                    [
                        'id' => $slipdataup->id,
                        'number' => $slipdataup->new_number,
                        'slipstatus' => $slipdataup->status,
                        'ceding'=>$slipdataup->ceding->name,
                        'cedingbroker'=>$slipdataup->cedingbroker->name,
                        'count_endorsement'=>$slipdataup->endorsment
                    ]
                );

            }
            else
            {
                $currdate = date("Y-m-d");

                //$slipdataid=$slipdata->id;
                //$slipdataup = SlipTable::findOrFail($slipdataid);

                $slipdataid=$slipdata->number;
                $slipdataup = SlipTable::where('number',$slipdataid)->orderby('created_at','desc')->first();

                
                if($slipdataup->status != $request->slipstatus){
                    StatusLog::create([
                        'status'=>$request->slipstatus,
                        'user'=>Auth::user()->name,
                        'datetime'=>date('Y-m-d H:i:s '),
                        'insured_id'=>$request->code_ms,
                        'slip_id'=>$request->slipnumber,
                    ]);
                }

                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
                $slipdataup->prod_year=$currdate;
                $slipdataup->date_transfer=date("Y-m-d", strtotime($request->slipdatetransfer));
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment=0;
                $slipdataup->selisih="false";
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
                $slipdataup->share_tsi=$request->slipsharetotalsum; 
                $slipdataup->type_tsi=$request->sliptypetotalsum; 
                $slipdataup->type_share_tsi=$request->sliptypetsishare; 
                $slipdataup->total_day=$request->sliptotalday; 
                $slipdataup->total_year=$request->sliptotalyear; 
                $slipdataup->sum_total_date=$request->slipdatesum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->extend_coverage=$extendcoveragelist->toJson();  
                $slipdataup->insurance_period_from=date("Y-m-d", strtotime($request->slipipfrom));  
                $slipdataup->insurance_period_to=date("Y-m-d", strtotime($request->slipipto));  
                $slipdataup->reinsurance_period_from=date("Y-m-d", strtotime($request->sliprpfrom));  
                $slipdataup->reinsurance_period_to=date("Y-m-d", strtotime($request->sliprpto));
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
                $slipdataup->wpc=$request->wpc;


                $slipdataup->save();

                $notification = array(
                    'message' => 'Hem & Motor Slip Update successfully!',
                    'alert-type' => 'success'
                );

                //$insdata = Insured::where('number',$request->code_ms)->where('slip_type','fe')->first();
                $insdata = Insured::where('number',$request->code_ms)->first();

                $old_nasre_share = $insdata->share_from;
                $new_nasre_share = $request->insured_share;

    
                if($new_nasre_share != $old_nasre_share){
                    $msdata = Insured::findOrFail($insdata->id);
    
                    $msdata->share_from=$new_nasre_share;
                    $msdata->save();
                }

                $old_number = $slipdataup->number;
                $newnumber = substr($old_number, 10,15);
                $codenumber = substr($old_number, 0,10);

                if(intval($newnumber) < 9)
                {
                    $count = substr($newnumber,14);
                    $new_number = $codenumber . "0000" . strval(intval($count) + 1);
                }   
                elseif(intval($newnumber) > 8 && intval($newnumber) < 99)
                {
                    $count = substr($newnumber,13);
                    $new_number = $codenumber . "000" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 98 && intval($newnumber) < 999)
                {
                    $count = substr($newnumber,12);
                    $new_number = $codenumber . "00" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 998 && intval($newnumber) < 9999)
                {
                    $count = substr($newnumber,11);
                    $new_number = $codenumber . "0" . strval(intval($count) + 1);
                }
                elseif(intval($newnumber) > 9998 && intval($newnumber) < 99999)
                {
                    $count = substr($newnumber,10);
                    $new_number = $codenumber  . strval(intval($count) + 1);
                }

                $checkdataslip= SlipTable::where('number',$new_number)->first();
                
                if($checkdataslip){
                    if($checkdataslip->total_sum_insured != null){
                        //$deleteinsured= SlipTable::where('number','=',$new_number)->delete();
                    }
                    else
                    {
                        $deleteinsured= SlipTable::where('number','=',$new_number)->delete();  
                        $slipdataup2 =SlipTable::create([
                            'insured_id'=>$slipdataup->insured_id,
                            'number'=>$new_number,
                            'slip_type'=>'fe'
                        ]); 
                    }
                }
            
                
    
                return response()->json(
                    [
                        'id' => $slipdataup->id,
                        'number' => $new_number,
                        'slipstatus' => $slipdataup->status,
                        'ceding'=>$slipdataup->ceding->name,
                        'cedingbroker'=>$slipdataup->cedingbroker->name,
                        'count_endorsement'=>$slipdataup->endorsment
                    ]
                );

            }

           
            
            //return back()->with($notification);
            
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

    public function storeendorsementhemslip(Request $request,$code_ms)
    {
       
        $validator = $request->validate([
            'slipid'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('id','=',$request->slipid)->first();
            $slipdatalist= SlipTable::where('insured_id','=',$slipdata->insured_id)->where('selisih','=','false')->get();
            $insureddata = Insured::where('number','=',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->first();

            // $id_ed = ($slipdata->id + 1);
            $id_ed = ($slipdata->endorsment + 1);
            
            $slipdatalast= SlipTable::where('endorsment',$id_ed)->where('id','=',$request->slipid)->first();
            // dd($slipdatalast);
            // $interestlist= InterestInsuredTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $locationlist= TransLocationTemp::where('insured_id','=',$slipdata->insured_id)->orderby('id','desc')->get();
            $attachmentlist=SlipTableFile::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();

            

            if($slipdata==null)
            {
                $notification = array(
                    'message' => 'Fire & Engineering Slip Endorsement Fail!',
                    'alert-type' => 'danger'
                );
            }
            else
            {
                
                if($slipdatalast == null)
                {

                    $locationlistup = ' ';
                    $risklocationlistup = ' ';
                    $dtlistup = ' ';
                    $jsondtlistup = ' ';
                    $ectlistup = ' ';
                    $jsonectlistup = ' ';
                    $iptlistup = ' ';
                    $jsoniptlistup = ' ';
                    $rctlistup = ' ';
                    $jsonrctlistup = ' ';
                    $risklocationlistdetail = '';

                    if(!empty($locationlist))
                    {
                        foreach($locationlist as $ll)
                        {
                            $locationlistup = TransLocationTemp::create([
                                'insured_id'=>$ll->insured_id,
                                'lookup_location_id'=>$ll->lookup_location_id,
                                'country_id'=>$ll->country_id,
                                'state_id'=>$ll->state_id,
                                'city_id'=>$ll->city_id,
                                'address_location_id'=>$ll->address_location_id,
                                'count_endorsement' => ($ll->count_endorsement + 1)
                            ]);
    
                            $lookuplocationlist = DB::table('trans_location_temp')
                                                    ->join('fe_lookup_location', 'fe_lookup_location.id', '=', 'trans_location_temp.lookup_location_id')
                                                    ->select('trans_location_temp.*', 'fe_lookup_location.address','fe_lookup_location.loc_code','fe_lookup_location.latitude','fe_lookup_location.longtitude','fe_lookup_location.postal_code')
                                                    ->where('trans_location_temp.id',$locationlistup->id)
                                                    ->get();

                            
                            
                            $risklocationlist= RiskLocationDetail::where('translocation_id','=',$ll->id)->orderby('id','desc')->get();
                            if($risklocationlist != null){
                                foreach($risklocationlist as $rl){
                                    $risklocationlistup = RiskLocationDetail::create([
                                        'ceding_id'=>$rl->ceding_id,
                                        'translocation_id'=>$locationlistup->id,
                                        'interest_id'=>$rl->interest_id,
                                        'cnno'=>$rl->cnno,
                                        'certno'=>$rl->certno,
                                        'refno'=>$rl->refno,
                                        'amountlocation'=>$rl->amountlocation,
                                        'count_endorsement' => ($rl->count_endorsement + 1)
                                    ]);
        
                                    $rldata =  RiskLocationDetail::findOrFail($rl->id);
                                    $rldata->amountlocation = ($rl->amountlocation * (-1));
                                    $rldata->save();
        
                                    $risklocationlistdetail = DB::table('risk_location_detail')
                                                            ->join('interest_insured', 'interest_insured.id', '=', 'risk_location_detail.interest_id')
                                                            ->join('ceding_broker', 'ceding_broker.id', '=', 'risk_location_detail.ceding_id')
                                                            ->select('risk_location_detail.*', 'interest_insured.description','ceding_broker.name')
                                                            ->where('risk_location_detail.id',$risklocationlistup->id)
                                                            ->get();
                                }
                            }
    
                        }
                    }

                    if($deductiblelist != null){
                        foreach($deductiblelist as $dt){
                            $dtlistup = DeductibleTemp::create([
                                'deductibletype_id'=>$dt->deductibletype_id,
                                'currency_id'=>$dt->currency_id,
                                'percentage'=>$dt->percentage,
                                'min_claimamount'=>$dt->min_claimamount,
                                'amount'=>$dt->amount,
                                'slip_id'=>$dt->slip_id,
                                'count_endorsement' => ($dt->count_endorsement + 1)
                            ]);

                            $jsondtlistup = DeductibleTemp::where('slip_id','=',$dtlistup->slip_id)->where('count_endorsement',$dtlistup->count_endorsement)->orderby('id','desc')->get();
    
                            $dtdata =  DeductibleTemp::findOrFail($dt->id);
                            $dtdata->min_claimamount = ($dt->min_claimamount * (-1));
                            $dtdata->amount = ($dt->amount * (-1));
                            $dtdata->save();
                        }
                    }else{
                        $dtlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if($extendcoveragelist != null){
                        foreach($extendcoveragelist as $ect){
                            $ectlistup = ExtendCoverageTemp::create([
                                'extendcoverage_id'=>$ect->extendcoverage_id,
                                'percentage'=>$ect->percentage,
                                'amount'=>$ect->amount,
                                'slip_id'=>$ect->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsonectlistup = ExtendCoverageTemp::where('slip_id','=',$ectlistup->slip_id)->where('count_endorsement',$ectlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $ectdata =  ExtendCoverageTemp::findOrFail($ect->id);
                            $ectdata->amount = ($ect->amount * (-1));
                            $ectdata->save();
                        }
                    }else{
                        $ectlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if($installmentlist != null){
                        foreach($installmentlist as $ipt){
                            $iptlistup = InstallmentTemp::create([
                                'installment_date'=>$ipt->installment_date,
                                'percentage'=>$ipt->percentage,
                                'amount'=>$ipt->amount,
                                'slip_id'=>$ipt->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsoniptlistup = InstallmentTemp::where('slip_id','=',$iptlistup->slip_id)->where('count_endorsement',$iptlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $iptdata =  InstallmentTemp::findOrFail($ipt->id);
                            $iptdata->amount = ($ipt->amount * (-1));
                            $iptdata->save();
                        }
                    }
                    else{
                        $iptlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if(!$retrocessionlist){
                        $rctlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);

                    }
                    else{
                       
                        foreach($retrocessionlist as $rct){
                            $rctlistup = RetrocessionTemp::create([
                                'type'=>$rct->type,
                                'contract'=>$rct->contract,
                                'percentage'=>$rct->percentage,
                                'amount'=>$rct->amount,
                                'slip_id'=>$rct->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsonrctlistup = RetrocessionTemp::where('slip_id','=',$rctlistup->slip_id)->where('count_endorsement',$rctlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $rctdata =  RetrocessionTemp::findOrFail($rct->id);
                            $rctdata->amount = ($rct->amount * (-1));
                            $rctdata->save();
                        }
                    }
                    

                    if($slipdatalist != null){
                        if($jsondtlistup == ' '){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'hem',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>json_encode($jsoniptlistup),
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc
                    
                                    ]);
                            }
                        }elseif($jsonectlistup == ' ' ){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'hem',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>json_encode($jsoniptlistup),
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc
                    
                                    ]);
                            }
                        }elseif($jsoniptlistup == ' '){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'hem',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc
                    
                                    ]);
                            }
                        }elseif($jsonrctlistup == ' '){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'hem',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>$jsoniptlistup->toJson(),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc
                    
                                    ]);
                            }
                        }
                        else
                        {
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'hem',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>$jsoniptlistup->toJson(),
                                        'retrocession_panel'=>$jsonrctlistup->toJson(),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc
                    
                                    ]);
                            }
                        }
                    }

                    

                    $insureddataup = Insured::create([
                        'number'=>$insureddata->number,
                        'slip_type'=>'fe',
                        'insured_prefix' => $insureddata->insured_prefix,
                        'insured_name'=>$insureddata->insured_name,
                        'insured_suffix'=>$insureddata->insured_suffix,
                        'share'=>$insureddata->share,
                        'share_from'=>$insureddata->share_from,
                        'share_to'=>$insureddata->share_to,
                        'coincurance'=>$insureddata->coincurance,
                        'location'=>$lookuplocationlist->toJson(),
                        'uy'=>$insureddata->uy,
                        'count_endorsement' => ($insureddata->count_endorsement + 1)
                    ]);
    
                    $notification = array(
                        'message' => 'Fire & Enginering Slip added Endorsement successfully!',
                        'alert-type' => 'success'
                    );


                    

                    $msdata = SlipTable::findOrFail($slipdata->id);
                    $msdata->total_sum_insured=($slipdata->total_sum_insured * (-1));
                    $msdata->total_sum_pct=($slipdata->total_sum_pct * (-1));
                    $msdata->sum_share=($slipdata->sum_share * (-1));
                    $msdata->basic_premium=($slipdata->basic_premium * (-1));
                    $msdata->commission=($slipdata->commission * (-1));
                    $msdata->grossprm_to_nr=($slipdata->grossprm_to_nr * (-1));
                    $msdata->netprm_to_nr=($slipdata->netprm_to_nr * (-1));
                    $msdata->sum_commission=($slipdata->sum_commission * (-1));
                    $msdata->wpc=($slipdata->wpc * (-1)); 
                    $msdata->sum_own_retention=($slipdata->sum_own_retention * (-1));
                    $msdata->selisih="false"; 
                    $msdata->save();



                    $insdata =  Insured::findOrFail($insureddata->id);
                    $insdata->share_from = ($insureddata->share_from * (-1));
                    $insdata->share_to = ($insureddata->share_to * (-1));
                    $insdata->save();

                    $cedingbroker = CedingBroker::where('id',$slipdataup->source)->first();
                    $ceding = CedingBroker::where('id',$slipdataup->source_2)->first();
                    
                    $slipdatalist2= SlipTable::where('insured_id','=',$slipdata->insured_id)->get();

                    //$locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
                    $slipdatalist=array();
                    foreach($slipdatalist2 as $datadetail)
                    {
                        if($datadetail->cedingbroker)
                        {
                            $dataceding=CedingBroker::where('id','=',$datadetail->source)->first();
                            $datadetail->cedingbroker = $dataceding->name;
                            $datadetail->ceding = $dataceding->name;
                            
                        }
                        else
                        {
                            $dataceding=CedingBroker::where('id','=',$datadetail->source)->first();
                            $datadetail->cedingbroker = $dataceding->name;
                            $datadetail->ceding = $dataceding->name;
                        }


                       

                        $slipdatalist[]= $datadetail;
                    }

                
                    return response()->json(
                        [
                            'slip_data' => $slipdataup->toJson(),
                            'slip_dataarray' => json_encode($slipdatalist),
                            'insured_data' => $insureddataup->toJson(),
                            'location_data' => $lookuplocationlist->toJson(),
                            'risklocation_data' => $risklocationlistdetail->toJson(),
                        ]
                    );

                }
                else
                {
                    $notification = array(
                        'message' => 'Fire & Enginering Slip added Endorsement Failed! data already endorsed!',
                        'alert-type' => 'error'
                    );

                    return response()->json(
                        $notification
                    );

                }
            }
        
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
