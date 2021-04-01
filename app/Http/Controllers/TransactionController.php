<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insured;

use Illuminate\Support\Facades\DB;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\SlipTableFileTemp;
use App\Models\CedingBroker;
use App\Models\FeLookupLocation;
use App\Models\MarineLookup;
use App\Models\Customer;
use App\Models\ConditionNeeded;
use App\Models\ExtendedCoverage;
use App\Models\ConditionNeededTemp;
use App\Models\RouteShip;
use App\Models\Currency;
use App\Models\DeductibleType;
use App\Models\Customer\Customer as CustomerCustomer;
use App\Models\ShipListTemp;
use App\Models\TranslocationTemp;
use App\Models\StatusLog;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\InterestInsuredTemp;
use App\Policies\FelookupLocationPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\RetrocessionTemp;
use App\Models\PropertyType;
use App\Models\PropertyTypeTemp;
use App\Models\TransPropertyTemp;
use App\Models\HoleDetail;
use App\Models\GolfFieldHole;
use Carbon\Carbon;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmarineslip(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip Entry';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        $currdate = date("d/m/Y");

        if(empty($search))
         {
            $userid = Auth::user()->id;
            $insured = Insured::orderby('id','asc')->get();
            $slip = SlipTable::orderby('id','asc')->get();
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::where('form','ms')->orderby('id','asc')->get();
            $koc = Koc::orderby('id','asc')->get();
            $ocp = Occupation::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
            $felookup = FelookupLocation::orderby('id','asc')->get();
            $cnd = ConditionNeeded::orderby('id','asc')->get();
            $mlu = MarineLookup::orderby('id','asc')->get();
            $customer= CustomerCustomer::orderby('id','asc')->get();
            $routeship= RouteShip::orderby('id','asc')->get();
            $interestinsured= InterestInsured::orderby('id','asc')->get();
            $deductibletype= DeductibleType::orderby('id','asc')->get();
            $ms_ids = response()->json($insured->modelKeys());
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
                if($sliplastid < 10)
                {
                    $code_sl = "M". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "M". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "M". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "M". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "M". $mydate . strval($sliplastid + 1);
                }
            }
            else{
                $code_sl = "M" . $mydate . "0000" . strval(1);
            }

            // $checklastins = Insured::where('slip_type','ms')->orderby('id','desc')->first();
            $checklastslip = SlipTable::where('slip_type','ms')->orderby('id','desc')->first();

            // if($checklastins->number == $checklastslip->insured_id)
            // {
            //     $lastinsid = $code_ms;
            // }
            // else{
            //     $lastinsid = $checklastins->number;
            // }
            
            if($checklastslip != null)
            {
                $edslipid = $checklastslip->id;
            }
            else{
                $edslipid = 0;
            }

            $slipdata2 = SlipTable::where('insured_id',$code_ms)->where('slip_type','ms')->where('endorsment','true')->delete();
            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->delete();
            $shiplist= ShipListTemp::where('insured_id',$code_ms)->where('status','saved')->delete();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->delete();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->delete();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->delete();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->delete();
            $statuslist= StatusLog::where('insured_id','=',$code_sl)->delete();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->delete();

            $slipdata2 = SlipTable::where('insured_id',$code_ms)->where('slip_type','ms')->where('endorsment','true')->orderby('id','desc')->get();
            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $shiplist= ShipListTemp::where('insured_id',$code_ms)->where('status','saved')->orderby('id','desc')->get();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();


            if(count($interestlist) != null){
                InterestInsuredTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($deductibletemp) != null){
                DeductibleTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($conditionneededtemp) != null){
                ConditionNeededTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($installmentpanel) != null){
                InstallmentTemp::where('slip_id', $code_sl)->delete();
            }
            
            if(count($retrocessiontemp) != null){
                RetrocessionTemp::where('slip_id', $code_sl)->delete();
            }

            $cobmodal =  COB::orderby('id','desc')->get();
            $kocmodal =  Koc::orderby('id','desc')->get();
            $ocpmodal =  Occupation::orderby('id','desc')->get();
            $cedbrokmodal =  CedingBroker::orderby('id','desc')->get();
            $cedingmodal =  CedingBroker::where('type','4')->orderby('id','desc')->get();
            $currencymodal =  Currency::orderby('id','desc')->get();


            return view('crm.transaction.marine_slip', compact(['user','kocmodal','ocpmodal','cedbrokmodal','cedingmodal','currencymodal','cobmodal','slipdata2','edslipid','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestinsured','routeship','customer','interestlist','shiplist','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         }
        else
        {
          $insured = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($insured->modelKeys());
          return view('crm.transaction.marine_slip', compact('user','customer','slip','insured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexhioslip(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Hole In One - Slip Entry';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        $currdate = date("d/m/Y");
        

        if(empty($search))
         {
            $insured = Insured::orderby('id','asc')->get();
            $slip = SlipTable::orderby('id','asc')->get();
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::where('form','ms')->orderby('id','asc')->get();
            $koc = Koc::orderby('id','asc')->get();
            $ocp = Occupation::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
            $felookup = FelookupLocation::orderby('id','asc')->get();
            $cnd = ConditionNeeded::orderby('id','asc')->get();
            $exc = ExtendedCoverage::orderby('id','asc')->get();
            $mlu = MarineLookup::orderby('id','asc')->get();
            $golffieldhole = GolfFieldHole::orderby('id','asc')->get();
            
            
            $customer= CustomerCustomer::orderby('id','asc')->get();
            $routeship= RouteShip::orderby('id','asc')->get();
            $interestinsured= InterestInsured::orderby('id','asc')->get();
            $deductibletype= DeductibleType::orderby('id','asc')->get();
            $ms_ids = response()->json($insured->modelKeys());
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
                    $code_sl = "HIO". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($lastid > 9 && $lastid < 100)
                {
                    $code_sl = "HIO". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($lastid > 99 && $lastid < 1000)
                {
                    $code_sl = "HIO". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($lastid > 999 && $lastid < 10000)
                {
                    $code_sl = "HIO". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($lastid > 9999 && $lastid < 100000)
                {
                    $code_sl = "HIO". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "HIO" . $mydate . "0000" . strval(1);
            }


            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            // $shiplist= ShipListTemp::where('insured_id',$code_ms)->where('status','saved')->orderby('id','desc')->get();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            // $extendcoveragetemp= ExtendCoverageTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
            $holedetaillist= HoleDetail::where('insured_id','=',$code_ms)->orderby('id','desc')->get();


            if(count($interestlist) != null){
                InterestInsuredTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($locationlist) != null){
                TransLocationTemp::where('insured_id', $code_ms)->delete();
            }

            if(count($holedetaillist) != null){
                HoleDetail::where('insured_id', $code_ms)->delete();
            }

            if(count($deductibletemp) != null){
                DeductibleTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($extendcoveragelist) != null){
                ExtendCoverageTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($conditionneededtemp) != null){
                ConditionNeededTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($installmentpanel) != null){
                InstallmentTemp::where('slip_id', $code_sl)->delete();
            }
            
            if(count($retrocessiontemp) != null){
                RetrocessionTemp::where('slip_id', $code_sl)->delete();
            }

            $checklastslip = SlipTable::where('slip_type','ms')->orderby('id','desc')->first();

            // if($checklastins->number == $checklastslip->insured_id)
            // {
            //     $lastinsid = $code_ms;
            // }
            // else{
            //     $lastinsid = $checklastins->number;
            // }
            
            if($checklastslip != null)
            {
                $edslipid = $checklastslip->id;
            }
            else{
                $edslipid = 0;
            }


            return view('crm.transaction.hio_slip', compact(['user','golffieldhole','holedetaillist','extendcoveragelist','edslipid','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestinsured','routeship','customer','interestlist','locationlist','exc','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         }
        else
        {
          $insured = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($insured->modelKeys());
          return view('crm.transaction.hio_slip', compact('user','extendcoveragetemp','customer','slip','insured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexpaslip(Request $request)
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $route_active = 'Personal Accident - Slip Entry';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        

            $insured = Insured::orderby('id','asc')->get();
            $slip = SlipTable::orderby('id','asc')->get();
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::where('form','ms')->orderby('id','asc')->get();
            $koc = Koc::orderby('id','asc')->get();
            $ocp = Occupation::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
            $felookup = FelookupLocation::orderby('id','asc')->get();
            $cnd = ConditionNeeded::orderby('id','asc')->get();
            $exc = ExtendedCoverage::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();
        $mlu = MarineLookup::orderby('id','asc')->get();
            
            
            $customer= CustomerCustomer::orderby('id','asc')->get();
            // $routeship= RouteShip::orderby('id','asc')->get();
            $interestinsured= InterestInsured::orderby('id','asc')->get();
            $deductibletype= DeductibleType::orderby('id','asc')->get();
            $ms_ids = response()->json($insured->modelKeys());
            $lastid = count($insured);
            $sliplastid = count($slip);

            if($lastid != null){
                if($lastid < 9)
                {
                    $code_ms = "IN" . $mydate . "0000" . strval($lastid + 1);
                }   
                elseif($lastid > 8 && $lastid < 100)
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

            $slipdata=SlipTable::where('insured_id',$code_ms)->first();
            $slipdata2=SlipTable::where('insured_id',$code_ms)->get();

            if($sliplastid != null){
                if($lastid < 10)
                {
                    $code_sl = "PA" . $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($lastid > 9 && $lastid < 100)
                {
                    $code_sl = "PA" . $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($lastid > 99 && $lastid < 1000)
                {
                    $code_sl = "PA" . $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($lastid > 999 && $lastid < 10000)
                {
                    $code_sl = "PA" . $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($lastid > 9999 && $lastid < 100000)
                {
                    $code_sl = "PA" . $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "PA" . $mydate . "0000" . strval(1);
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
                        $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 100)
                    {
                        $code_sl = "FE".  $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "FE".  $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "FE".  $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "FE".  $mydate . strval($sliplastid + $i);
                    }
                }

                $i++;
            }

            InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            ExtendCoverageTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->delete();
            TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->delete();

            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessionlist= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            $locationlist= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

            if(count($interestlist) != null){
                InterestInsuredTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($deductiblelist) != null){
                DeductibleTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($extendcoveragelist) != null){
                ExtendCoverageTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($conditionneededtemp) != null){
                ConditionNeededTemp::where('slip_id', $code_sl)->delete();
            }

            if(count($installmentlist) != null){
                InstallmentTemp::where('slip_id', $code_sl)->delete();
            }
            
            if(count($retrocessionlist) != null){
                RetrocessionTemp::where('slip_id', $code_sl)->delete();
            }

            $checklastslip = SlipTable::where('slip_type','ms')->orderby('id','desc')->first();

            // if($checklastins->number == $checklastslip->insured_id)
            // {
            //     $lastinsid = $code_ms;
            // }
            // else{
            //     $lastinsid = $checklastins->number;
            // }
            
            if($checklastslip != null)
            {
                $edslipid = $checklastslip->id;
            }
            else{
                $edslipid = 0;
            }


            return view('crm.transaction.pa_slip', compact(['user','installmentlist','extendedcoverage','slipdata2','edslipid','statuslist','retrocessionlist','conditionneededtemp','deductiblelist','deductibletype','interestinsured','locationlist','extendcoveragelist','customer','interestlist','exc','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         
    }

    public function indexmarine(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Marine Slip - Index';   
         $mydate = date("Y").date("m").date("d");
         $ms_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'ms')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::with('insureddata')->where('slip_type', '=', 'ms')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

        //   dd($slip);
          return view('crm.transaction.marine_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'ms')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'ms')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());
        
          
        
          return view('crm.transaction.marine_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }

    public function indexhio(Request $request)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Hole In One - Index';   
        $mydate = date("Y").date("m").date("d");
        $hio_ids = response()->json($country->modelKeys());

        $search = @$request->input('search');

            if(empty($search))
            {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
            $insured = Insured::where('slip_type', '=', 'hio')->orderby('id','desc')->paginate(10);
            $insured_ids = response()->json($insured->modelKeys());
            $slip = SlipTable::where('slip_type', '=', 'hio')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($slip->modelKeys());

            return view('crm.transaction.hio_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
            }
            else
            {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
        
            $insured = Insured::where('slip_type', '=', 'hio')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
            $insured_ids = response()->json($insured->modelKeys());
            $slip = SlipTable::where('slip_type', '=', 'hio')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($slip->modelKeys());
        
            return view('crm.transaction.hio_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
            }
    }

    public function indexpa(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Personal Accident - Index';   
         $mydate = date("Y").date("m").date("d");
         $ms_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'pa')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'pa')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

          return view('crm.transaction.pa_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'pa')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'pa')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

        
          return view('crm.transaction.pa_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    public function storemarineinsured(Request $request)
    {
        $validator = $request->validate([
            'msinumber'=>'required',
            'msisuggestinsured'=>'required'
        ]);

        $shiplist= ShipListTemp::where('insured_id','=',$request->msinumber)->where('status','=','pending')->orderby('created_at','desc')->get();
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->msinumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->msinumber,
                    'slip_type'=>'ms',
                    'insured_prefix' => $request->msiprefix,
                    'insured_name'=>$request->msisuggestinsured,
                    'insured_suffix'=>$request->msisuffix,
                    'route'=>$request->msiroute,
                    'route_from'=>$request->msiroutefrom,
                    'route_to'=>$request->msirouteto,
                    'share'=>$request->msishare,
                    'share_from'=>$request->msisharefrom,
                    'share_to'=>$request->msishareto,
                    'ship_detail'=>$shiplist->toJson()
                    // 'coincurance'=>$request->msicoinsurance
                ]);

                $notification = array(
                    'message' => 'Marine Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->slip_type='ms';
                $insureddataup->insured_prefix=$request->msiprefix;
                $insureddataup->insured_name=$request->msisuggestinsured;
                $insureddataup->insured_suffix=$request->msisuffix;
                $insureddataup->route=$request->msiroute;
                $insureddataup->route_from=$request->msiroutefrom;
                $insureddataup->route_to=$request->msirouteto;
                $insureddataup->share=$request->msishare;
                $insureddataup->share_from=$request->msisharefrom;
                $insureddataup->share_to=$request->msishareto;
                $insureddataup->ship_detail=$shiplist->toJson();
                // $insureddataup->coincurance=$request->msicoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Marine Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }
            // dd($shiplist);
            // ShipListTemp::whereIn('id', $shiplist->id)->update(['status' => 'saved']);
            // ShipListTemp::where('status','pending')->delete();

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Marine Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storemarineslip(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
            'slipuy'=>'required',
            'slippolicy_no'=>'required',
            'slipno'=>'required',
            'slipcndn'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
            
            
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $conditionneededlist= ConditionNeededTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             
            $slipfile=SlipTableFile::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             

            if($slipdata==null)
            {
                $currdate = date("Y-m-d");

                $newmarineslip = SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>Auth::user()->name,
                    'insured_id'=>$request->code_ms,
                    'slip_type'=>'ms',
                    'prod_year' => $currdate,
                    'uy'=>$request->slipuy,
                    'status'=>$request->slipstatus,
                    'endorsment'=>'true',
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
                    'attacment_file'=>$slipfile->toJson(),
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'condition_needed'=>$conditionneededlist->toJson(),
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
                    'v_broker'=>$request->slipvbroker,
                    'commission'=>$request->slipcommission,
                    'grossprm_to_nr'=>$request->slipgrossprmtonr,
                    'netprm_to_nr'=>$request->slipnetprmtonr,
                    'sum_commission'=>$request->slipsumcommission,
                    'installment_panel'=>$installmentlist->toJson(),
                    'retrocession_panel'=>$retrocessionlist->toJson(),
                    'retro_backup'=>$request->sliprb,
                    'own_retention'=>$request->slipor,
                    'sum_own_retention'=>$request->slipsumor,
                    'coinsurance_slip'=>$request->slipcoinsurance

                ]);

                StatusLog::create([
                    'insured_id'=>$request->code_ms,
                    'status'=>$request->slipstatus,
                    'datetime'=>date('Y-m-d H:i:s'),
                    'slip_id'=>$request->slipnumber,
                    'user'=>Auth::user()->name,
                ]);

                $insdata = Insured::where('number',$request->code_ms)->where('slip_type','ms')->first();

                $inscoinsurance = $insdata->coincurance . ',' . $request->slipcoinsurance;

                $msdata = Insured::findOrFail($insdata->id);
                $msdata->share=$request->sharems;
                $msdata->share_from=$request->sumsharems;
                $msdata->share_to=$request->tsims;
                $msdata->coincurance=$inscoinsurance;
                $msdata->save();

                $mydate = date("Y").date("m").date("d");
                $slip = SlipTable::orderby('id','asc')->get();
                $sliplastid = count($slip);
                $userid = Auth::user()->id;
                if($sliplastid != null){
                    if($sliplastid < 10)
                    {
                        $code_sl = "M". $mydate . "0000" . strval($sliplastid + 1);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "M". $mydate . "000" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "M". $mydate . "00" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "M". $mydate . "0" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "M". $mydate . strval($sliplastid + 1);
                    }
                }
                else{
                    $code_sl = "M" . $mydate . "0000" . strval(1);
                }


                return response()->json([
                    'id' => $newmarineslip->id,
                    'slip_number' => $newmarineslip->number,
                    'new_slip_number' => $code_sl,
                    'uy' => $newmarineslip->uy,
                    'status' => $newmarineslip->status,
                    'insured_id' => $newmarineslip->insured_id
                ]);
            }
            else
            {
                $currdate = date("d/m/Y");

                $var = $request->prod_year;
                $date = str_replace('/', '-', $var);
                $prod_year = date('Y-m-d', strtotime($date));

                $slipdataid=$slipdata->id;
                $slipdataup = SlipTable::findOrFail($slipdataid);
                
                
                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
                $slipdataup->prod_year=$prod_year;
                $slipdataup->uy=$request->slipuy;
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment='true';
                $slipdataup->selisih='false';
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
                $slipdataup->attacment_file=$slipfile->toJson(); 
                $slipdataup->interest_insured=$interestlist->toJSon();
                $slipdataup->total_sum_insured=$request->sliptotalsum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->condition_needed=$conditionneededlist->toJson();  
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
                $slipdataup->v_broker=$request->slipvbroker;
                $slipdataup->commission=$request->slipcommission; 
                $slipdataup->grossprm_to_nr=$request->slipgrossprmtonr; 
                $slipdataup->netprm_to_nr=$request->slipnetprmtonr; 
                $slipdataup->sum_commission=$request->slipsumcommission; 
                $slipdataup->installment_panel=$installmentlist->toJson();   
                $slipdataup->retrocession_panel=$retrocessionlist->toJson();  
                $slipdataup->retro_backup=$request->sliprb;
                $slipdataup->own_retention=$request->slipor;
                $slipdataup->sum_own_retention=$request->slipsumor;
                $slipdataup->coinsurance_slip=$request->slipcoinsurance;

                $slipdataup->save();

                StatusLog::create([
                    'insured_id'=>$request->code_ms,
                    'status'=>$request->slipstatus,
                    'datetime'=>date('Y-m-d H:i:s '),
                    'slip_id'=>$request->slipnumber,
                    'user'=>Auth::user()->name,
                ]);

                $insdata = Insured::where('number',$request->code_ms)->where('slip_type','ms')->first();

                if($insdata->coincurance == null){
                    $inscoinsurance = $request->slipcoinsurance;
                }
                else{
                    $inscoinsurance = $insdata->coincurance . ',' . $request->slipcoinsurance;
                }
                

                $msdata = Insured::findOrFail($insdata->id);
                $msdata->share=$request->sharems;
                $msdata->share_from=$request->sumsharems;
                $msdata->share_to=$request->tsims;
                $msdata->coincurance=$inscoinsurance;
                $msdata->save();

                // $mydate = date("Y").date("m").date("d");
                // $slip = SlipTable::orderby('id','asc')->get();
                // $sliplastid = count($slip);
                // $userid = Auth::user()->id;
                // if($sliplastid != null){
                //     if($sliplastid < 10)
                //     {
                //         $code_sl = "M". $mydate . "0000" . strval($sliplastid + 1);
                //     }   
                //     elseif($sliplastid > 9 && $sliplastid < 100)
                //     {
                //         $code_sl = "M". $mydate . "000" . strval($sliplastid + 1);
                //     }
                //     elseif($sliplastid > 99 && $sliplastid < 1000)
                //     {
                //         $code_sl = "M". $mydate . "00" . strval($sliplastid + 1);
                //     }
                //     elseif($sliplastid > 999 && $sliplastid < 10000)
                //     {
                //         $code_sl = "M". $mydate . "0" . strval($sliplastid + 1);
                //     }
                //     elseif($sliplastid > 9999 && $sliplastid < 100000)
                //     {
                //         $code_sl = "M". $mydate . strval($sliplastid + 1);
                //     }
                // }
                // else{
                //     $code_sl = "M" . $mydate . "0000" . strval(1);
                // }

                return response()->json([
                    'id' => $slipdataup->id,
                    'slip_number' => $slipdataup->number,
                    // 'new_slip_number' => $code_sl,
                    'uy' => $slipdataup->uy,
                    'status' => $slipdataup->status,
                    'insured_id' => $slipdataup->insured_id
                ]);
            }
            
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Marine Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storeholeinoneinsured(Request $request)
    {
        $validator = $request->validate([
            'msinumber'=>'required',
            'msisuggestinsured'=>'required'
        ]);

        $holedetail= HoleDetail::where('insured_id','=',$request->msinumber)->orderby('created_at','desc')->get();
        $locationlist= TransLocationTemp::where('insured_id','=',$request->msinumber)->orderby('created_at','desc')->get();
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->msinumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->msinumber,
                    'slip_type'=>'hio',
                    'insured_prefix' => $request->msiprefix,
                    'insured_name'=>$request->msisuggestinsured,
                    'insured_suffix'=>$request->msisuffix,
                    'route'=>$request->msiroute,
                    'route_from'=>$request->msiroutefrom,
                    'route_to'=>$request->msirouteto,
                    'share'=>$request->msishare,
                    'share_from'=>$request->msisharefrom,
                    'share_to'=>$request->msishareto,
                    'location'=>$locationlist->toJson(),
                    'hole_detail'=>$holedetail->toJson(),
                    'coincurance'=>$request->msicoinsurance
                ]);

                $notification = array(
                    'message' => 'Hole in One Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->slip_type='hio';
                $insureddataup->insured_prefix=$request->msiinsured;
                $insureddataup->insured_name=$request->msisuggestinsured;
                $insureddataup->insured_suffix=$request->msisuffix;
                $insureddataup->route=$request->msiroute;
                $insureddataup->route_from=$request->msiroutefrom;
                $insureddataup->route_to=$request->msirouteto;
                $insureddataup->share=$request->msishare;
                $insureddataup->share_from=$request->msisharefrom;
                $insureddataup->share_to=$request->msishareto;
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->hole_detail=$holedetail->toJson();
                $insureddataup->coincurance=$request->msicoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Hole in One Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }
            // dd($locationlist);
            // ShipListTemp::whereIn('id', $shiplist->id)->update(['status' => 'saved']);
            // ShipListTemp::where('status','pending')->delete();

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Hole in One Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storeholeinoneslip(Request $request)
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
                    'slip_type'=>'hio',
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
                    $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 9 && $sliplastid < 100)
                {
                    $code_sl = "FE".  $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "FE".  $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "FE".  $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "FE".  $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "FE".  $mydate . "0000" . strval(1);
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
                        $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 9 && $sliplastid < 100)
                    {
                        $code_sl = "FE".  $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "FE".  $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "FE".  $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "FE".  $mydate . strval($sliplastid + $i);
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

    public function storepersonalaccidentinsured(Request $request)
    {
        $validator = $request->validate([
            'msinumber'=>'required'
        ]);

        $shiplist= FeLookupLocation::where('insured_id','=',$request->msinumber)->orderby('created_at','desc')->get();
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->msinumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->msinumber,
                    'slip_type'=>'pa',
                    'insured_prefix' => $request->msiprefix,
                    'insured_name'=>$request->msisuggestinsured,
                    'insured_suffix'=>$request->msisuffix,
                    'share'=>$request->msishare,
                    'share_from'=>$request->msisharefrom,
                    'share_to'=>$request->msishareto,
                    'location'=>$shiplist->toJson(),
                    'coincurance'=>$request->msicoinsurance
                ]);

                $notification = array(
                    'message' => 'Personal Accident Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->slip_type='pa';
                $insureddataup->insured_prefix=$request->msiinsured;
                $insureddataup->insured_name=$request->msisuggestinsured;
                $insureddataup->insured_suffix=$request->msisuffix;
                $insureddataup->share=$request->msishare;
                $insureddataup->share_from=$request->msisharefrom;
                $insureddataup->share_to=$request->msishareto;
                $insureddataup->location=$shiplist->toJson();
                $insureddataup->coincurance=$request->msicoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Personal Accident Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }
            // dd($shiplist);
            // ShipListTemp::whereIn('id', $shiplist->id)->update(['status' => 'saved']);
            // ShipListTemp::where('status','pending')->delete();

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Personal Accident Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storepersonalaccidentslip(Request $request)
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
                    'slip_type'=>'pa',
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
                    'message' => 'Personal Accident Slip added successfully!',
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
                    'message' => 'Personal Accident Slip Update successfully!',
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
                if($sliplastid < 9)
                {
                    $code_sl = "PA".  $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 8 && $sliplastid < 100)
                {
                    $code_sl = "PA".  $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "PA".  $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "PA".  $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "PA".  $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "PA".  $mydate . "0000" . strval(1);
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
                        $code_sl = "PA".  $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 100)
                    {
                        $code_sl = "PA".  $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "PA".  $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "PA".  $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "PA".  $mydate . strval($sliplastid + $i);
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
                'message' => 'Personal Accident Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storepersonalaccidentendorsement(Request $request)
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
                    'message' => 'Personal Accident Slip added Fail!',
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
                $slipdataup->attachment_file=''; 
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
                    'message' => 'Personal Accident Slip Update successfully!',
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
                if($sliplastid < 9)
                {
                    $code_sl = "PA".  $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 8 && $sliplastid < 100)
                {
                    $code_sl = "PA".  $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 99 && $sliplastid < 1000)
                {
                    $code_sl = "PA".  $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 999 && $sliplastid < 10000)
                {
                    $code_sl = "PA".  $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9999 && $sliplastid < 100000)
                {
                    $code_sl = "PA".  $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "PA".  $mydate . "0000" . strval(1);
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
                        $code_sl = "PA".  $mydate . "0000" . strval($sliplastid + $i);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 100)
                    {
                        $code_sl = "PA".  $mydate . "000" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 99 && $sliplastid < 1000)
                    {
                        $code_sl = "PA".  $mydate . "00" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 999 && $sliplastid < 10000)
                    {
                        $code_sl = "PA".  $mydate . "0" . strval($sliplastid + $i);
                    }
                    elseif($sliplastid > 9999 && $sliplastid < 100000)
                    {
                        $code_sl = "PA".  $mydate . strval($sliplastid + $i);
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
                'message' => 'Personal Accident Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storeshiplist(Request $request)
    {

            $shipcode = $request->ship_code;
            $shipname = $request->ship_name;
            $insured_id = $request->insuredID;
        
            if($shipcode !='' && $shipname !='' && $insured_id != ''){
                $shiplist = new ShipListTemp();
                $shiplist->insured_id = $insured_id;
                $shiplist->ship_code = $shipcode;
                $shiplist->ship_name = $shipname; 
                $shiplist->status = "pending"; 
                $shiplist->save();

                return response()->json($shiplist);
        
            }else{
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );
            }
        
    }

    public function storeinterestlist(Request $request)
    {

            $interest = $request->interest_insured;
            $amount = $request->slipamount;
            $slip_id = $request->id_slip;
        
            if($interest !='' && $amount !='' && $slip_id != ''){
                $interestlist = new InterestInsuredTemp();
                $interestlist->interest_id  = $interest;
                $interestlist->amount = $amount;
                $interestlist->slip_id = $slip_id; 
                $interestlist->save();


                $interestdata= InterestInsured::where('id','=',$interest)->first();

                return response()->json(
                    [
                        'id' => $interestlist->id,
                        'interest_id' => $interestlist->interest_id,
                        'amount' => $interestlist->amount,
                        'slip_id' => $interestlist->slip_id,
                        'description' => $interestdata->description
                    ]
                );
        
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


    public function storeinstallmentlist(Request $request)
    {

            $percentage = $request->percentage;
            $installmentdate = $request->installmentdate;
            $amount = $request->slipamount;
            $slip_id = $request->id_slip;

            $checkit = DB::table('installment_temp')->where('installment_temp.slip_id',$slip_id)->sum('installment_temp.percentage');
            $totalpercent = $checkit + $percentage;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
                if($totalpercent <= 100){
                    $old_date_timestamp = strtotime($installmentdate);
                    $new_date = date('Y-m-d', $old_date_timestamp); 

                    $installmentlist = new InstallmentTemp();
                    $installmentlist->installment_date  = $new_date;
                    $installmentlist->percentage  = $percentage;
                    $installmentlist->amount = $amount;
                    $installmentlist->slip_id = $slip_id; 
                    $installmentlist->save();

                    $checkit2 = DB::table('installment_temp')->where('installment_temp.slip_id',$installmentlist->slip_id)->sum('installment_temp.percentage');
                    $minpercent2 = 100 - $checkit2;

                    if($checkit2 < 100){
                            return response()->json(
                                [
                                    'id' => $installmentlist->id,
                                    'percentage' => $installmentlist->percentage,
                                    'installment_date' => date("d/m/Y", strtotime($installmentlist->installment_date)),
                                    'amount' => $installmentlist->amount,
                                    'slip_id' => $installmentlist->slip_id,
                                    'message' => 'sorry percent must 100%, your percent minus '. $minpercent2.'percent'
                                ]
                            );
                        }
                    elseif ($checkit2 == 100) {
                        return response()->json(
                                [
                                    'id' => $installmentlist->id,
                                    'percentage' => $installmentlist->percentage,
                                    'installment_date' => date("d/m/Y", strtotime($installmentlist->installment_date)),
                                    'amount' => $installmentlist->amount,
                                    'slip_id' => $installmentlist->slip_id
                                ]
                            );
                    }
                }else{
                    return response()->json(
                        [
                            'code_error' => '404',
                            'message' => 'sorry percent cannot more than 100%'
                        ]
                    );
                }
        
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

    public function storedeductiblelist(Request $request)
    {

            $deductibletype_id = $request->slipdptype;
            $currency = $request->slipdpcurrency;
            $minamount = $request->minamount;
            $amount = $request->amount;
            $percentage = $request->percentage;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
                
                $deductiblelist = new DeductibleTemp();
                $deductiblelist->deductibletype_id  = $deductibletype_id;
                $deductiblelist->currency_id  = $currency;
                $deductiblelist->percentage  = $percentage;
                $deductiblelist->amount = $amount;
                $deductiblelist->min_claimamount = $minamount;
                $deductiblelist->slip_id = $slip_id; 
                $deductiblelist->save();

                return response()->json(
                    [
                        'id' => $deductiblelist->id,
                        'deductibletype_id' => $deductiblelist->deductibletype_id,
                        'deductibletype' => $deductiblelist->DeductibleType->description,
                        'dtdescript' => $deductiblelist->DeductibleType->description,
                        'dtabbrev' => $deductiblelist->DeductibleType->abbreviation,
                        'percentage' => $deductiblelist->percentage,
                        'currency_id' => $deductiblelist->currency_id,
                        'currencydata' => $deductiblelist->currency->code.'-'.$deductiblelist->currency->symbol_name,
                        'amount' => $deductiblelist->amount,
                        'min_claimamount' => $deductiblelist->min_claimamount,
                        'slip_id' => $deductiblelist->slip_id
                    ]
                );
        
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


    public function storeextendcoveragelist(Request $request)
    {

            $percentage = $request->percentage;
            $slipcncode = $request->slipcncode;
            $amount = $request->amount;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
            
                $extendcoveragelist = new ExtendCoverageTemp();
                $extendcoveragelist->extendcoverage_id  = $slipcncode;
                $extendcoveragelist->percentage  = $percentage;
                $extendcoveragelist->amount = $amount;
                $extendcoveragelist->slip_id = $slip_id; 
                $extendcoveragelist->save();

                return response()->json(
                    [
                        'id' => $extendcoveragelist->id,
                        'percentage' => $extendcoveragelist->percentage,
                        'extendcoverage_id' => $extendcoveragelist->extendcoverage_id,
                        'coveragetype' => $extendcoveragelist->extendcoveragedata->description,
                        'amount' => $extendcoveragelist->amount,
                        'slip_id' => $extendcoveragelist->slip_id
                    ]
                );
        
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

    public function storeconditionneededlist(Request $request)
    {
            
            $slipcncode = $request->slipcncode;
            $cn = ConditionNeeded::where('id',$slipcncode)->first();
            $information = $cn->description;
            $slip_id = $request->id_slip;
        
            if($slipcncode !='' && $slip_id != '')
            {
            
                $conditionneededlist = new ConditionNeededTemp();
                $conditionneededlist->condition_id  = $slipcncode;
                $conditionneededlist->information  = $information;
                $conditionneededlist->slip_id = $slip_id; 
                $conditionneededlist->save();

                return response()->json(
                    [
                        'id' => $conditionneededlist->id,
                        'conditionneeded_id' => $conditionneededlist->condition_id,
                        'condition' => $conditionneededlist->conditionneeded->name,
                        'information' => $conditionneededlist->information,
                        'slip_id' => $conditionneededlist->slip_id
                    ]
                );
        
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

    public function storeretrocessionlist(Request $request)
    {

            $percentage = $request->percentage;
            $contract = $request->contract;
            $type = $request->type;
            $amount = $request->amount;
            $slip_id = $request->id_slip;
            $percentage_or = $request->or_percent;

            $checkit = DB::table('retrocession_temp')->where('retrocession_temp.slip_id',$slip_id)->sum('retrocession_temp.percentage');
            $totalpercent = $checkit + $percentage + $percentage_or;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
            
                if($totalpercent <= 100){
                    $retrocessionlist = new RetrocessionTemp();
                    $retrocessionlist->type  = $type;
                    $retrocessionlist->contract  = $contract;
                    $retrocessionlist->percentage  = $percentage;
                    $retrocessionlist->amount = $amount;
                    $retrocessionlist->slip_id = $slip_id; 
                    $retrocessionlist->save();

                    $checkit2 = DB::table('retrocession_temp')->where('retrocession_temp.slip_id',$retrocessionlist->slip_id)->sum('retrocession_temp.percentage');
                    $totalpercent2 = $percentage_or + $checkit2;
                    $minpercent2 = 100 - $totalpercent2;

                    if($totalpercent2 < 100){
                        return response()->json(
                            [
                                'id' => $retrocessionlist->id,
                                'percentage' => $retrocessionlist->percentage,
                                'contract' => $retrocessionlist->contract,
                                'type' => $retrocessionlist->type,
                                'amount' => $retrocessionlist->amount,
                                'slip_id' => $retrocessionlist->slip_id,
                                'message' => 'sorry percent must 100%, your percent minus '.$minpercent2.'percent'
                            ]
                        );
                    }elseif($totalpercent2 == 100){
                        return response()->json(
                        [
                            'id' => $retrocessionlist->id,
                            'percentage' => $retrocessionlist->percentage,
                            'contract' => $retrocessionlist->contract,
                            'type' => $retrocessionlist->type,
                            'amount' => $retrocessionlist->amount,
                            'slip_id' => $retrocessionlist->slip_id
                        ]
                    );
                    }
                }
                else{
                    return response()->json(
                        [
                            'code_error' => '404',
                            'message' => 'sorry percent cannot more than 100%'
                        ]
                    );
                }
        
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

    public function storepropertytypelist(Request $request)
    {
        
            $property_type_id = $request->property_type_id;
            $slip_id = $request->id_slip;
            $insured_id = $request->insured_id;
        
            if($property_type_id !='' && $slip_id != '')
            {
            
                $retrocessionlist = new PropertyTypeTemp();
                $retrocessionlist->property_type_id  = $property_type_id;
                $retrocessionlist->slip_id = $slip_id; 
                $retrocessionlist->insured_id = $insured_id; 
                $retrocessionlist->save();

                $retrocessionlist = new TransPropertyTemp();
                $retrocessionlist->property_type_id  = $property_type_id;
                $retrocessionlist->insured_id = $insured_id; 
                $retrocessionlist->save();

                return response()->json(
                    [
                        'id' => $retrocessionlist->id,
                        'propertydata' => $retrocessionlist->propertytypedata->name,
                        'property_type_id' => $retrocessionlist->property_type_id,
                        'slip_id' => $retrocessionlist->slip_id
                    ]
                );
        
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

    public function storeholedetaillist(Request $request)
    {

            $golffieldhole = $request->golffield_hole;
            $event = $request->event;
            $insured_id = $request->insuredID;
            $mydate = date("Y").date("m").date("d");
            $golffield = GolfFieldHole::where('id',$golffieldhole)->first();
            $count_hole = HoleDetail::where('insured_id',$insured_id)->get();
            $lastid = count($count_hole);

            if($lastid != null){
                if($lastid < 10)
                {
                    $code =  $mydate . "00000" . strval($lastid + 1);
                }   
                elseif($lastid > 9 && $lastid < 100)
                {
                    $code = "IN" . $mydate . "0000" . strval($lastid + 1);
                }

            }
            else{
                $code =  $mydate . "00000" . strval(1);
            }


            if($golffieldhole !='' && $insured_id !='' )
            {
            
                $holedetaillist = new HoleDetail();
                $holedetaillist->code  = $code;
                $holedetaillist->golffieldhole_id  = $golffieldhole;
                $holedetaillist->event  = $event;
                $holedetaillist->insured_id = $insured_id;
                $holedetaillist->save();

                return response()->json(
                    [
                        'id' => $holedetaillist->id,
                        'code' => $holedetaillist->code,
                        'golffield_hole' => $golffield->golf_field,
                        'event' => $holedetaillist->event,
                        'insured_id' => $holedetaillist->insured_id
                    ]
                );
        
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRouteList(Request $request)
    {
        $route = DB::table("route")
        ->join('ship_port as sp1', 'route.from', '=', 'sp1.id')
        ->join('ship_port as sp2', 'route.to', '=', 'sp2.id')
        ->where("route.id",$request->route_code)
        ->select('route.*','sp1.name as route_from','sp2.name as route_to')
        ->first();

        // dd($route);
        return response()->json([
            'route_from' => $route->route_from,
            'route_to' => $route->route_to
        ]);
    }

    public function showShipList(Request $request)
    {
        $ship = DB::table("marine_lookup")
        ->where("code",$request->ship_code)
        ->first();
        return response()->json($ship);
    }

    public function showinterestinsuredList(Request $request)
    {
        $interestlist = InterestInsuredTemp::where("id",$request->ins_code)->first();
        return response()->json(
            [
                'id' => $interestlist->id,
                'interest_id' => $interestlist->interest_id,
                'amount' => $interestlist->amount,
                'slip_id' => $interestlist->slip_id,
                'description' => $interestlist->interestinsureddata->description
            ]
        );
    }

    public function showdeductibleList(Request $request)
    {
        $deductibletemp = DB::table("deductible_temp")
        ->where("id",$request->deductible_code)
        ->first();
        return response()->json($deductibletemp);
    }

    public function showconditionneededList(Request $request)
    {
        $conditionneeded = DB::table("condition_needed_temp")
        ->where("id",$request->cn_code)
        ->first();
        return response()->json($conditionneeded);
    }

    public function showextendcoverageList(Request $request)
    {
        $extendcoverage = DB::table("extendedcoverage_temp")
        ->where("id",$request->ec_code)
        ->first();
        return response()->json($extendcoverage);
    }

    public function showinstallmentList(Request $request)
    {
        $installmenttemp = DB::table("installment_temp")
        ->where("id",$request->intem_code)
        ->first();
        return response()->json($installmenttemp);
    }

    public function showretrocessionList(Request $request)
    {
        $retrocessionlist = DB::table("retrocession_temp")
        ->where("id",$request->rsc_code)
        ->first();
        return response()->json($retrocessionlist);
    }

    public function showholedetailList(Request $request)
    {
        $holedetaillist = DB::table("hole_detail_temp")
        ->where("id",$request->hd_code)
        ->first();
        return response()->json($holedetaillist);
    }

    public function showinsureddetails($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        
        $insured = Insured::where('id',$id)->orderby('id','desc')->get();
        // dd($insured);
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
            

        $code_ms = $insured[0]->number;

        
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();
        


        return view('crm.transaction.marine_insured_details', compact(['user','routeship','customer','shiplist','mlu','insured','route_active','ms_ids']));
    }

    public function showslipdetails($id)
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $route_active = 'Marine - Slip and Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        
        // $sl_ids = response()->json($slip->modelKeys());
        
        $insured = Insured::where('id',$id)->orderby('id','desc')->get();
        // dd($insured[0]->number);
        $slip = SlipTable::orderby('id','desc')->get();
        // dd($slip);
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','ms')->orderby('id','asc')->get();
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $code_ms = $insured[0]->number;
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();
        // dd($slip);
        $sliplastid = count($slip);
        if($sliplastid != null){
            if($sliplastid < 10)
            {
                $code_sl = "M". $mydate . "0000" . strval($sliplastid + 1);
            }   
            elseif($sliplastid > 9 && $sliplastid < 100)
            {
                $code_sl = "M". $mydate . "000" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 99 && $sliplastid < 1000)
            {
                $code_sl = "M". $mydate . "00" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 999 && $sliplastid < 10000)
            {
                $code_sl = "M". $mydate . "0" . strval($sliplastid + 1);
            }
            elseif($sliplastid > 9999 && $sliplastid < 100000)
            {
                $code_sl = "M". $mydate . strval($sliplastid + 1);
            }
        }
        else{
            $code_sl = "M" . $mydate . "0000" . strval(1);
        }

        
        // $currency = Currency::orderby('id','asc')->get();
        // $cob = COB::where('id',$id)->orderby('id','asc')->first();
        // $koc = Koc::where('id',$id)->orderby('id','asc')->first();
        // $ocp = Occupation::where('id',$id)->orderby('id','asc')->first();
        // $cedingbroker = CedingBroker::where('id',$id)->orderby('id','asc')->first();
        // $ceding = CedingBroker::where('id',$id)->orderby('id','asc')->where('type','4')->first();
        // $felookup = FelookupLocation::where('id',$id)->orderby('id','asc')->get();
        // $cnd = ConditionNeeded::where('id',$id)->orderby('id','asc')->get();

        $cobmodal =  COB::orderby('id','desc')->get();
        $kocmodal =  Koc::orderby('id','desc')->get();
        $ocpmodal =  Occupation::orderby('id','desc')->get();
        $cedbrokmodal =  CedingBroker::orderby('id','desc')->get();
        $cedingmodal =  CedingBroker::where('type','4')->orderby('id','desc')->get();
        $currencymodal =  Currency::orderby('id','desc')->get();

        // $sliplastid = count($slip);

        $slipdata2 = SlipTable::where('insured_id',$code_ms)->where('slip_type','ms')->where('endorsment','true')->orderby('id','desc')->get();
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        // dd($slip->prod_year);
       
        return view('crm.transaction.marine_slip_details', compact(['user','kocmodal','ocpmodal','cedbrokmodal','cedingmodal','currencymodal','cobmodal','slipdata2','filelist','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','interestlist','cnd','felookup','currency','cob','koc','ocp','ceding','cedingbroker','deductibletype','interestinsured','slip','route_active','code_sl','code_ms','currdate','routeship','shiplist','mlu','insured','ms_ids']));
    }

    public function showslipmodaldetails($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip and Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        $slip = SlipTable::where('id',$id)->orderby('id','asc')->first();
        // $sl_ids = response()->json($slip->modelKeys());
        $insured = Insured::where('number',$slip->insured_id)->orderby('id','desc')->first();
        // dd($insured);
        $route = $insured->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        // $ms_ids = response()->json($insured->modelKeys());
        // $lastid = count($insured);
        $code_ms = $insured->number;
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();

        $code_sl = $slip->number;
        
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('id',$slip->cob)->orderby('id','asc')->first();
        $koc = Koc::where('id',$slip->koc)->orderby('id','asc')->first();
        $ocp = Occupation::where('id',$id)->orderby('id','asc')->first();
        $cedingbroker = CedingBroker::where('id',$slip->source)->orderby('id','asc')->first();
        $ceding = CedingBroker::where('id',$slip->source_2)->orderby('id','asc')->where('type','4')->first();
        $felookup = FelookupLocation::where('id',$id)->orderby('id','asc')->get();
        $cnd = ConditionNeeded::where('id',$id)->orderby('id','asc')->get();

        // $sliplastid = count($slip);

        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        // $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $interestlist = DB::table('interestinsured_temp')
            ->join('interest_insured', 'interest_insured.id', '=', 'interestinsured_temp.interest_id')
            ->select('interestinsured_temp.*', 'interest_insured.code', 'interest_insured.description')
            ->where('interestinsured_temp.slip_id',$code_sl)
            ->get();
        // $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $deductibletemp = DB::table('deductible_temp')
            ->join('deductible_type', 'deductible_type.id', '=', 'deductible_temp.deductibletype_id')
            ->join('currencies', 'currencies.id', '=', 'deductible_temp.currency_id')
            ->select('deductible_temp.*', 'currencies.code','currencies.symbol_name','deductible_type.abbreviation', 'deductible_type.description')
            ->where('deductible_temp.slip_id',$code_sl)
            ->get();
        // $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $conditionneededtemp = DB::table('condition_needed_temp')
        ->join('condition_needed', 'condition_needed.id', '=', 'condition_needed_temp.condition_id')
        ->select('condition_needed_temp.*', 'condition_needed.name','condition_needed.code' ,'condition_needed.description')
        ->where('condition_needed_temp.slip_id',$code_sl)
        ->get();
        $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('created_at','DESC')->get();

        // dd($cob);
        if($slip->all())
        {
            return response()->json([
                "id" => $slip->id,
                "insured_id" => $slip->insured_id,
                "slip_number" => $slip->number,
                "username" => $slip->username,
                "prod_year" => $slip->prod_year,
                "uy" => $slip->uy,
                "status" => $slip->status,
                "endorsment" => $slip->endorsment,
                "selisih" => $slip->selisih,
                "cedbrok_id" => $slip->source,
                "cedbrok" => $slip->cedingbroker->name,
                "cedbrok_code" => $slip->cedingbroker->code,
                "cedbrok_cn" => $slip->cedingbroker->companytype->name,
                "ceding_id" => $slip->source_2,
                "ceding" => $slip->ceding->name,
                "ceding_cn" => $slip->ceding->companytype->name,
                "ceding_code" => $slip->ceding->code,
                "currency_id" => $slip->currency,
                "currency" => $slip->currencies->symbol_name,
                "currency_code" => $slip->currencies->code,
                "cob_id" => $slip->cob,
                "cob" => $slip->corebusiness->description,
                "cob_code" => $slip->corebusiness->code,
                "koc_id" => $slip->koc,
                "koc" => $slip->kindcontract->description,
                "koc_code" => $slip->kindcontract->code,
                "occupacy_id" => $slip->occupacy,
                "occupacy" => $slip->occupation->description,
                "occupacy_code" => $slip->occupation->code,
                "build_const" => $slip->build_const,
                "slip_no" => $slip->slip_no,
                "cn_dn" => $slip->cn_dn,
                "policy_no" => $slip->policy_no,
                "build_const" => $slip->build_const,
                "insured_type" => $slip->insured_type,
                "insured_pct" => $slip->insured_pct,
                "total_sum_insured" => $slip->total_sum_insured,
                "total_sum_pct" => $slip->total_sum_pct,
                "insurance_period_from" => $slip->insurance_period_from,
                "insurance_period_to" => $slip->insurance_period_to,
                "reinsurance_period_from" => $slip->reinsurance_period_from,
                "reinsurance_period_to" => $slip->reinsurance_period_to,
                "proportional" => $slip->proportional,
                "layer_non_proportional" => $slip->layer_non_proportional,
                "rate" => $slip->rate,
                "share" => $slip->share,
                "v_broker" => $slip->v_broker,
                "sum_share" => $slip->sum_share,
                "basic_premium" => $slip->basic_premium,
                "commission" => $slip->commission,
                "sum_commission" => $slip->sum_commission,
                "grossprm_to_nr" => $slip->grossprm_to_nr,
                "netprm_to_nr" => $slip->netprm_to_nr,
                "retro_backup" => $slip->retro_backup,
                "own_retention" => $slip->own_retention,
                "sum_own_retention" => $slip->sum_own_retention,
                "coinsurance_slip" => $slip->coinsurance_slip,
                "interestinsured" => $interestlist,
                // "interestinsured_interest" => $interestlist->interestinsureddata->description,
                // "interestinsured_interestid" => $interestlist->interest_id,
                "attachment" => $filelist,
                "deductible" => $deductibletemp,
                // "deductible_type" => $deductibletemp->DeductibleType->abbreviation,
                // "deductible_desc" => $deductibletemp->DeductibleType->description,
                // "deductible_typeid" => $deductibletemp->deductibletype_id,
                // "deductible_currency" => $deductibletemp->currency->symbol_name,
                // "deductible_currencyid" => $deductibletemp->currency_id,
                // "deductible_percentage" => $deductibletemp->percentage,
                // "deductible_min_claimamount" => $deductibletemp->min_claimamount,
                // "deductible_amount" => $deductibletemp->amount,
                "condition_needed" => $conditionneededtemp,
                // "condition_needed_cnid" => $conditionneededtemp->codition_id,
                // "condition_needed_cn" => $conditionneededtemp->conditionneeded->name,
                // "condition_needed_id" => $conditionneededtemp->information,
                "installment_panel" => $installmentpanel,
                // "installment_panel_percentage" => $installmentpanel->percentage,
                // "installment_panel_amount" => $installmentpanel->amount,
                "retrocession" => $retrocessiontemp,
                // "retrocession_type" => $retrocessiontemp->type,
                // "retrocession_contract" => $retrocessiontemp->contract,
                // "retrocession_percentage" => $retrocessiontemp->percentage,
                // "retrocession_amount" => $retrocessiontemp->amount,
                "status_log" => $statuslist
                // "status_status" => $statuslist->status,
                // "status_datetime" => $statuslist->datetime,
                // "status_user" => $statuslist->user
            ]);
        }
        else{
            return response()->json([
                "message" => "some data missing"
            ]);
        }
        
    }

    public function getdetailHioSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->where('slip_type','hio')->first();
    
       

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

    public function getdetailEndorsementHioSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->where('slip_type','hio')->first();

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

        $dateyeardata=  date("d/m/Y",strtotime($slipdata->prod_year));

    
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

    public function getdetailPaSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->where('slip_type','pa')->first();
    
       

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

    public function getdetailEndorsementPaSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('number',$idm)->where('slip_type','pa')->first();

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editmarineinsured($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Update Insured ';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        
        $insured = Insured::where('id',$id)->orderby('id','desc')->get();
        // dd($insured);
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::orderby('id','asc')->get();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $code_ms = $insured[0]->number;
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();


        return view('crm.transaction.marine_insured_edit', compact(['user','routeship','customer','shiplist','mlu','insured','route_active','ms_ids']));
    }

    public function editmarineslip($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        $slip = SlipTable::where('id',$id)->orderby('id','asc')->get();
        $sl_ids = response()->json($slip->modelKeys());
        // dd($slip[0]->insured_id);
        $insured = Insured::where('number',$slip[0]->insured_id)->orderby('id','desc')->get();
        
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
        $code_ms = $insured[0]->number;
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();

        $code_sl = $slip[0]->number;
        
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::orderby('id','asc')->get();
        $koc = Koc::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $interestinsured = InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();

        $sliplastid = count($slip);

        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

        return view('crm.transaction.marine_slip_edit', compact(['user','filelist','interestinsured','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestlist','cnd','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','route_active','code_sl','currdate','routeship','shiplist','mlu','insured','ms_ids']));
    }

    public function updatemarineinsured(request $request, $id)
    {

        $shiplist = ShiplistTemp::where('insured_id',$request->msinumber)->orderby('id','asc')->get();

        $validator = $request->validate([
            'msinumber'=>'required',
                'msiprefix'=>'required',
                'msisuggestinsured'=>'required'
        ]);

        
        
        if($validator){

            $isd = Insured::find($id);
            $isd->number = $request->msinumber;
            $isd->insured_prefix = $request->msiprefix;
            $isd->insured_name = $request->msisuggestinsured;
            $isd->insured_suffix = $request->msisuffix;
            $isd->route = $request->msiroute;
            $isd->route_from = $request->msiroutefrom;
            $isd->route_to = $request->msirouteto;
            $isd->share = $request->msishare;
            $isd->share_from = $request->msisharefrom;
            $isd->share_to = $request->msishareto;
            $isd->ship_detail = $shiplist->toJson();
            $isd->coincurance = $request->msicoinsurance;
            $isd->save();
            

            return response()->json($isd);
        }else{
            return response()->json($validator);
        }
    }
    
    public function updatemarineslip(request $request, $id)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
                'code_ms'=>'required',
                'slipuy'=>'required',
            'slippolicy_no'=>'required',
            'slipno'=>'required',
            'slipcndn'=>'required'
        ]);

            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $conditionneededlist= ConditionNeededTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             
            $slipfile=SlipTableFile::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $statlog=StatusLog::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ins)->orderby('id','desc')->first();
        
        if($validator){

            $var = $request->prod_year;
            $date = str_replace('/', '-', $var);
            $prod_year = date('Y-m-d', strtotime($date));

            $isd = SlipTable::find($id);
            $isd->number = $request->slipnumber;
            $isd->username = Auth::user()->name;
            $isd->insured_id = $request->code_ins;
            $isd->slip_type = 'ms';
            $isd->prod_year = $prod_year;
            $isd->uy = $request->slipuy;
            $isd->status = $request->slipstatus;
            $isd->source = $request->slipcedingbroker;
            $isd->source_2 = $request->slipceding;
            $isd->currency = $request->slipcurrency;
            $isd->cob = $request->slipcob;
            $isd->koc = $request->slipkoc;
            $isd->occupacy = $request->slipoccupacy;
            $isd->build_const = $request->slipbld_const;
            $isd->slip_no = $request->slipno;
            $isd->cn_dn = $request->slipcndn;
            $isd->policy_no = $request->slippolicy_no;
            $isd->attacment_file = $slipfile->toJson();
            $isd->interest_insured = $interestlist->toJSon();
            $isd->total_sum_insured = $request->sliptotalsum;
            $isd->insured_type = $request->sliptype;
            $isd->insured_pct = $request->slippct;
            $isd->total_sum_pct = $request->sliptotalsumpct;
            $isd->deductible_panel = $deductiblelist->toJson();
            $isd->extend_coverage = $conditionneededlist->toJson();
            $isd->insurance_period_from = $request->slipipfrom;
            $isd->insurance_period_to = $request->slipipto;
            $isd->reinsurance_period_from = $request->sliprpfrom;
            $isd->reinsurance_period_to = $request->sliprpto;
            $isd->proportional = $request->slipproportional;
            $isd->layer_non_proportional = $request->sliplayerproportional;
            $isd->rate = $request->sliprate;
            $isd->v_broker = $request->slipvbroker;
            $isd->share = $request->slipshare;
            $isd->sum_share = $request->slipsumshare;
            $isd->basic_premium = $request->slipbasicpremium;
            $isd->commission = $request->slipcommission;
            $isd->grossprm_to_nr = $request->slipgrossprmtonr;
            $isd->netprm_to_nr = $request->slipnetprmtonr;
            $isd->sum_commission = $request->slipsumcommission;
            $isd->installment_panel = $installmentlist->toJson();
            $isd->retrocession_panel = $retrocessionlist->toJson();
            $isd->retro_backup = $request->sliprb;
            $isd->own_retention = $request->slipor;
            $isd->sum_own_retention = $request->slipsumor;
            $isd->save();

            if($statlog->status != $request->slipstatus)
            {
                StatusLog::create([
                    'insured_id'=>$request->code_ins,
                    'status'=>$request->slipstatus,
                    'datetime'=>date('d/m/Y H:i:s'),
                    'slip_id'=>$request->slipnumber,
                    'user'=>Auth::user()->name,
                ]);
            }
            
            

            return response()->json($isd);
        }else{
            return response()->json($validator);
        }
    }

    public function updateshiplist(Request $request, $id)
   {
        $validator = $request->validate([
            'ship_code'=>'required',
                'ship_name'=>'required',
                'insuredID'=>'required'
        ]);
        
        if($validator){

            $slt = ShipListTemp::find($id);
            $slt->insured_id = $request->insuredID;
            $slt->ship_code = $request->ship_code;
            $slt->ship_name = $request->ship_name;
            $slt->save();
            // $notification = array(
            //     'message' => 'Ship List updated successfully!',
            //     'alert-type' => 'success'
            // );
            return response()->json($slt);
        }else{
            return response()->json($validator);
        }
   }

   public function updateinterestlist(Request $request, $id)
   {
        $validator = $request->validate([
            'interest_insured'=>'required',
                'interest_amount'=>'required',
                'slip_number'=>'required'
        ]);
        
        if($validator){

            $interestlist = InterestInsuredTemp::find($id);
            $interestlist->interest_id = $request->interest_insured;
            $interestlist->amount = $request->interest_amount;
            $interestlist->slip_id = $request->slip_number;
            $interestlist->save();
            
            $interestdata= InterestInsured::where('id','=',$request->interest_insured)->first();

                return response()->json(
                    [
                        'id' => $interestlist->id,
                        'interest_id' => $interestlist->interest_id,
                        'amount' => $interestlist->amount,
                        'slip_id' => $interestlist->slip_id,
                        'description' => $interestdata->description
                    ]
                );
        }else{
            return response()->json($validator);
        }
   }

   public function updateinstallmentlist(Request $request, $id)
   {
        $validator = $request->validate([
            'installment_date'=>'required',
                'percentage'=>'required',
                'slip_number'=>'required'
        ]);
        
        if($validator){

            $installmentlist = InstallmentTemp::find($id);
            $installmentlist->installment_date = $request->installment_date;
            $installmentlist->percentage = $request->percentage;
            $installmentlist->amount = $request->amount;
            $installmentlist->slip_id = $request->slip_number;
            $installmentlist->save();
              
            return response()->json(
                [
                    'id' => $installmentlist->id,
                    'percentage' => $installmentlist->percentage,
                    'installment_date' => $installmentlist->installment_date,
                    'amount' => $installmentlist->amount,
                    'slip_id' => $installmentlist->slip_id
                ]
            );

        }else{
            return response()->json($validator);
        }
   }

   public function updateextendcoveragelist(Request $request, $id)
   {
        $validator = $request->validate([
            'ship_code'=>'required',
                'ship_name'=>'required',
                'insuredID'=>'required'
        ]);
        
        if($validator){

            $slt = ShipListTemp::find($id);
            $slt->insured_id = $request->insuredID;
            $slt->ship_code = $request->ship_code;
            $slt->ship_name = $request->ship_name;
            $slt->save();
            // $notification = array(
            //     'message' => 'Ship List updated successfully!',
            //     'alert-type' => 'success'
            // );
            return response()->json($slt);
        }else{
            return response()->json($validator);
        }
   }

   public function updateconditionneededlist(Request $request, $id)
   {
        $validator = $request->validate([
            'condition_needed'=>'required',
                'slip_number'=>'required'
        ]);

        $cn = ConditionNeeded::where('id', $request->condition_needed)->first();
        $information = $cn->description;
        
        if($validator){

            $conditionneededlist = ConditionNeededTemp::find($id);
            $conditionneededlist->condition_id = $request->condition_needed;
            $conditionneededlist->information = $information;
            $conditionneededlist->slip_id = $request->slip_number;
            $conditionneededlist->save();
            
            return response()->json(
                [
                    'id' => $conditionneededlist->id,
                    'conditionneeded_id' => $conditionneededlist->condition_id,
                    'condition' => $conditionneededlist->conditionneeded->name,
                    'information' => $conditionneededlist->information,
                    'slip_id' => $conditionneededlist->slip_id
                ]
            );
        }else{
            return response()->json($validator);
        }
   }

   public function updatedeductiblelist(Request $request, $id)
   {
        $validator = $request->validate([
            'type'=>'required',
            'currency'=>'required',
            'slip_number'=>'required'
        ]);
        
        if($validator){

            $deductiblelist = DeductibleTemp::find($id);
            $deductiblelist->deductibletype_id = $request->type;
            $deductiblelist->currency_id = $request->currency;
            $deductiblelist->percentage = $request->percentage;
            $deductiblelist->amount = $request->amount;
            $deductiblelist->min_claimamount = $request->min_amount;
            $deductiblelist->slip_id = $request->slip_number;
            $deductiblelist->save();
            
            return response()->json(
                [
                    'id' => $deductiblelist->id,
                    'deductibletype_id' => $deductiblelist->deductibletype_id,
                    'dtdescript' => $deductiblelist->DeductibleType->description,
                    'dtabbrev' => $deductiblelist->DeductibleType->abbreviation,
                    'percentage' => $deductiblelist->percentage,
                    'currency_id' => $deductiblelist->currency_id,
                    'currencydata' => $deductiblelist->currency->code.'-'.$deductiblelist->currency->symbol_name,
                    'amount' => $deductiblelist->amount,
                    'min_claimamount' => $deductiblelist->min_claimamount,
                    'slip_id' => $deductiblelist->slip_id
                ]
            );

        }else{
            return response()->json($validator);
        }
   }


   public function updateretrocessionlist(Request $request, $id)
   {
        $validator = $request->validate([
            'type'=>'required',
                'contract'=>'required',
                'slip_number'=>'required'
        ]);
        
        if($validator){

            $retrocessionlist = RetrocessionTemp::find($id);
            $retrocessionlist->type = $request->type;
            $retrocessionlist->contract = $request->contract;
            $retrocessionlist->percentage = $request->percentage;
            $retrocessionlist->amount = $request->amount;
            $retrocessionlist->slip_id = $request->slip_number;
            $retrocessionlist->save();
            
            return response()->json(
                [
                    'id' => $retrocessionlist->id,
                    'percentage' => $retrocessionlist->percentage,
                    'contract' => $retrocessionlist->contract,
                    'type' => $retrocessionlist->type,
                    'amount' => $retrocessionlist->amount,
                    'slip_id' => $retrocessionlist->slip_id
                ]
            );

        }else{
            return response()->json($validator);
        }
   }

   public function updateholedetaillist(Request $request, $id)
   {
        $validator = $request->validate([
            'type'=>'required',
                'contract'=>'required',
                'slip_number'=>'required'
        ]);
        
        if($validator){

            $holedetaillist = HoleDetail::find($id);
            $holedetaillist->code = $request->code;
            $holedetaillist->golffieldhole_id = $request->golffieldhole_id;
            $holedetaillist->event = $request->event;
            $holedetaillist->insured_id = $request->insured_id;
            $holedetaillist->save();
            
            return response()->json(
                [
                    'code' => $holedetaillist->code,
                    'golffieldhole_id' => $holedetaillist->golffieldhole_id,
                    'event' => $holedetaillist->event,
                    'insured_id' => $holedetaillist->insured_id,
                ]
            );

        }else{
            return response()->json($validator);
        }
   }

   public function showslipmodalendorsement($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip and Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        $slip = SlipTable::where('id',$id)->orderby('id','asc')->first();
        // $sl_ids = response()->json($slip->modelKeys());
        $insured = Insured::where('number',$slip->insured_id)->orderby('id','desc')->first();
        // dd($insured);
        $route = $insured->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        // $ms_ids = response()->json($insured->modelKeys());
        // $lastid = count($insured);
        $code_ms = $insured->number;
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();

        $code_sl = $slip->number;
        
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('id',$id)->orderby('id','asc')->first();
        $koc = Koc::where('id',$id)->orderby('id','asc')->first();
        $ocp = Occupation::where('id',$id)->orderby('id','asc')->first();
        $cedingbroker = CedingBroker::where('id',$id)->orderby('id','asc')->first();
        $ceding = CedingBroker::where('id',$id)->orderby('id','asc')->where('type','4')->first();
        $felookup = FelookupLocation::where('id',$id)->orderby('id','asc')->get();
        $cnd = ConditionNeeded::where('id',$id)->orderby('id','asc')->get();

        // $sliplastid = count($slip);

        $countendorsement = $slip->slip_idendorsementcount;
    //    dd($countendorsement);
        if($countendorsement == null){
            $code_sl_new = $slip->number . '-END' . '000' . '1';
            $ed_count = 1;
            $selisih = "false";
        }
        else{
            if($countendorsement < 9)
            {
                $code_sl_new = substr($slip->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 8 && $countendorsement < 100)
            {
                $code_sl_new = substr($slip->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 99 && $countendorsement < 1000)
            {
                $code_sl_new = substr($slip->number,0,15) . '-END' . '0' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 999 && $countendorsement < 10000)
            {
                $code_sl_new = substr($slip->number,0,15) . '-END' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
        }
      
        $sl_number = substr($slip->number,0,15);

        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        // $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $interestlist = DB::table('interestinsured_temp')
            ->join('interest_insured', 'interest_insured.id', '=', 'interestinsured_temp.interest_id')
            ->select('interestinsured_temp.*', 'interest_insured.code', 'interest_insured.description')
            ->where('interestinsured_temp.slip_id',$code_sl)
            ->get();
        // $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $deductibletemp = DB::table('deductible_temp')
            ->join('deductible_type', 'deductible_type.id', '=', 'deductible_temp.deductibletype_id')
            ->join('currencies', 'currencies.id', '=', 'deductible_temp.currency_id')
            ->select('deductible_temp.*', 'currencies.code','currencies.symbol_name','deductible_type.abbreviation', 'deductible_type.description')
            ->where('deductible_temp.slip_id',$code_sl)
            ->get();
        // $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $conditionneededtemp = DB::table('condition_needed_temp')
        ->join('condition_needed', 'condition_needed.id', '=', 'condition_needed_temp.condition_id')
        ->select('condition_needed_temp.*', 'condition_needed.name','condition_needed.code' ,'condition_needed.description')
        ->where('condition_needed_temp.slip_id',$code_sl)
        ->get();
        $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

        return response()->json([
            "id" => $slip->id,
            "insured_id" => $slip->insured_id,
            "slip_new_number" => $code_sl_new,
            "slip_old_number" => $slip->number,
            "count_endorsement" => $ed_count,
            "username" => $slip->username,
            "prod_year" => $slip->prod_year,
            "uy" => $slip->uy,
            "status" => $slip->status,
            "endorsment" => $slip->endorsment,
            "selisih" => $slip->selisih,
            "cedbrok_id" => $slip->source,
            "cedbrok" => $slip->cedingbroker->name,
            "cedbrok_code" => $slip->cedingbroker->code,
            "cedbrok_cn" => $slip->cedingbroker->companytype->name,
            "ceding_id" => $slip->source_2,
            "ceding" => $slip->ceding->name,
            "ceding_cn" => $slip->ceding->companytype->name,
            "ceding_code" => $slip->ceding->code,
            "currency_id" => $slip->currency,
            "currency" => $slip->currencies->symbol_name,
            "currency_code" => $slip->currencies->code,
            "cob_id" => $slip->cob,
            "cob" => $slip->corebusiness->description,
            "cob_code" => $slip->corebusiness->code,
            "koc_id" => $slip->koc,
            "koc" => $slip->kindcontract->description,
            "koc_code" => $slip->kindcontract->code,
            "occupacy_id" => $slip->occupacy,
            "occupacy" => $slip->occupation->description,
            "occupacy_code" => $slip->occupation->code,
            "build_const" => $slip->build_const,
            "slip_no" => $slip->slip_no,
            "cn_dn" => $slip->cn_dn,
            "policy_no" => $slip->policy_no,
            "build_const" => $slip->build_const,
            "insured_type" => $slip->insured_type,
            "insured_pct" => $slip->insured_pct,
            "total_sum_insured" => $slip->total_sum_insured,
            "total_sum_pct" => $slip->total_sum_pct,
            "insurance_period_from" => $slip->insurance_period_from,
            "insurance_period_to" => $slip->insurance_period_to,
            "reinsurance_period_from" => $slip->reinsurance_period_from,
            "reinsurance_period_to" => $slip->reinsurance_period_to,
            "proportional" => $slip->proportional,
            "layer_non_proportional" => $slip->layer_non_proportional,
            "rate" => $slip->rate,
            "share" => $slip->share,
            "sum_share" => $slip->sum_share,
            "basic_premium" => $slip->basic_premium,
            "commission" => $slip->commission,
            "sum_commission" => $slip->sum_commission,
            "grossprm_to_nr" => $slip->grossprm_to_nr,
            "netprm_to_nr" => $slip->netprm_to_nr,
            "retro_backup" => $slip->retro_backup,
            "own_retention" => $slip->own_retention,
            "sum_own_retention" => $slip->sum_own_retention,
            "coinsurance_slip" => $slip->coinsurance_slip,
            "interestinsured" => $interestlist,
            // "interestinsured_interest" => $interestlist->interestinsureddata->description,
            // "interestinsured_interestid" => $interestlist->interest_id,
            "attachment" => $filelist,
            "deductible" => $deductibletemp,
            // "deductible_type" => $deductibletemp->DeductibleType->abbreviation,
            // "deductible_desc" => $deductibletemp->DeductibleType->description,
            // "deductible_typeid" => $deductibletemp->deductibletype_id,
            // "deductible_currency" => $deductibletemp->currency->symbol_name,
            // "deductible_currencyid" => $deductibletemp->currency_id,
            // "deductible_percentage" => $deductibletemp->percentage,
            // "deductible_min_claimamount" => $deductibletemp->min_claimamount,
            // "deductible_amount" => $deductibletemp->amount,
            "condition_needed" => $conditionneededtemp,
            // "condition_needed_cnid" => $conditionneededtemp->codition_id,
            // "condition_needed_cn" => $conditionneededtemp->conditionneeded->name,
            // "condition_needed_id" => $conditionneededtemp->information,
            "installment_panel" => $installmentpanel,
            // "installment_panel_percentage" => $installmentpanel->percentage,
            // "installment_panel_amount" => $installmentpanel->amount,
            "retrocession" => $retrocessiontemp,
            // "retrocession_type" => $retrocessiontemp->type,
            // "retrocession_contract" => $retrocessiontemp->contract,
            // "retrocession_percentage" => $retrocessiontemp->percentage,
            // "retrocession_amount" => $retrocessiontemp->amount,
            "status_log" => $statuslist
            // "status_status" => $statuslist->status,
            // "status_datetime" => $statuslist->datetime,
            // "status_user" => $statuslist->user
        ]);
    }

   public function indexmarineendorsement($id)
   {
       $user = Auth::user();
       $route_active = 'Marine - Endorsement Form';
       $mydate = date("Y").date("m").date("d");
       $currdate = date("Y-m-d");

       $slip = SlipTable::where('id',$id)->orderby('id','desc')->get();
       $sl_ids = response()->json($slip->modelKeys());
    //    dd($slip[0]->slip_idendorsementcount);
       $insured = Insured::where('number',$slip[0]->insured_id)->orderby('id','desc')->get();
       
       $route = $insured[0]->route;
       $mlu = MarineLookup::orderby('id','asc')->get();
       $customer= CustomerCustomer::orderby('id','asc')->get();
       $routeship= RouteShip::orderby('id','asc')->get();
       $ms_ids = response()->json($insured->modelKeys());
       $lastid = count($insured);
       $code_ms = $insured[0]->number;
       $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();

       $countendorsement = $slip[0]->slip_idendorsementcount;
    //    dd($countendorsement);
        if($countendorsement = null){
            $code_sl = $slip[0]->number . '-END' . '000' . '1';
            $ed_count = 1;
            $selisih = "false";
        }
        else{
            if($countendorsement < 10)
            {
                $code_sl = substr($slip[0]->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 9 && $countendorsement < 100)
            {
                $code_sl = substr($slip[0]->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 99 && $countendorsement < 1000)
            {
                $code_sl = substr($slip[0]->number,0,15) . '-END' . '0' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
            elseif($countendorsement > 999 && $countendorsement < 10000)
            {
                $code_sl = substr($slip[0]->number,0,15) . '-END' . ($countendorsement + 1);
                $ed_count = ($countendorsement + 1);
                $selisih = "true";
            }
        }
      
        $sl_number = substr($slip[0]->number,0,15);


       
       $currency = Currency::orderby('id','asc')->get();
       $cob = COB::orderby('id','asc')->get();
       $koc = Koc::orderby('id','asc')->get();
       $ocp = Occupation::orderby('id','asc')->get();
       $cedingbroker = CedingBroker::orderby('id','asc')->get();
       $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
       $felookup = FelookupLocation::orderby('id','asc')->get();
       $cnd = ConditionNeeded::orderby('id','asc')->get();
       $interestinsured = InterestInsured::orderby('id','asc')->get();
       $deductibletype= DeductibleType::orderby('id','asc')->get();

       $sliplastid = count($slip);

       $filelist=SlipTableFile::where('slip_id','=',$sl_number)->orderby('id','desc')->get();
       $interestlist= InterestInsuredTemp::where('slip_id',$sl_number)->orderby('id','desc')->get();
       $deductibletemp= DeductibleTemp::where('slip_id',$sl_number)->orderby('id','desc')->get();
       $conditionneededtemp= ConditionNeededTemp::where('slip_id',$sl_number)->orderby('id','desc')->get();
       $installmentpanel= InstallmentTemp::where('slip_id',$sl_number)->orderby('id','desc')->get();
       $retrocessiontemp= RetrocessionTemp::where('slip_id',$sl_number)->orderby('id','desc')->get();
       $statuslist= StatusLog::where('slip_id','=',$sl_number)->orderby('id','desc')->get();

       return view('crm.transaction.marine_endorsement', compact(['user','sl_number','filelist','selisih','ed_count','interestinsured','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestlist','cnd','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','route_active','code_sl','currdate','routeship','shiplist','mlu','insured','ms_ids']));
   }



   public function storemarineendorsement(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
            'slipuy'=>'required',
            'slippolicy_no'=>'required',
            'slipno'=>'required',
            'slipcndn'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
            
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $conditionneededlist= ConditionNeededTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             
            $slipfile=SlipTableFile::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             

            
                $currdate = date("Y-m-d");

                SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>$request->slip_username,
                    'insured_id'=>$request->code_ms,
                    'slip_type'=>'ms',
                    'prod_year' => $currdate,
                    'uy'=>$request->slipuy,
                    'status'=>$request->slipstatus,
                    'source'=>$request->slipcedingbroker,
                    'source_2'=>$request->slipceding,
                    'currency'=>$request->slipcurrency,
                    'cob'=>$request->slipcob,
                    'koc'=>$request->slipkoc,
                    'occupacy'=>$request->slipoccupacy,
                    'endorsment'=>'true',
                    'selisih'=>'false',
                    'build_const'=>$request->slipbld_const,
                    'slip_no'=>$request->slipno,
                    'cn_dn'=>$request->slipcndn,
                    'policy_no'=>$request->slippolicy_no,
                    'attacment_file'=>$slipfile->toJson(),
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'condition_needed'=>$conditionneededlist->toJson(),
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
                    'v_broker'=>$request->slipvbroker,
                    'commission'=>$request->slipcommission,
                    'grossprm_to_nr'=>$request->slipgrossprmtonr,
                    'netprm_to_nr'=>$request->slipnetprmtonr,
                    'sum_commission'=>$request->slipsumcommission,
                    'installment_panel'=>$installmentlist->toJson(),
                    'retrocession_panel'=>$retrocessionlist->toJson(),
                    'retro_backup'=>$request->sliprb,
                    'own_retention'=>$request->slipor,
                    'sum_own_retention'=>$request->slipsumor,
                    'slip_idendorsementcount' => ($request->countendorsement + 1),
                    'prev_endorsement' => $request->oldslipnumber
                    

                ]);

                $notification = array(
                    'message' => 'Marine Slip endorsement successfully!',
                    'alert-type' => 'success'
                );


            

            StatusLog::create([
                'insured_id'=>$request->code_ms,
                'status'=>$request->slipstatus,
                'datetime'=>date('Y-m-d H:i:s'),
                'slip_id'=>$request->slipnumber,
                'user'=>Auth::user()->name,
            ]);

            // $slipdata = SlipTable::where('number',$request->pre)->where('slip_type','ms')->first();

            $msdata = SlipTable::findOrFail($request->slip_id);
            $msdata->slip_idendorsementcount=($request->sliped - 1);
            $msdata->prev_endorsement='first slip';
            $msdata->total_sum_insured=($request->sliptotalsum * (-1));
            // $msdata->insured_pct=($request->slippct * (-1));
            $msdata->total_sum_pct=($request->sliptotalsumpct * (-1));
            // $msdata->rate=($request->sliprate * (-1));
            // $msdata->share=($request->slipshare * (-1));
            $msdata->sum_share=($request->slipsumshare * (-1));
            $msdata->basic_premium=($request->slipbasicpremium * (-1));
            $msdata->commission=($request->slipcommission * (-1));
            $msdata->grossprm_to_nr=($request->slipgrossprmtonr * (-1));
            $msdata->netprm_to_nr=($request->slipnetprmtonr * (-1));
            $msdata->sum_commission=($request->slipsumcommission * (-1)); 
            // $msdata->own_retention=($request->slipor * (-1)); 
            $msdata->sum_own_retention=($request->slipsumor * (-1));
            $msdata->endorsment="false"; 
            $msdata->selisih="true"; 
            $msdata->save();


            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Marine Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }



   public function destroymarineinsured($id)
    {
        $insured = Insured::find($id);
        if($insured->delete())
        {
            

            $notification = array(
                'message' => 'Marine Insured deleted successfully!',
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

    public function destroymarineslip($id)
    {
        $insured = SlipTable::find($id);
        if($insured->delete())
        {
            

            $notification = array(
                'message' => 'Marine Insured deleted successfully!',
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


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyshiplist($id)
    {
        $shiplist = ShipListTemp::find($id);
        $shiplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyinterestlist($id)
    {
        $interestlist = InterestInsuredTemp::find($id);
        
        $amountinterest = $interestlist->amount;
        
        $interestlist->delete();
        
        return response()->json(['success'=>'Data has been deleted','amount'=>$amountinterest]);
    }

    public function destroyinstallmentlist($id)
    {
        $installmentlist = InstallmentTemp::find($id);
        
        $installmentamount = $installmentlist->amount;
        
        $installmentlist->delete();
        
        return response()->json(['success'=>'Data has been deleted','amount'=>$installmentamount]);
    }


    public function destroyextendcoveragelist($id)
    {
        $extendcoveragelist = ExtendCoverageTemp::find($id);
        
        $extendcoveragelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyconditionneededlist($id)
    {
        $extendcoveragelist = ConditionNeededTemp::find($id);
        
        $extendcoveragelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }


    public function destroydeductiblelist($id)
    {
        $deductiblelist = DeductibleTemp::find($id);
        
        $deductiblelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyretrocessionlist($id)
    {
        $retrocessionTemplist = RetrocessionTemp::find($id);
        
        $retrocessionTemplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }
    

    public function destroypropertytypelist($id)
    {
        $propertytypeTemplist = PropertyTypeTemp::find($id);
        
        $propertytypeTemplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyholedetaillist($id)
    {
        $holedetaillist = HoleDetail::find($id);
        
        $holedetaillist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }
    

}
