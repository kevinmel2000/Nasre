<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmarinelookup()
    {
        $user = Auth::user();
        $route_active = 'Marine - Lookup Ship';
        $country = User::orderby('id','asc')->get();
        $mlu_ids = response()->json($country->modelKeys());

        return view('crm.transaction.marine_lookup', compact(['user','route_active','mlu_ids']));
    }

    public function indexmarineslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Marine - Slip Entry';
        $ms_ids = response()->json($country->modelKeys());

        return view('crm.transaction.marine_slip', compact(['user','route_active','ms_ids']));
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
    public function store(Request $request)
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
    public function update(Request $request, $id)
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
