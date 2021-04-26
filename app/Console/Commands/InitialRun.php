<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InitialRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initial:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Run commands sets up some module permissions required for the project, as well as some db seeding.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // ID 1 is for Admin, and we don't want to write any permissions for admin role.
 

        // Don't write permissions for admin and salesperson role
        $roles = Role::where('id','!=','1')->where('id','!=','3')->get();
        $modules = config('constants.MODULES');
        
        foreach ($modules as $module) {
            foreach ($roles as $role) {
                Module::create([
                    'module_name'=>$module,
                    'role_id'=>$role->id,
                    'create'=>'off',
                    'read'=>'off',
                    'update'=>'off',
                    'delete'=>'off',
                ]);
            }
        }

        // Set all permissions to "on" for each module for admin role => role_id = 1
        foreach ($modules as $module) {
                Module::create([
                    'module_name'=>$module,
                    'role_id'=>1,
                    'create'=>'on',
                    'read'=>'on',
                    'update'=>'on',
                    'delete'=>'on',
                ]);
                if ($module == 'lead_module') {
                    Module::create([
                        'module_name'=>$module,
                        'role_id'=>3,
                        'create'=>'on',
                        'read'=>'on',
                        'update'=>'on',
                        'delete'=>'on',
                    ]);
                }else{
                    Module::create([
                        'module_name'=>$module,
                        'role_id'=>3,
                        'create'=>'off',
                        'read'=>'off',
                        'update'=>'off',
                        'delete'=>'off',
                    ]);                    
                }
        }
        
        // Import SQL Files 
        DB::unprepared(file_get_contents(base_path('database/migrations/countries.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/states.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/cities-1.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/cities-2.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/cities-3.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/cities-4.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/cities-5.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/languages.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/industries.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/timezones.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/lead_sources.sql')));
        DB::unprepared(file_get_contents(base_path('database/migrations/lead_statuses.sql')));



        Storage::disk('public')->deleteDirectory('mediafiles');
        return null;
    }
}
