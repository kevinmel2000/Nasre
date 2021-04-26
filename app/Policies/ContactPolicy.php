<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Module;
use App\Models\Contact\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        $module = Module::select(['read', 'create', 'update', 'delete'])->where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();
        if ($module->create == 'on' || $module->read == 'on' || $module->update == 'on' || $module->delete == 'on') {
            return true;
        }else{
            return false;
        }
    }

 
    public function view(User $user){
        $module = Module::select(['read'])->where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();
        return $module->read == 'on';
    }

  
    public function create(User $user)
    {
        $module = Module::select(['create'])->where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();
        return $module->create == 'on';
    }
    

    public function update(User $user)
    {
        $module = Module::select(['update'])->where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();
        return $module->update == 'on';
    }

    
    public function delete(User $user)
    {
        $module = Module::select(['delete'])->where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();
        return $module->delete == 'on';
    }

 
}
