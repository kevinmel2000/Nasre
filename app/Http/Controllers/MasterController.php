<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\COB;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Occupation;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexcountry()
    {
        $route_active = 'country_master';
        $user = Auth::user();
        $country = Country::orderby('id','asc')->get();
        $country_ids = response()->json($country->modelKeys());

        // dd($country);
        return view('crm.master.country', compact(['route_active', 'country','country_ids']));        

    }

    public function indexcob()
    {
        $route_active = 'cob_master';
        $user = Auth::user();
        $cob = COB::orderby('id','asc')->get();
        $cob_ids = response()->json($cob->modelKeys());

        // dd($country);
        return view('crm.master.cob', compact(['route_active', 'cob','cob_ids']));        

    }

    public function indexoccupation()
    {
        $route_active = 'ocp_master';
        $user = Auth::user();
        $occupation = Occupation::orderby('id','asc')->get();
        $lastid = Occupation::select('id')->latest()->first();
        $ocp_ids = response()->json($occupation->modelKeys());
        $cob = COB::orderby('id','asc')->get();
        if($lastid != null){
            if($lastid->id == 9){
                $code_ocp = "OCP00" . strval($lastid->id + 1);
            }elseif($lastid->id >= 10){
                $code_ocp = "OCP00" . strval($lastid->id + 1);
            }elseif($lastid->id >= 100){
                $code_ocp = "OCP0" . strval($lastid->id + 1);
            }elseif($lastid->id >= 1000){
                $code_ocp = "OCP" . strval($lastid->id + 1);
            }else{
                $code_ocp = "OCP000" . strval($lastid->id + 1);
            }
        }
        else{
            $code_ocp = "OCP000" . strval($lastid->id + 1);
        }

        


        // dd($lastid);
        return view('crm.master.occupation', compact(['route_active', 'occupation','cob','ocp_ids','code_ocp']));        

    }

    public function indexcurrency()
    {
        $route_active = 'currency_master';
        $user = Auth::user();
        $currency = Currency::orderby('id','asc')->get();
        $crc_ids = response()->json($currency->modelKeys());
        $country = Country::orderby('id','asc')->get();



        // dd($country);
        return view('crm.master.currency', compact(['route_active', 'currency','crc_ids','country']));        

    }

    public function indexexchange()
    {
        $route_active = 'currency_exchange';
        $user = Auth::user();
        $currency_exchange = CurrencyExchange::orderby('id','asc')->get();
        $exc_ids = response()->json($currency_exchange->modelKeys());
        $currency = Currency::orderby('id','asc')->get();



        // dd($country);
        return view('crm.master.exchange', compact(['route_active','exc_ids','currency','currency_exchange']));        

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
    public function storecountry(Request $request)
    {
        $validator = $request->validate([
            'countryname'=>'required',
            'countrycode'=>'required|max:3',
            'continent'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Country::create([
                'name'=>$request->countryname,
                'code'=>$request->countrycode,
                'continent'=>$request->continent
            ]);
            $notification = array(
                'message' => 'Country added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storecob(Request $request)
    {
        $validator = $request->validate([
            'cobcode'=>'required|max:5|unique:cob,code',
            'cobdescription'=>'required',
            'cobabbreviation'=>'required',
            'cobremarks'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            COB::create([
                'code'=>$request->cobcode,
                'description'=>$request->cobdescription,
                'abbreviation'=>$request->cobabbreviation,
                'remarks'=>$request->cobremarks
            ]);
            $notification = array(
                'message' => 'COB added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeoccupation(Request $request)
    {
        $validator = $request->validate([
            'ocpcode'=>'required|max:5|unique:occupation,code',
            'ocpdescription'=>'required',
            'ocpabbreviation'=>'required',
            'ocpgrouptype'=>'required',
            'ocpcob'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Occupation::create([
                'code'=>$request->ocpcode,
                'description'=>$request->ocpdescription,
                'abbreviation'=>$request->ocpabbreviation,
                'group_type'=>$request->ocpgrouptype,
                'cob'=>$request->ocpcob,
            ]);
            $notification = array(
                'message' => 'Occupation added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storecurrency(Request $request)
    {
        $validator = $request->validate([
            'crccode'=>'required|max:5|unique:currencies,code',
            'crcsymbolname'=>'required',
            'crccountry'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Currency::create([
                'symbol_name'=>$request->crcsymbolname,
                'is_base_currency' => '',
                'code'=>$request->crccode,
                'country'=>$request->crccountry
            ]);
            $notification = array(
                'message' => 'Currency added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeexchange(Request $request)
    {
        $validator = $request->validate([
            'exccurrency'=>'required|max:5|unique:currencies_exc,currency',
            'excmonth'=>'required',
            'excyear'=>'required',
            'exckurs'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            CurrencyExchange::create([
                'currency'=>$request->exccurrency,
                'month' => $request->excmonth,
                'year'=>$request->excyear,
                'kurs'=>$request->exckurs
            ]);
            $notification = array(
                'message' => 'Currency Exchange added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function updatecountry(Request $request, Country $country)
    {
        $validator = $request->validate([
            'namecountry'=>'required',
            'codecountry'=>'required|max:3',
            'continentcountry'=>'required'
        ]);
        if($validator){
            $country->name = $request->namecountry;
            $country->code = $request->codecountry;
            $country->continent = $request->continentcountry;
            $country->save();
            $notification = array(
                'message' => 'Country updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updatecob(Request $request, COB $cob)
    {
        $validator = $request->validate([
            'codecob'=>'required|max:5',
            'descriptioncob'=>'required',
            'abbreviationcob'=>'required',
            'remarkscob'=>'required'
        ]);
        if($validator){
            $cob->code = $request->codecob;
            $cob->description = $request->descriptioncob;
            $cob->abbreviation = $request->abbreviationcob;
            $cob->remarks = $request->remarkscob;
            $cob->save();
            $notification = array(
                'message' => 'COB updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updateoccupation(Request $request, Occupation $ocp)
    {
        $validator = $request->validate([
            'codeocp'=>'required|max:5',
            'descriptionocp'=>'required',
            'abbreviationocp'=>'required',
            'grouptypeocp'=>'required',
            'cobocp'=>'required'
        ]);
        if($validator){
            $ocp->code = $request->codeocp;
            $ocp->description = $request->descriptionocp;
            $ocp->abbreviation = $request->abbreviationocp;
            $ocp->group_type = $request->grouptypeocp;
            $ocp->cob = $request->cobocp;
            $ocp->save();
            $notification = array(
                'message' => 'Occupation updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

   public function updatecurrency(Request $request, Currency $crc)
   {
    
    $validator = $request->validate([
        'codecrc'=>'required|max:5',
        'symbolnamecrc'=>'required',
        'countrycrc'=>'required'
    ]);
    
    if($validator){
        $crc->symbol_name = $request->symbolnamecrc;
        $crc->code = $request->codecrc;
        $crc->country = $request->countrycrc;
        $crc->save();
        $notification = array(
            'message' => 'Currency updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
   }

   public function updateexchange(Request $request, CurrencyExchange $exc)
   {
    
    $validator = $request->validate([
        'currencyexc'=>'required|max:5',
            'monthexc'=>'required',
            'yearexc'=>'required',
            'kursexc'=>'required'
    ]);
    
    if($validator){
        $exc->currency = $request->currencyexc;
        $exc->month = $request->monthexc;
        $exc->year = $request->yearexc;
        $exc->kurs = $request->kursexc;
        $exc->save();
        $notification = array(
            'message' => 'Currency updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroycountry(Country $country)
    {
        if($country->delete()){
            $notification = array(
                'message' => 'Country deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }


    public function destroycob(COB $cob)
    {
        if($cob->delete()){
            $notification = array(
                'message' => 'COB deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyoccupation(Occupation $ocp)
    {
        if($ocp->delete()){
            $notification = array(
                'message' => 'Occupation deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroycurrency(Currency $crc)
    {
        if($crc->delete()){
            $notification = array(
                'message' => 'Currency deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyExchange(CurrencyExchange $exc)
    {
        if($exc->delete()){
            $notification = array(
                'message' => 'Currency Exchange deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

}
