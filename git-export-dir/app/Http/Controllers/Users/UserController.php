<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\User;
use App\Jobs\SendEmailJob;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        $route_active = 'users';
        $current_user = Auth::user();
        $users = User::where('id','!=','1')->where('id','!=',$current_user->id)->get();
        $user_ids = response()->json($users->modelKeys());
        $roles = Role::where('id','!=','1')->get();
        return view('crm.user.users', compact(['route_active','users','roles','user_ids']));
    }

    public function import()
    {
        $route_active = 'users';
        $current_user = Auth::user();
        $users = User::where('id','!=','1')->where('id','!=',$current_user->id)->get();
        $user_ids = response()->json($users->modelKeys());
        $roles = Role::where('id','!=','1')->get();
        return view('crm.user.users_import', compact(['route_active','users','roles','user_ids']));
    }

    public function importStore(Request $request){
        $file = $request->file('file')->store('import');
        $import = new UsersImport;
        $import->import($file);
        if(count($import->errors()) == 0){
            $notification = array(
                'message' => $import->getRowCount().' users imported successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->withErrors($import->errors());
        }
    }
    public function userProfile()
    {
        $route_active = 'users_profile';
        $user = Auth::user();
        return view('crm.user.profile', compact(['route_active','user']));
    }

    public function updatePorfile(Request $request, User $user)
    {
        $validator = $request->validate([
            'name'=> 'required',
        ]);

        if($validator){
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();
            $notification = array(
                'message' => 'User updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        $validator = $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required',
            'confirm_password'=> 'required',
        ]);
        if (!Hash::check($request->old_password, $user->password)) {
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
            $user->password = $hashed;
            $user->save();
            $notification = array(
                'message' => 'Password updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function mailToStaff(User $user, $password){
        $company_details = [];
        $company_name = SingleRowData::where('field_name','company_name')->first();
        array_push($company_details, $company_name);
        $company_address = SingleRowData::where('field_name','company_address')->first();
        array_push($company_details, $company_address);
        $company_city = SingleRowData::where('field_name','company_city')->first();
        array_push($company_details, $company_city);
        $company_state = SingleRowData::where('field_name','company_state')->first();
        array_push($company_details, $company_state);
        $company_country = SingleRowData::where('field_name','company_country')->first();
        array_push($company_details, $company_country);
        $company_zip = SingleRowData::where('field_name','company_zip')->first();
        array_push($company_details, $company_zip);
        $company_phone = SingleRowData::where('field_name','company_phone')->first();
        array_push($company_details, $company_phone);
        $company_email = SingleRowData::where('field_name','company_email')->first();
        array_push($company_details, $company_email);
        SendEmailJob::dispatch($user, $password, $company_details);
        $notification = array(
            'message' => 'User added and notified successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function store(Request $request)
    {
        $admin = User::where(['id'=>'1'])->first();
        $validator = $request->validate([
            'email'=>'required | email | unique:users',
            'name'=> 'required',
            'password'=>'required'
        ]);
        if($validator){
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'role_id'=>$request->role_id,
                'phone'=>$request->phone,
                'password'=>bcrypt($request->password)
            ]);

            if ($request->welcome_email == 'yes') {
                return $this->mailToStaff($user, $request->password);
            }    

            $notification = array(
                'message' => 'User added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function update(Request $request, User $user)
    {
        $validator = $request->validate([
            'name'=> 'required',
        ]);

        if($validator){
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;
            $user->status = $request->status;
            $user->save();
            $notification = array(
                'message' => 'User updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }


    public function destroy(User $user)
    {
        if($user->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'User deleted successfully!'
            ];
            return back()->with($notification);
        }else{
            $notification = [
                'alert-type'=>'error',
                'message'=>'Please try again!'
            ];
            return back()->with($notification);            
        }
    }
}
