<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Models\TransLocation;
use App\Models\Currency;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\User;
use App\Models\Insured;
use App\Models\CedingBroker;
use App\Models\TransLocationTemp;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\NatureOfLoss;
use App\Models\MasterCauseOfLoss;
use App\Models\Surveyor;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\PrefixInsured;
use App\Models\MainClaimEntryFAC;
use App\Models\InterestInsuredTemp;
use Illuminate\Support\Facades\Auth;


class Claim_controller extends Controller
{
    public function index()
    {
    	$route_active = 'CLAIM INSURED - Entry';

        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','fe')->orderby('id','asc')->get();
        $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $surveyor = Surveyor::orderby('id','asc')->get();
        $natureofloss = NatureOfLoss::orderby('id','asc')->get();
        $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();
        $prefixinsured = PrefixInsured::orderby('id','asc')->get();
       
    	return view('crm.transaction.claim.index',compact('prefixinsured','causeofloss','natureofloss','surveyor','ceding','cedingbroker','currency','cob','koc','ocp','route_active'));
    }


    public function indexclaim(Request $request)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'CLAIM INSURED - Index';   

        $mydate = date("Y").date("m").date("d");
        $fe_ids = response()->json($country->modelKeys());
        $search = @$request->input('search');
        $searchinsured = @$request->input('searchinsured');
        $searchuy = @$request->input('searchuy');
        $searchshare = @$request->input('searchshare');
        $searchnre = @$request->input('searchnre');
        $searchtsi = @$request->input('searchtsi');
        $searchendorse = @$request->input('searchendorse');
        $searchslipnum = @$request->input('searchslipnum');
        $searchcob = @$request->input('searchcob');
        $searchceding = @$request->input('searchceding');

