<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Jobs\Client\PasswordResetJob;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('client.auth.login');
    }

    public function login(Request $request){
        $validators = $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);
        if($request){
            $customer = Customer::where(['username'=>$request->username])->first();
            // dd($customer);
            // find customer with email
                // if email not found
                if($customer == null){
                    return back()->with(['message'=>'Username not found!']);
                }else{
                    // dump(bcrypt($request->password) == $customer->password)
                    // dump(Hash::check($request->password, $customer->password));
                    // dump($customer->password);
                    // dd($request->password);
                    if(Hash::check($request->password, $customer->password)) {
                        // Set client session
                        session(['client_id' => $customer->id]);
                        session(['client_username' => $customer->username]);
                        session(['client_email' => $customer->first_contact->email]);

                        return redirect(url('client/home'));
                    }else{
                        return back()->with(['message'=>'Password incorrect!']);
                    }
                }
        }else{
            return back()->withErrors($validators);
        }
    }

    public function forgotPassword(){
        return view('client.auth.passwords.email');
    }

    public function forgotPasswordEmail(Request $request){
        $validators = $request->validate([
            'username'=>'required'
        ]);
        if($validators){
            $customer = Customer::where('username',$request->username)->first();
            if($customer == null){
                return back()->withErrors(['username'=>'This username is not registered with any account!']);
            }else{
                $token = md5($customer->email.now());
                $check_unique = Customer::where('password_reset_token',$token)->first();
                if($check_unique != null){
                    $token = md5($customer->email.now().config('app.name'));
                }
                $customer->password_reset_token = $token;
                $customer->save();
               
                PasswordResetJob::dispatch($customer, $token);
                $notification = array(
                    'message' => 'Your request has been registered successfully and you will receive an reset email shortly!',
                    'alert-type' => 'success'
                );
        
                return back()->with($notification);
            }
        }else{
            return back()->withErrors($validators);
        }

    }

    public function passwordReset($token){
        $customer = Customer::where('password_reset_token',$token)->first();
        if($customer == null){
            return view('client.auth.passwords.email')->withErrors(['error'=>'Token expired, Enter your username again!']);
        }
        return view('client.auth.passwords.reset', compact('token'));
    }

    public function setNewPassword(Request $request){
        $validators = $request->validate([
            'username'=>'required',
            'password'=>'required | confirmed'
        ]);
        if($validators){
            $customer  = Customer::where(['username'=>$request->username,'password_reset_token'=>$request->token])->first();
            if($customer == null){
                $notification = array(
                    'message' => 'This link is expired, please try again with the latest email you have received!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
         
            $hashed = Hash::make($request->password);
            $customer->password = $hashed;
            $customer->password_reset_token = '';
            $customer->save();
            return redirect(url('client/login'));
        }else{
            return back()->withErrors($validators);
        }

    }
}
