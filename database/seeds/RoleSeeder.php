<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Role::class, 1)->create([
            'name'=>'admin',
            'status'=>'active'
        ]);

        factory(App\Models\Role::class, 1)->create([
            'name'=>'user',
            'status'=>'active',
            'default_role'=>'yes'
        ]);

        factory(App\Models\Role::class, 1)->create([
            'name'=>'salesperson',
            'status'=>'active',
        ]);
    }
}
