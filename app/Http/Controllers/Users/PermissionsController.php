<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    public function index()
    {
        // NOTE: $roles are the total user roles except admin
        $roles = Role::where('name','!=','admin')->get();

        // NOTE: selected role is the role, which is currently selected to show the permissions on the page. 
        $selected_role = Role::where('default_role','yes')->first();
        $selected_role_id = $selected_role->id;

        // NOTE: all modules from the constant file
        $modules = config('constants.MODULES');
        $modules2 = config('constants.MODULES2');
        
        $contact_module =  Module::where(['module_name'=>'contact_module','role_id'=>$selected_role_id])->first();
        $role_module =  Module::where(['module_name'=>'role_module','role_id'=>$selected_role_id])->first();
        $user_module =  Module::where(['module_name'=>'user_module','role_id'=>$selected_role_id])->first();
        // $lead_module =  Module::where(['module_name'=>'lead_module','role_id'=>$selected_role_id])->first();
        // $finance_module =  Module::where(['module_name'=>'finance_module','role_id'=>$selected_role_id])->first();
        // $product_module =  Module::where(['module_name'=>'product_module','role_id'=>$selected_role_id])->first();
        // $proposal_module =  Module::where(['module_name'=>'proposal_module','role_id'=>$selected_role_id])->first();
        // $invoice_module =  Module::where(['module_name'=>'invoice_module','role_id'=>$selected_role_id])->first();
        // $project_module =  Module::where(['module_name'=>'project_module','role_id'=>$selected_role_id])->first();
        // $estimate_module =  Module::where(['module_name'=>'estimate_module','role_id'=>$selected_role_id])->first();
        // $task_module =  Module::where(['module_name'=>'task_module','role_id'=>$selected_role_id])->first();
        // $media_module =  Module::where(['module_name'=>'media_module','role_id'=>$selected_role_id])->first();
        // $reminder_module =  Module::where(['module_name'=>'reminder_module','role_id'=>$selected_role_id])->first();
        // $office_module =  Module::where(['module_name'=>'office_module','role_id'=>$selected_role_id])->first();
        $country_module =  Module::where(['module_name'=>'country_module','role_id'=>$selected_role_id])->first();
        $occupation_module =  Module::where(['module_name'=>'occupation_module','role_id'=>$selected_role_id])->first();
        $cob_module =  Module::where(['module_name'=>'cob_module','role_id'=>$selected_role_id])->first();
        $currency_module =  Module::where(['module_name'=>'currency_module','role_id'=>$selected_role_id])->first();
        $exchange_module =  Module::where(['module_name'=>'exchange_module','role_id'=>$selected_role_id])->first();
        $koc_module =  Module::where(['module_name'=>'koc_module','role_id'=>$selected_role_id])->first();
        $fe_lookup_module =  Module::where(['module_name'=>'fe_lookup_module','role_id'=>$selected_role_id])->first();
        $ceding_broker_module =  Module::where(['module_name'=>'ceding_broker_module','role_id'=>$selected_role_id])->first();
        $golf_field_hole_module =  Module::where(['module_name'=>'golf_field_hole_module','role_id'=>$selected_role_id])->first();
        $city_module =  Module::where(['module_name'=>'city_module','role_id'=>$selected_role_id])->first();
        $state_module =  Module::where(['module_name'=>'state_module','role_id'=>$selected_role_id])->first();
        $earthquake_zone_module =  Module::where(['module_name'=>'earthquake_zone_module','role_id'=>$selected_role_id])->first();
        $flood_zone_module =  Module::where(['module_name'=>'flood_zone_module','role_id'=>$selected_role_id])->first();
        $ship_type_module =  Module::where(['module_name'=>'ship_type_module','role_id'=>$selected_role_id])->first();
        $classification_module =  Module::where(['module_name'=>'classification_module','role_id'=>$selected_role_id])->first();
        $construction_module =  Module::where(['module_name'=>'construction_module','role_id'=>$selected_role_id])->first();
        $marine_lookup_module =  Module::where(['module_name'=>'marine_lookup_module','role_id'=>$selected_role_id])->first();
        $property_type_module =  Module::where(['module_name'=>'property_type_module','role_id'=>$selected_role_id])->first();
        $condition_needed_module =  Module::where(['module_name'=>'condition_needed_module','role_id'=>$selected_role_id])->first();
        $fire_engineering_slip_module =  Module::where(['module_name'=>'fire_engineering_slip_module','role_id'=>$selected_role_id])->first();
        
        $route_active = 'permissions';
        return view('crm.user.role_permissions', 
        compact([   'route_active',
                    'roles',
                    'selected_role_id', 
                    'modules',
                    'modules2',
                    'contact_module',
                    'role_module',
                    'user_module',
                    // 'lead_module',
                    // 'finance_module',
                    // 'product_module',
                    // 'proposal_module',
                    // 'invoice_module',
                    // 'project_module',
                    // 'estimate_module',
                    // 'task_module',
                    // 'media_module',
                    // 'reminder_module',
                    // 'office_module',
                    'country_module',
                    'occupation_module',
                    'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'golf_field_hole_module',
                    'ceding_broker_module',
                    'fe_lookup_module',
                    'city_module',
                    'state_module',
                    'earthquake_zone_module',
                    'flood_zone_module',
                    'ship_type_module',
                    'classification_module',
                    'construction_module',
                    'marine_lookup_module',
                    'property_type_module',
                    'condition_needed_module',
                    'fire_engineering_slip_module',
                ]));
    }

    /**
     *  POST
     *  redirect to the permissions index page with the selected role ID,which is coming as POST
     */
    public function permissionsByUser(Role $role, Request $request){
        // NOTE: $roles are the total user roles except admin
        $roles = Role::where('name','!=','admin')->get();

        // NOTE: selected role is the role, which is currently selected to show the permissions on the page. 

        $selected_role_id = $request->role_id;
        // NOTE: all modules from the constant file
        $modules = config('constants.MODULES');
        $modules2 = config('constants.MODULES2');

       
        $contact_module =  Module::where(['module_name'=>'contact_module','role_id'=>$selected_role_id])->first();
        $role_module =  Module::where(['module_name'=>'role_module','role_id'=>$selected_role_id])->first();
        $user_module =  Module::where(['module_name'=>'user_module','role_id'=>$selected_role_id])->first();
        // $lead_module =  Module::where(['module_name'=>'lead_module','role_id'=>$selected_role_id])->first();
        // $finance_module =  Module::where(['module_name'=>'finance_module','role_id'=>$selected_role_id])->first();
        // $product_module =  Module::where(['module_name'=>'product_module','role_id'=>$selected_role_id])->first();
        // $proposal_module =  Module::where(['module_name'=>'proposal_module','role_id'=>$selected_role_id])->first();
        // $invoice_module =  Module::where(['module_name'=>'invoice_module','role_id'=>$selected_role_id])->first();
        // $project_module =  Module::where(['module_name'=>'project_module','role_id'=>$selected_role_id])->first();
        // $estimate_module =  Module::where(['module_name'=>'estimate_module','role_id'=>$selected_role_id])->first();
        // $task_module =  Module::where(['module_name'=>'task_module','role_id'=>$selected_role_id])->first();
        // $media_module =  Module::where(['module_name'=>'media_module','role_id'=>$selected_role_id])->first();
        // $reminder_module =  Module::where(['module_name'=>'reminder_module','role_id'=>$selected_role_id])->first();
        // $office_module =  Module::where(['module_name'=>'office_module','role_id'=>$selected_role_id])->first();
        $country_module =  Module::where(['module_name'=>'country_module','role_id'=>$selected_role_id])->first();
        $occupation_module =  Module::where(['module_name'=>'occupation_module','role_id'=>$selected_role_id])->first();
        $cob_module =  Module::where(['module_name'=>'cob_module','role_id'=>$selected_role_id])->first();
        $currency_module =  Module::where(['module_name'=>'currency_module','role_id'=>$selected_role_id])->first();
        $exchange_module =  Module::where(['module_name'=>'exchange_module','role_id'=>$selected_role_id])->first();
        $koc_module =  Module::where(['module_name'=>'koc_module','role_id'=>$selected_role_id])->first();
        $fe_lookup_module =  Module::where(['module_name'=>'fe_lookup_module','role_id'=>$selected_role_id])->first();
        $ceding_broker_module =  Module::where(['module_name'=>'ceding_broker_module','role_id'=>$selected_role_id])->first();
        $golf_field_hole_module =  Module::where(['module_name'=>'golf_field_hole_module','role_id'=>$selected_role_id])->first();
        $city_module =  Module::where(['module_name'=>'city_module','role_id'=>$selected_role_id])->first();
        $state_module =  Module::where(['module_name'=>'state_module','role_id'=>$selected_role_id])->first();
        $earthquake_zone_module =  Module::where(['module_name'=>'earthquake_zone_module','role_id'=>$selected_role_id])->first();
        $flood_zone_module =  Module::where(['module_name'=>'flood_zone_module','role_id'=>$selected_role_id])->first();
        $ship_type_module =  Module::where(['module_name'=>'ship_type_module','role_id'=>$selected_role_id])->first();
        $classification_module =  Module::where(['module_name'=>'classification_module','role_id'=>$selected_role_id])->first();
        $construction_module =  Module::where(['module_name'=>'construction_module','role_id'=>$selected_role_id])->first();
        $marine_lookup_module =  Module::where(['module_name'=>'marine_lookup_module','role_id'=>$selected_role_id])->first();
        $property_type_module =  Module::where(['module_name'=>'property_type_module','role_id'=>$selected_role_id])->first();
        $condition_needed_module =  Module::where(['module_name'=>'condition_needed_module','role_id'=>$selected_role_id])->first();
        $fire_engineering_slip_module =  Module::where(['module_name'=>'fire_engineering_slip_module','role_id'=>$selected_role_id])->first();
        

        $route_active = 'permissions';
        return view('crm.user.role_permissions', 
        compact([   'route_active',
                    'roles',
                    'selected_role_id', 
                    'modules',
                    'modules2',
                    'contact_module',
                    'role_module',
                    'user_module',
                    // 'lead_module',
                    // 'finance_module',
                    // 'product_module',
                    // 'proposal_module',
                    // 'invoice_module',
                    // 'project_module',
                    // 'estimate_module',
                    // 'task_module',
                    // 'media_module',
                    // 'reminder_module',
                    // 'office_module',
                    'country_module',
                    'occupation_module',
                    'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'golf_field_hole_module',
                    'ceding_broker_module',
                    'fe_lookup_module',
                    'city_module',
                    'state_module',
                    'earthquake_zone_module',
                    'flood_zone_module',
                    'ship_type_module',
                    'classification_module',
                    'construction_module',
                    'marine_lookup_module',
                    'property_type_module',
                    'condition_needed_module',
                    'fire_engineering_slip_module',
                ]));

    }

    /**
     *  GET
     *  redirect to the permissions index page with the selected role ID
     */
    public function getPermissionsByUser(Role $role = NULL){
        // NOTE: $roles are the total user roles except admin
        $roles = Role::where('name','!=','admin')->get();

        // NOTE: selected role is the role, which is currently selected to show the permissions on the page. 

        $selected_role_id = $role->id;
        // NOTE: all modules from the constant file
        $modules = config('constants.MODULES');
        $modules2 = config('constants.MODULES2');

        
        $contact_module =  Module::where(['module_name'=>'contact_module','role_id'=>$selected_role_id])->first();
        $role_module =  Module::where(['module_name'=>'role_module','role_id'=>$selected_role_id])->first();
        $user_module =  Module::where(['module_name'=>'user_module','role_id'=>$selected_role_id])->first();
        // $lead_module =  Module::where(['module_name'=>'lead_module','role_id'=>$selected_role_id])->first();
        // $finance_module =  Module::where(['module_name'=>'finance_module','role_id'=>$selected_role_id])->first();
        // $product_module =  Module::where(['module_name'=>'product_module','role_id'=>$selected_role_id])->first();
        // $proposal_module =  Module::where(['module_name'=>'proposal_module','role_id'=>$selected_role_id])->first();
        // $invoice_module =  Module::where(['module_name'=>'invoice_module','role_id'=>$selected_role_id])->first();
        // $project_module =  Module::where(['module_name'=>'project_module','role_id'=>$selected_role_id])->first();
        // $estimate_module =  Module::where(['module_name'=>'estimate_module','role_id'=>$selected_role_id])->first();
        // $task_module =  Module::where(['module_name'=>'task_module','role_id'=>$selected_role_id])->first();
        // $media_module =  Module::where(['module_name'=>'media_module','role_id'=>$selected_role_id])->first();
        // $reminder_module =  Module::where(['module_name'=>'reminder_module','role_id'=>$selected_role_id])->first();
        // $office_module =  Module::where(['module_name'=>'office_module','role_id'=>$selected_role_id])->first();
        $country_module =  Module::where(['module_name'=>'country_module','role_id'=>$selected_role_id])->first();
        $occupation_module =  Module::where(['module_name'=>'occupation_module','role_id'=>$selected_role_id])->first();
        $cob_module =  Module::where(['module_name'=>'cob_module','role_id'=>$selected_role_id])->first();
        $currency_module =  Module::where(['module_name'=>'currency_module','role_id'=>$selected_role_id])->first();
        $exchange_module =  Module::where(['module_name'=>'exchange_module','role_id'=>$selected_role_id])->first();
        $koc_module =  Module::where(['module_name'=>'koc_module','role_id'=>$selected_role_id])->first();
        $fe_lookup_module =  Module::where(['module_name'=>'fe_lookup_module','role_id'=>$selected_role_id])->first();
        $ceding_broker_module =  Module::where(['module_name'=>'ceding_broker_module','role_id'=>$selected_role_id])->first();
        $golf_field_hole_module =  Module::where(['module_name'=>'golf_field_hole_module','role_id'=>$selected_role_id])->first();
        $city_module =  Module::where(['module_name'=>'city_module','role_id'=>$selected_role_id])->first();
        $state_module =  Module::where(['module_name'=>'state_module','role_id'=>$selected_role_id])->first();
        $earthquake_zone_module =  Module::where(['module_name'=>'earthquake_zone_module','role_id'=>$selected_role_id])->first();
        $flood_zone_module =  Module::where(['module_name'=>'flood_zone_module','role_id'=>$selected_role_id])->first();
        $ship_type_module =  Module::where(['module_name'=>'ship_type_module','role_id'=>$selected_role_id])->first();
        $classification_module =  Module::where(['module_name'=>'classification_module','role_id'=>$selected_role_id])->first();
        $construction_module =  Module::where(['module_name'=>'construction_module','role_id'=>$selected_role_id])->first();
        $marine_lookup_module =  Module::where(['module_name'=>'marine_lookup_module','role_id'=>$selected_role_id])->first();
        $property_type_module =  Module::where(['module_name'=>'property_type_module','role_id'=>$selected_role_id])->first();
        $condition_needed_module =  Module::where(['module_name'=>'condition_needed_module','role_id'=>$selected_role_id])->first();
        $fire_engineering_slip_module =  Module::where(['module_name'=>'fire_engineering_slip_module','role_id'=>$selected_role_id])->first();

        $route_active = 'permissions';
        return view('crm.user.role_permissions', 
        compact([   'route_active',
                    'roles',
                    'selected_role_id', 
                    'modules',
                    'modules2',
                    'contact_module',
                    'role_module',
                    'user_module',
                    // 'lead_module',
                    // 'finance_module',
                    // 'product_module',
                    // 'proposal_module',
                    // 'invoice_module',
                    // 'project_module',
                    // 'estimate_module',
                    // 'task_module',
                    // 'media_module',
                    // 'reminder_module',
                    // 'office_module',
                    'country_module',
                    'occupation_module',
                    'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'golf_field_hole_module',
                    'ceding_broker_module',
                    'fe_lookup_module',
                    'city_module',
                    'state_module',
                    'earthquake_zone_module',
                    'flood_zone_module',
                    'ship_type_module',
                    'classification_module',
                    'construction_module',
                    'marine_lookup_module',
                    'property_type_module',
                    'condition_needed_module',
                    'fire_engineering_slip_module',
                ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        Module::create([
            'module_name'=>$request->module_name,
            'role_id'=>$request->role_id,
            'create'=>($request->create == 'on') ? $request->create : 'off',
            'read'=>($request->read == 'on') ? $request->read : 'off',
            'update'=>($request->update == 'on') ? $request->update : 'off',
            'delete'=>($request->delete == 'on') ? $request->delete : 'off',
        ]);
        $notification = array(
            'message' => 'Role permissions added successfully!',
            'alert-type' => 'success'
        );
        // dd('Role permissions added successfully ');
        return redirect(route('permissions_role_id', $request->role_id))->with($notification);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Module $module, Request $request)
    {
        if($request->create != null){
            $module->create = (count($request->create) == 2)? 'on': 'off';
        }
        if($request->read != null){
            $module->read = (count($request->read) == 2)? 'on': 'off';
        }
        if($request->update != null){
            $module->update = (count($request->update) == 2)? 'on': 'off';
        }
        if($request->delete != null){
            $module->delete = (count($request->delete) == 2)? 'on': 'off';
        }
        if($module->save()){
            $notification = array(
                'message' => 'Role permissions updated successfully!',
                'alert-type' => 'success'
            );
            return redirect(route('permissions_role_id', $request->role_id))->with($notification);         
        }else{
            $notification = array(
                'message' => 'Please refresh the page and try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

}
