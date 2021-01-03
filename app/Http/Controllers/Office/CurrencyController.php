<?php

namespace App\Http\Controllers\Office;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{

    public function index()
    {
        $route_active = 'currency';
        $currencies = Currency::get();
        $currency_ids = response()->json($currencies->modelKeys());
        return view('crm.office.currency', compact(['route_active', 'currencies','currency_ids']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
            'symbol'=>'required'
        ]);
        if($validated){
            Currency::create([
                'name'=> $request->name, 
                'symbol'=>$request->symbol,
                'is_base_currency'=>'no',
            ]);
            $notification = array(
                'message' => 'Currency added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }
    }

    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'name'=>'required',
            'symbol'=>'required'
        ]);
        if($validated){
            $currency->name = $request->name;
            $currency->symbol = $request->symbol;
            $currency->save();

            $notification = array(
                'message' => 'Currency updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }        
    }

    public function baseUpdate(Request $request, Currency $currency)
    {
        $curriencies = Currency::get();
        foreach ($curriencies as $currencyItem) {
            $currencyItem->is_base_currency = 'no';
            $currencyItem->save();
        }
        $currency->is_base_currency = 'yes';
        $currency->save();
        if($currency->save()){
            $notification = array(
                'message' => 'Currency updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }        
    }

    public function destroy(Currency $currency)
    {
        if($currency->delete()){
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
