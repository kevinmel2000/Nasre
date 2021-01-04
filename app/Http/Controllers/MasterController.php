<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;


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

        // dd($country);
        return view('crm.master.country', compact(['route_active', 'country']));        

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
