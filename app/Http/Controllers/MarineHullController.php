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
use Illuminate\Support\Facades\Auth;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\RetrocessionTemp;
use App\Models\PropertyType;
use App\Models\PropertyTypeTemp;
use App\Models\TransPropertyTemp;
use App\Models\HoleDetail;
use App\Models\GolfFieldHole;
use Illuminate\Http\Request;

class MarineHullController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $route_active = 'Marine Hull - Slip Entry';
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
            $cedinginsured = CedingBroker::orderby('id','asc')->where('type','4')->get();
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


            return view('crm.transaction.marine_hull_slip', compact(['user','kocmodal','ocpmodal','cedinginsured','cedbrokmodal','cedingmodal','currencymodal','cobmodal','slipdata2','edslipid','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestinsured','routeship','customer','interestlist','shiplist','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         }
        else
        {
          $insured = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($insured->modelKeys());
          return view('crm.transaction.marine_hull_slip', compact('user','customer','slip','insured','cedinginsured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function storeinsured(Request $request){
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

    public function storeslip(Request $request){

    }

    public function updateinsured(request $request, $id){

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

    public function updateslip(request $request, $id){
    	
    }

    public function destroyinsured($id)
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

    public function destroyslip($id)
    {
    	
    }


}
