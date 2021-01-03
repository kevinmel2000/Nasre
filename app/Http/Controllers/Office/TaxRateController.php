<?php

namespace App\Http\Controllers\Office;

use App\Models\TaxRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxRateController extends Controller
{

    public function index()
    {
        $route_active = 'taxrate';
        $taxRates = TaxRate::get();
        $taxRate_ids = response()->json($taxRates->modelKeys());
        return view('crm.office.taxrate', compact(['route_active', 'taxRates','taxRate_ids']));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
            'rate'=>'required'
        ]);
        if($validated){
            TaxRate::create(['name'=> $request->name, 'rate'=>$request->rate,]);
            $notification = array(
                'message' => 'Taxrate added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        $validated = $request->validate([
            'name'=>'required',
            'rate'=>'required'
        ]);
        if($validated){
            $taxRate->name = $request->name;
            $taxRate->rate = $request->rate;
            $taxRate->save();

            $notification = array(
                'message' => 'Tax rate updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }        
    }

    public function destroy(TaxRate $taxRate)
    {
        if($taxRate->delete()){
            $notification = array(
                'message' => 'Tax rate deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);            
        }else{
            $notification = array(
                'message' => 'Please refresh the page and try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
