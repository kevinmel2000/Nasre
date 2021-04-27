<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $route_active = 'roles';
        // role id 1 is for admin
        $roles = Role::where('id','!=','1')->get();
        $role_counter = [];
        foreach ($roles as $role) {
            $role_count = User::where(['role_id'=>$role->id])->count();
            array_push($role_counter, $role_count);
        }
        $role_ids = response()->json($roles->modelKeys());
        return view('crm.user.roles', compact(['route_active','roles','role_counter','role_ids']));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required | unique:roles'
        ]);
        
        if($validator){
            $role = Role::create([
                'name'=>$request->name,
                'status'=>'Active'
            ]);
            // Create Module Permissions for each module for the new role to prevent from errors later on.
            $modules = config('constants.MODULES');
            foreach ($modules as $module) {
                Module::create([
                    'module_name'=>$module,
                    'role_id'=>$role->id,
                    'create'=>'off',
                    'read'=>'off',
                    'update'=>'off',
                    'delete'=>'off',
                ]);
            }    
            $notification = array(
                'message' => 'Role added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }


    public function default(Request $request, Role $role)
    {
        if($role->id == '1'){
            $notification = array(
                'message' => "Admin can't be set as default role!",
                'alert-type' => 'error'
            );
            return back()->with($notification);            
        }
        $validator = $request->validate([
            'default_role'=>'required',
        ]);

        if($validator){
            if($request->default_role == 'yes'){
                // first, set default role = no for each role
                $roles = Role::get();
                foreach ($roles as $eachRole) {
                    $eachRole->default_role = 'no';
                    $eachRole->save();
                }
                
                $role->default_role = 'yes';
                $role->save();
            }
           
            $notification = array(
                'message' => 'Role updated as default!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function update(Request $request, Role $role)
    {
     
        if($role->id == '3'){
            $notification = [
                'alert-type'=>'error',
                'message'=>"You can't update salesperson role!"
            ];
            return back()->with($notification);            
        }

        $validator = $request->validate([
            'name'=>'required | unique:roles,name,'.$role->name.',name',
        ]);

        if($validator){
            if($request->status == 'active'){
                foreach ($role->users as  $user) {
                    $user->status = 'active';
                    $user->save();
                }
            }elseif($request->status == 'inactive'){
                foreach ($role->users as  $user) {
                    $user->status = 'inactive';
                    $user->save();
                }
            }
           
            $role->name = $request->name;
            $role->status = $request->status;
            $role->save();
            $notification = array(
                'message' => 'Role updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(Role $role)
    {
        if($role->id == '3'){
            $notification = [
                'alert-type'=>'error',
                'message'=>"You can't delete salesperson role!"
            ];
            return back()->with($notification);            
        }
        $default_role = Role::where(['default_role'=>'yes'])->first();
        $affected_users = count($role->users);
        foreach ($role->users as $user) {
            $user->role_id = $default_role->id;
            $user->save();
        }
        if($role->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'Role deleted successfully! Affected number of users are <b>'.$affected_users.'</b> !'
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
