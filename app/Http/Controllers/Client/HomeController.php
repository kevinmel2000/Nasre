<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home(){
        return redirect(url('client/invoices'));
        $route_active = 'Home';
        $customer = Customer::where(['id'=>session('citizen_id')])->first();
        return view('client.home', compact('route_active','customer'));
    }    

    public function profile(){
        $route_active = 'Profile';
        $customer = Customer::find(['id'=>session('client_id')])->first();
        return view('client.profile', compact('route_active','customer'));
    }

    public function profileUpdate(Request $request){
        $route_active = 'Profile';
        $customer = Customer::find(['id'=>session('client_id')])->first();
        $customer->first_contact->email = $request->email;
        $customer->first_contact->phone = $request->phone;
        if ($customer->first_contact->save()) {
            $notification = array(
                'message' => 'Profile updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return view('client.profile', compact('route_active','customer'));
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required',
            'confirm_password'=> 'required',
        ]);
        $customer = Customer::find(['id'=>session('client_id')])->first();
        if (!Hash::check($request->old_password, $customer->password)) {
            $notification = array(
                'message' => 'Old password is incorrect!',
                'alert-type' => 'error'
            );
            return back()->with($notification)->withInput();
        }
        if($request->new_password != $request->confirm_password){
            $notification = array(
                'message' => 'New password and confirm password does not match!',
                'alert-type' => 'error'
            );
            return back()->with($notification)->withInput();
        }
        $hashed = Hash::make($request->new_password);
        if($validator){
            $customer->password = $hashed;
            $customer->save();
            $notification = array(
                'message' => 'Password updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function logout(){
        session()->flush();
        return redirect('/client/login');
    }
}
