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
use App\Models\SlipTable;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\NatureOfLoss;
use App\Models\MasterCauseOfLoss;
use App\Models\Surveyor;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\PrefixInsured;
use App\Models\MainClaimEntryFAC;
use App\Models\TransAmountClaimTemp;
use App\Models\RiskLocationDetail;
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


    public function destroyamountmanuallist($id)
    {
        $claimTemplist = TransAmountClaimTemp::find($id);
        
        $claimTemplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }


    public function storemanualamountlist(Request $request)
    {
        
            $amountmanual = $request->amountmanual;
            $slipnumber = $request->slipnumber;
            $description = $request->description;
        
            if($slipnumber !='' && $amountmanual != '')
            {
            
                $retrocessionlist = new TransAmountClaimTemp();
                $retrocessionlist->descripiton  = $description;
                $retrocessionlist->amount = $amountmanual; 
                $retrocessionlist->slip_number = $slipnumber; 
                //$retrocessionlist->slip_id = $slip_number; 
                //$retrocessionlist->insured_id = $slip_number; 
                $retrocessionlist->save();


                return response()->json(
                    [
                        'id' => $retrocessionlist->id,
                        'descripiton' => $retrocessionlist->descripiton,
                        'amount' => $retrocessionlist->amount,
                        'slip_number' => $retrocessionlist->slip_number
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields & Fill SLip Number First'
                    ]
                );

            }
        
    }


    public function storelocationamountlist(Request $request)
    {
        
            $descripitonriskselect = $request->descripitonriskselect;
            $slipnumber = $request->slipnumber;
            $amounttablerisk = $request->amounttablerisk;

            if($slipnumber !='' && $descripitonriskselect!='')
            {
            
                $risklocationdetaildata= RiskLocationDetail::where('id','=',$descripitonriskselect)->first();
                
                $retrocessionlist = new TransAmountClaimTemp();
                
                $interestdata=InterestInsured::where('id','=',$risklocationdetaildata->interest_id)->first();
                $cedingdata=CedingBroker::where('id','=',$risklocationdetaildata->ceding_id)->first();
            
                $retrocessionlist->descripiton  = $interestdata->description." ".$cedingdata->name;

                if(!empty($amounttablerisk))
                {
                    $retrocessionlist->amount = $amounttablerisk; 
                }
                else
                {
                    $retrocessionlist->amount = $risklocationdetaildata->amountlocation; 
                }
                
                
                $retrocessionlist->slip_number = $slipnumber; 
                $retrocessionlist->risk_location_id = $descripitonriskselect; 
                //$retrocessionlist->slip_id = $slip_number; 
                //$retrocessionlist->insured_id = $slip_number; 
                $retrocessionlist->save();


                return response()->json(
                    [
                        'id' => $retrocessionlist->id,
                        'descripiton' => $retrocessionlist->descripiton,
                        'amount' => $retrocessionlist->amount,
                        'slip_number' => $retrocessionlist->slip_number
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields & Fill SLip Number First'
                    ]
                );

            }
        
    }


    public function updateindex($idclaim)
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
        $claimdata=MainClaimEntryFAC::where('id',$idclaim)->orderby('id','DESC')->first();
    
       
    	return view('crm.transaction.claim.updateindex',compact('idclaim','claimdata','prefixinsured','causeofloss','natureofloss','surveyor','ceding','cedingbroker','currency','cob','koc','ocp','route_active'));
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

            $claimdata=MainClaimEntryFAC::where('number',$request->number)->orderby('id','DESC')->first();
    
            if(!empty($claimdata))
            {
                $claimdata->number=$request->number;
                $claimdata->reg_comp=$request->regcomp;
                $claimdata->doc_number=$request->docnumber;
                $claimdata->date_receipt=date("Y-m-d", strtotime($request->dateofreceipt));
                $claimdata->date_document=date("Y-m-d", strtotime($request->dateofdocument));
                $claimdata->causeofloss_id=$request->causeofloss;
                $claimdata->desc_causeofloss=$request->desccauseofloss;
                $claimdata->natureofloss_id=$request->natureofloss;
                $claimdata->descnatureofloss=$request->descnatureofloss;
                $claimdata->date_of_loss=date("Y-m-d", strtotime($request->dateofloss));
                $claimdata->curr_id_loss=$request->currofloss;
                $claimdata->curr_lossdesc=$request->desccurrofloss;
                $claimdata->surveyor_id=$request->surveyoradjuster;
                $claimdata->desc_surveyor=$request->descsurveyoradjuster;
                $claimdata->nasre_liab=$request->nationalresliab;
                $claimdata->nasre_liabdesc=$request->descnationalresliab;
                $claimdata->nasre_share_loss=$request->shareonloss;
                $claimdata->ced_share=$request->cedantshare;
                $claimdata->total_loss_amount=$request->totallossamount;
                $claimdata->potential_recovery=$request->potentialrecoverydecision;
                $claimdata->estimate_amount_subro=$request->subrogasi;
                $claimdata->desc_poten_rec=$request->potentialrecovery;
                $claimdata->kronologi=$request->kronologi;
                $claimdata->staff_recomendation=$request->staffrecomend;
                $claimdata->ass_man_recomen=$request->assistantmanagerrecomend;
                $claimdata->pureor_liability=$request->pureorliability;
                $claimdata->pureor_loss=$request->pureorloss;
                $claimdata->pureor_retro=$request->pureorcontract;
                $claimdata->pureor_recovery=$request->pureorrecovery;
                $claimdata->qs_liability=$request->qsliability;
                $claimdata->qs_loss=$request->qsloss;
                $claimdata->qs_retro=$request->qscontract;
                $claimdata->qs_recovery=$request->qsrecovery;
                $claimdata->arr1_liability=$request->arr1liability;
                $claimdata->arr1_loss=$request->arr1loss;
                $claimdata->arr1_retro=$request->arr1contract;
                $claimdata->arr1_recovery=$request->arr1recovery;
                $claimdata->extra_liability=$request->extraliability;
                $claimdata->extra_loss=$request->extraloss;
                $claimdata->extra_retro=$request->extracontract;
                $claimdata->extra_recovery=$request->extrarecovery;
                $claimdata->facultative_liability=$request->facultativeliability;
                $claimdata->facultative_loss=$request->facultativeloss;
                $claimdata->facultative_retro=$request->facultativecontract;
                $claimdata->facultative_recovery=$request->facultativerecovery;
                $claimdata->arr2_liability=$request->arr2liability;
                $claimdata->arr2_loss=$request->arr2loss;
                $claimdata->arr2_retro=$request->arr2contract;
                $claimdata->arr2_recovery=$request->arr2recovery;
                $claimdata->arr3_liability=$request->arr3liability;
                $claimdata->arr3_loss=$request->arr3loss;
                $claimdata->arr3_retro=$request->arr3contract;
                $claimdata->arr3_recovery=$request->arr3recovery;
                $claimdata->totalrecovery=$request->totalrecovery;
                $claimdata->nrsgrossret=$request->nrsgrossret;
                $claimdata->xol=$request->xol;
                $claimdata->cereffno=$request->cereffno;
                $claimdata->dateofprod=date("Y-m-d", strtotime($request->dateofprod));
                $claimdata->ceno=$request->ceno;
                $claimdata->ceuser=$request->ceuser;
                $claimdata->description=$request->description;
                $claimdata->dateofentry=date("Y-m-d", strtotime($request->dateentry));
                $claimdata->dateoftrans=date("Y-m-d", strtotime($request->datetrans));
                $claimdata->dateofsupporting=date("Y-m-d", strtotime($request->datesupporting));
                $claimdata->save();

                $notification = array(
                    'message' => 'Main Claim Update successfully!',
                    'alert-type' => 'success'
                );

                return back()->with($notification);
            }
            else
            {
                    $user = Auth::user();
                    MainClaimEntryFAC::create([
                        'number'=>$request->number,
                        'reg_comp'=> $request->regcomp,
                        'doc_number'=> $request->docnumber,
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
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }


    public function getdetailAmountSlip($number)
    {
        $user = Auth::user();
        $claimamountdata=TransAmountClaimTemp::where('slip_number',$number)->orderby('id','DESC')->get();

        if(!empty($claimamountdata))
        {
                return response()->json(
                [
                   'status' =>200,
                   'message'=>"Amount Data",
                   'data'=>$claimamountdata->toJSon()
                ]
               );
        }
        else
        {
                 return response()->json(
                 [
                    'status' =>201,
                    'message'=>"Slip Number, No Amount Data"
                 ]
                );
        }
    }


    public function getRiskLocationSlip($number)
    {
        $user = Auth::user();
        
        $slipdata=SlipTable::where('number',$number)->first();
        
        $locationlist2= TransLocationTemp::where('insured_id','=',$slipdata->insured_id)->orderby('id','desc')->get();
         
        //dd($locationlist2);
        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                //$risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->where('count_endorsement',$insureddata->count_endorsement)->get();
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

        if(!empty($locationlist2))
        {
                return response()->json(
                [
                   'status' =>200,
                   'message'=>"Location Data",
                   'data'=>json_encode($locationlist)
                ]
               );
        }
        else
        {
                 return response()->json(
                 [
                    'status' =>201,
                    'message'=>"No Location Data"
                 ]
                );
        }

    }



    public function getdetailSlipClaim($number)
    {
        $user = Auth::user();
        $claimdata=MainClaimEntryFAC::where('number',$number)->orderby('id','DESC')->first();
    
        if(!empty($claimdata))
        {
                $datereceipt=  date("d/m/Y", strtotime($claimdata->date_receipt));

                if($claimdata->date_document == null)
                {
                    $datedocument = "";
                }
                else
                {
                    $datedocument = date("d/m/Y", strtotime($claimdata->date_document));
                }
                
            // $statustable= StatusLog::where('slip_id',$slipdata->number)->where('insured_id',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->where('slip_type','fe')->orderby('created_at','DESC')->get();
            // $statuslist= $statustable->unique('status');
            // $statuslist->values()->all();
            
            // $attachmenttable = collect(SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','fe')->where('count_endorsement',$slipdata->endorsment)->orderby('id','DESC')->get());
            // $attachmentlist = $attachmenttable->unique('filename');
            // $attachmentlist->values()->all();
                        
                return response()->json(
                    [
                        'id' => $claimdata->id,
                        'number' => $claimdata->number,
                        'doc_number' => $claimdata->doc_number,
                        'reg_comp' => $claimdata->reg_comp,
                        'date_receipt'=>date("d/m/Y", strtotime($claimdata->date_receipt)),
                        'date_document'=>date("d/m/Y", strtotime($claimdata->date_document)),
                        'causeofloss_id' =>$claimdata->causeofloss_id,
                        'desc_causeofloss' =>$claimdata->desc_causeofloss,
                        'natureofloss_id' =>$claimdata->natureofloss_id,
                        'descnatureofloss' =>$claimdata->descnatureofloss,
                        'id_col' =>$claimdata->id_col,
                        'id_nol' =>$claimdata->id_nol,
                        'date_of_loss'=>date("d/m/Y", strtotime($claimdata->date_of_loss)),
                        'curr_id_loss' =>$claimdata->curr_id_loss,
                        'curr_lossdesc' =>$claimdata->curr_lossdesc,
                        'surveyor_id' =>$claimdata->surveyor_id,
                        'desc_surveyor' =>$claimdata->desc_surveyor,
                        'nasre_liab' =>$claimdata->nasre_liab,
                        'nasre_liabdesc' =>$claimdata->nasre_liabdesc,
                        'nasre_share_loss' =>$claimdata->nasre_share_loss,
                        'ced_share' =>$claimdata->ced_share,
                        'total_loss_amount' =>$claimdata->total_loss_amount,
                        'potential_recovery' =>$claimdata->potential_recovery,
                        'route' =>$claimdata->route,
                        'estimate_amount_subro' =>$claimdata->estimate_amount_subro,
                        'desc_poten_rec' =>$claimdata->desc_poten_rec,
                        'kronologi' =>$claimdata->kronologi,
                        'staff_recomendation' =>$claimdata->staff_recomendation,
                        'ass_man_recomen' =>$claimdata->ass_man_recomen,
                        'route_from' =>$claimdata->route_from,
                        'route_to' =>$claimdata->route_to,
                        'pureor_liability' =>$claimdata->pureor_liability,
                        'pureor_loss' =>$claimdata->pureor_loss,
                        'pureor_retro' =>$claimdata->pureor_retro,
                        'pureor_recovery' =>$claimdata->pureor_recovery,
                        'qs_liability' =>$claimdata->qs_liability,
                        'qs_loss' =>$claimdata->qs_loss,
                        'qs_retro' =>$claimdata->qs_retro,
                        'qs_recovery' =>$claimdata->qs_recovery,
                        'arr1_liability' =>$claimdata->arr1_liability,
                        'arr1_loss' =>$claimdata->arr1_loss,
                        'arr1_retro' =>$claimdata->arr1_retro,
                        'arr1_recovery' =>$claimdata->arr1_recovery,
                        'extra_liability' =>$claimdata->extra_liability,
                        'extra_loss' =>$claimdata->extra_loss,
                        'extra_retro' =>$claimdata->extra_retro,
                        'extra_recovery' =>$claimdata->extra_recovery,
                        'facultative_liability' =>$claimdata->facultative_liability,
                        'facultative_loss' =>$claimdata->facultative_loss,
                        'facultative_retro' =>$claimdata->facultative_retro,
                        'facultative_recovery' =>$claimdata->facultative_recovery,
                        'arr2_liability' =>$claimdata->arr2_liability,
                        'arr2_loss' =>$claimdata->arr2_loss,
                        'arr2_retro' =>$claimdata->arr2_retro,
                        'arr2_recovery' =>$claimdata->arr2_recovery,
                        'arr3_liability' =>$claimdata->arr3_liability,
                        'arr3_loss' =>$claimdata->arr3_loss,
                        'arr3_retro' =>$claimdata->arr3_retro,
                        'arr3_recovery' =>$claimdata->arr3_recovery,
                        'totalrecovery' =>$claimdata->totalrecovery,
                        'nrsgrossret' =>$claimdata->nrsgrossret,
                        'xol' =>$claimdata->xol,
                        'cereffno' =>$claimdata->cereffno,
                        'dateofprod' =>date("d/m/Y", strtotime($claimdata->dateofprod)),
                        'ceno' =>$claimdata->ceno,
                        'ceuser' =>$claimdata->ceuser,
                        'description' =>$claimdata->description,
                        'dateofentry' =>date("d/m/Y", strtotime($claimdata->dateofentry)),
                        'dateoftrans' =>date("d/m/Y", strtotime($claimdata->dateoftrans)),
                        'dateofsupporting' =>date("d/m/Y", strtotime($claimdata->dateofsupporting)),
                        'status_flag' =>$claimdata->status_flag,
                        'is_delete' =>$claimdata->is_delete,
                        'attacment_file' =>$claimdata->attacment_file,
                        'status' =>200,
                        'message'=>"Data Claim"
                        
                    ]
                );
        }
        else
        {
                return response()->json(
                [
                    'status' =>201,
                    'message'=>"Slip Number, No Claim Data"
                ]
                );
        }

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