        $costumer=Customer::orderby('id','asc')->get();
        
    
       if(!empty($search) || !empty($searchinsured) || !empty($searchuy) || !empty($searchshare) || !empty($searchnre) || !empty($searchtsi) || !empty($searchendorse))
       {

           $query = Insured::query();

           if (!empty($search)) {
               $query = $query->where('number', $search);
           }

           if (!empty($searchinsured)) {
               $query = $query->where('insured_name', $searchinsured);
           }

           if (!empty($searchuy)) {
               $query = $query->where('uy', $searchuy);
           }

           if (!empty($searchshare)) {
               $query = $query->where('share', $searchshare);
           }

           if (!empty($searchnre)) {
               $query = $query->where('share_from', $searchnre);
           }

           if (!empty($searchtsi)) {
               $query = $query->where('share_to', $searchtsi);
           }

           if (!empty($searchendorse)) {
               $query = $query->where('count_endorsement', $searchendorse);
           }

           // Ordering
           $query = $query->where('slip_type', '=', 'fe')->orderBy('id', 'DESC');
           
           $insured =$query->paginate(50);
           $insured_ids = response()->json($insured->modelKeys());
   

           $cob = COB::orderby('id','asc')->get();
           $cedingbroker = CedingBroker::orderby('id','asc')->get();
           $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();
           $currency = Currency::orderby('id','asc')->get();
           $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
           $ocp = Occupation::orderby('id','asc')->get();
          
           $surveyor = Surveyor::orderby('id','asc')->get();
           $natureofloss = NatureOfLoss::orderby('id','asc')->get();
           $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();

           $claimlist= MainClaimEntryFAC::where('is_delete',0)->orderby('id','desc')->get();
           $claimlist_ids = response()->json($claimlist->modelKeys());

           return view('crm.transaction.claim.claim_index', compact('claimlist_ids','claimlist','costumer','causeofloss','natureofloss','surveyor','ocp','koc','currency','searchslipnum','searchcob','searchceding','search','searchinsured','searchuy','searchshare','searchnre','searchtsi','searchendorse','cob','cedingbroker','ceding','user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
           
        }
        else
        {
           //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
           
           //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
           $insured = Insured::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
           $insured_ids = response()->json($insured->modelKeys());
           

           $cob = COB::orderby('id','asc')->get();
           $cedingbroker = CedingBroker::orderby('id','asc')->get();
           $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();
           $currency = Currency::orderby('id','asc')->get();
           $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
           $ocp = Occupation::orderby('id','asc')->get();

           $surveyor = Surveyor::orderby('id','asc')->get();
           $natureofloss = NatureOfLoss::orderby('id','asc')->get();
           $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();

           $claimlist= MainClaimEntryFAC::where('is_delete',0)->orderby('id','desc')->get();
           $claimlist_ids = response()->json($claimlist->modelKeys());

           return view('crm.transaction.claim.claim_index', compact('claimlist_ids','claimlist','costumer','causeofloss','natureofloss','surveyor','ocp','koc','currency','searchslipnum','searchcob','searchceding','search','searchinsured','searchuy','searchshare','searchnre','searchtsi','searchendorse','cob','cedingbroker','ceding','user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
           
       }

    }

    
    public function storeclaiminsured(Request $request)
    {
        
        $validator = $request->validate([
            'number'=>'required',
            'regcomp'=>'required',
            'dateofreceipt'=>'required',
            'dateofdocument'=>'required',
            'causeofloss'=>'required',
            'desccauseofloss'=>'required',
            'natureofloss'=>'required',
            'descnatureofloss'=>'required',
        ]);
        
        if($validator)
        {
            //dd($request);
            //exit();
            
            $user = Auth::user();
            MainClaimEntryFAC::create([
                'number'=>$request->number,
                'reg_comp'=> $request->regcomp,
                'date_receipt'=> date("Y-m-d", strtotime($request->dateofreceipt)),
                'date_document'=> date("Y-m-d", strtotime($request->dateofdocument)),
                'causeofloss_id'=> $request->causeofloss,
                'desc_causeofloss'=> $request->desccauseofloss,
                'natureofloss_id'=> $request->natureofloss,
                'descnatureofloss'=> $request->descnatureofloss,
                'date_of_loss'=> date("Y-m-d", strtotime($request->dateofloss)),
                'curr_id_loss'=>$request->currofloss,
                'curr_lossdesc'=>$request->desccurrofloss,
                'surveyor_id'=>$request->surveyoradjuster,
                'desc_surveyor'=>$request->descsurveyoradjuster,
                'nasre_liab'=>$request->nationalresliab,
                'nasre_liabdesc'=>$request->descnationalresliab,
                'nasre_share_loss'=>$request->shareonloss,
                'ced_share'=>$request->cedantshare,
                'total_loss_amount'=>$request->totallossamount,
                'potential_recovery'=>$request->potentialrecoverydecision,
                'estimate_amount_subro'=>$request->subrogasi,
                'desc_poten_rec'=>$request->potentialrecovery,
                'kronologi'=>$request->kronologi,
                'staff_recomendation'=>$request->staffrecomend,
                'ass_man_recomen'=>$request->assistantmanagerrecomend,
                'pureor_liability'=>$request->pureorliability,
                'pureor_loss'=>$request->pureorloss,
                'pureor_retro'=>$request->pureorcontract,
                'pureor_recovery'=>$request->pureorrecovery,
                'qs_liability'=>$request->qsliability,
                'qs_loss'=>$request->qsloss,
                'qs_retro'=>$request->qscontract,
                'qs_recovery'=>$request->qsrecovery,
                'arr1_liability'=>$request->arr1liability,
                'arr1_loss'=>$request->arr1loss,
                'arr1_retro'=>$request->arr1contract,
                'arr1_recovery'=>$request->arr1recovery,
                'extra_liability'=>$request->extraliability,
                'extra_loss'=>$request->extraloss,
                'extra_retro'=>$request->extracontract,
                'extra_recovery'=>$request->extrarecovery,
                'facultative_liability'=>$request->facultativeliability,
                'facultative_loss'=>$request->facultativeloss,
                'facultative_retro'=>$request->facultativecontract,
                'facultative_recovery'=>$request->facultativerecovery,
                'arr2_liability'=>$request->arr2liability,
                'arr2_loss'=>$request->arr2loss,
                'arr2_retro'=>$request->arr2contract,
                'arr2_recovery'=>$request->arr2recovery,
                'arr3_liability'=>$request->arr3liability,
                'arr3_loss'=>$request->arr3loss,
                'arr3_retro'=>$request->arr3contract,
                'arr3_recovery'=>$request->arr3recovery,
                'totalrecovery'=>$request->totalrecovery,
                'nrsgrossret'=>$request->nrsgrossret,
                'xol'=>$request->xol,
                'cereffno'=>$request->cereffno,
                'dateofprod'=>date("Y-m-d", strtotime($request->dateofprod)),
                'ceno'=>$request->ceno,
                'ceuser'=>$request->ceuser,
                'description'=>$request->description,
                'dateofentry'=>date("Y-m-d", strtotime($request->dateentry)),
                'dateoftrans'=>date("Y-m-d", strtotime($request->datetrans)),
                'dateofsupporting'=>date("Y-m-d", strtotime($request->datesupporting))

            ]);

            $notification = array(
                'message' => 'Main Claim added successfully!',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }


    public function getdetailSlipClaim($number)
    {
        $user = Auth::user();
        $slipdata=MainClaimEntryFAC::where('number',$number)->orderby('id','DESC')->first();
    

        $datereceipt=  date("d/m/Y", strtotime($slipdata->date_receipt));

        if($slipdata->date_document == null)
        {
            $datedocument = "";
        }
        else
        {
            $datedocument = date("d/m/Y", strtotime($slipdata->date_document));
        }
           
        $statustable= StatusLog::where('slip_id',$slipdata->number)->where('insured_id',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->where('slip_type','fe')->orderby('created_at','DESC')->get();
        $statuslist= $statustable->unique('status');
        $statuslist->values()->all();
       
        $attachmenttable = collect(SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','fe')->where('count_endorsement',$slipdata->endorsment)->orderby('id','DESC')->get());
        $attachmentlist = $attachmenttable->unique('filename');
        $attachmentlist->values()->all();
                
        return response()->json(
            [
                'id' => $slipdata->id,
                'insured_id' => $slipdata->insured_id,
                'slip_type' => $slipdata->slip_type,
                'username' => $slipdata->username,
                'prod_year' => $dateyeardata,
                'number' => $slipdata->number,
                'slipuy' => $slipdata->uy,
                'date_transfer' => $datetransfer,
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
                'build_rate_up'=> $building_rate_up,
                'build_rate_down'=> $building_rate_down,
                'slip_no'=> $slipdata->slip_no,
                'cn_dn'=> $slipdata->cn_dn,
                'policy_no'=> $slipdata->policy_no,
                'attacment_file'=> $attachmentlist,
                'type_tsi'=> $slipdata->type_tsi,
                'total_sum_insured'=> $slipdata->total_sum_insured,
                'type_share_tsi'=> $slipdata->type_share_tsi,
                'share_tsi'=> $slipdata->share_tsi,
                'insured_type'=>$slipdata->insured_type,
                'insured_pct'=>$slipdata->insured_pct,
                'total_sum_pct'=>$slipdata->total_sum_pct,
                'deductible_panel'=>$newdeductdata,
                'extend_coverage'=>$newextenddata,
                'insurance_period_from'=>date("d/m/Y", strtotime($slipdata->insurance_period_from)),
                'insurance_period_to'=>date("d/m/Y", strtotime($slipdata->insurance_period_to)),
                'reinsurance_period_from'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_from)),
                'reinsurance_period_to'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_to)),
                'proportional'=>$slipdata->proportional,
                'layer_non_proportional'=>$slipdata->layer_non_proportional,
                'rate'=>$slipdata->rate,
                'sum_rate'=>$slipdata->sliptotalrate,
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
                'endorsment'=>$slipdata->endorsment,
                'prev_endorsement'=>$slipdata->prev_endorsement,
                'condition_needed'=>$slipdata->condition_needed,
                'created_at'=>$slipdata->created_at,
                'updated_at'=>$slipdata->updated_at,
                'wpc'=>$slipdata->wpc,
                'remarks'=>$slipdata->remarks,
                'v_broker'=>$slipdata->v_broker,
                'sum_v_broker'=>$slipdata->sum_feebroker,
                'total_day'=>$slipdata->total_day,
                'total_year'=>$slipdata->total_year,
                'sum_total_date'=>$slipdata->sum_total_date,
                'coinsurance_slip'=>$slipdata->coinsurance_slip,
                'status_log'=>$statuslist,
                'sum_feebroker'=>$slipdata->sum_feebroker,
                'sum_ec'=>$sum_permilec,
                'sum_ippercent' =>$sum_inspanpercent
            ]
        );

    }


    public function destroy($id)
    {
        $claim = MainClaimEntryFAC::find($id);
        $claim->is_delete = 1;         
           
        if($claim->save())
        {
            $notification = array(
                'message' => 'Claim Data deleted successfully!',
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

