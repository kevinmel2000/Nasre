<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insured;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        

        if(empty($search))
         {
            $insured = Insured::orderby('id','asc')->get();
            $ms_ids = response()->json($insured->modelKeys());
            $lastid = count($insured);

            if($lastid != null){
                $code_ms = $mydate . strval($lastid + 1);

                // if($lastid->id == 9){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_ms = $mydate . strval(1);
            }
            return view('crm.transaction.marine_slip', compact(['user','insured','route_active','ms_ids','code_ms']));     
         }
        else
        {
          $ms = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($ms->modelKeys());
          return view('crm.transaction.marine_slip', compact('user','insured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }

        
    }

    public function indexfeslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $fe_ids = response()->json($country->modelKeys());

        return view('crm.transaction.fe_slip', compact(['user','route_active','fe_ids']));
    }

    public function indexflslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Financial Lines - Slip Entry';
        $fl_ids = response()->json($country->modelKeys());

        return view('crm.transaction.fl_slip', compact(['user','route_active','fl_ids']));
    }

    public function indexmpslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Moveable Property - Slip Entry';
        $mp_ids = response()->json($country->modelKeys());

        return view('crm.transaction.mp_slip', compact(['user','route_active','mp_ids']));
    }

    public function indexhioslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Hole In One - Slip Entry';
        $hio_ids = response()->json($country->modelKeys());

        return view('crm.transaction.hio_slip', compact(['user','route_active','hio_ids']));
    }

    public function indexpaslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Personal Accident - Slip Entry';
        $pa_ids = response()->json($country->modelKeys());

        return view('crm.transaction.pa_slip', compact(['user','route_active','pa_ids']));
    }

    public function indexhemslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'HE & Motor - Slip Entry';
        $hem_ids = response()->json($country->modelKeys());

        return view('crm.transaction.hem_slip', compact(['user','route_active','hem_ids']));
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
        //
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
    public function storemarineslip(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
