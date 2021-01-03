<?php

namespace App\Http\Controllers\Office;

use App\Models\PaymentMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentModeController extends Controller
{

    public function index()
    {
        $route_active = 'paymentmode';
        $paymentModes = PaymentMode::get();
        $paymentmode_ids = response()->json($paymentModes->modelKeys());
        return view('crm.office.paymentmode', compact(['route_active', 'paymentModes','paymentmode_ids']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
            'details'=>'required',
            'is_active'=>'required',
            'is_default'=>'required',
        ]);
        if($validated){

            if ($request->is_active == 'no' && $request->is_default=='yes') {
                $notification = array(
                    'message' => "You can't set inactive payment mode as default!",
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }

            if($request->is_default == 'yes'){
                $paymentmodes = PaymentMode::get();
                foreach ($paymentmodes as $payment_mode) {
                    $payment_mode->is_default = 'no';
                    $payment_mode->save();
                }
            }
            PaymentMode::create([
                'name'=> $request->name, 
                'details'=>$request->details,
                'is_active'=>$request->is_active,
                'is_default'=>$request->is_default,
            ]);
            $notification = array(
                'message' => 'Payment mode added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }
    }


    public function update(Request $request, PaymentMode $paymentMode)
    {
        $validated = $request->validate([
            'name'=>'required',
            'details'=>'required'
        ]);
        if($validated){
            if ($request->is_active == 'no' && $request->is_default=='yes') {
                $notification = array(
                    'message' => "You can't set inactive payment mode as default!",
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
            $paymentmodes = PaymentMode::get();
            foreach ($paymentmodes as $payment_mode) {
                $payment_mode->is_default = 'no';
                $payment_mode->save();
            }

            $paymentMode->name = $request->name;
            $paymentMode->details = $request->details;
            $paymentMode->is_active = $request->is_active;
            $paymentMode->is_default = $request->is_default;
            $paymentMode->save();
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

    public function destroy(PaymentMode $paymentMode)
    {
        if($paymentMode->delete()){
            $notification = array(
                'message' => 'Payment mode deleted successfully!',
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
