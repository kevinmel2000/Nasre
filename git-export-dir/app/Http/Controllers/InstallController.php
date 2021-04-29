<?php

namespace App\Http\Controllers;

use App\Models\SMTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    private function getPermission($folder)
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }

    public function install_steps(){
        $bootstrap_permission = $this->getPermission('bootstrap/cache');
        $stg_app_permission = $this->getPermission('storage/app');
        $stg_framework_permission = $this->getPermission('storage/framework');
        $stg_logs_permission = $this->getPermission('storage/logs');
        return view('installation.steps',compact([
            'bootstrap_permission',
            'stg_app_permission',
            'stg_framework_permission',
            'stg_logs_permission'
        ]));
    }

    public function save_install_steps(Request $request){
        // use --show to get the key instead of command comment
        Artisan::call('key:generate --show');
        $app_key = trim(Artisan::output());
       
        // First clear the file!
        file_put_contents(base_path(".env"), "");
        $contents = "APP_NAME='".$request->app_name."'
APP_ENV=local
APP_KEY=".$app_key."
APP_DEBUG=".$request->app_debug."
APP_LOG_LEVEL=debug
APP_URL=".$request->app_url."

DB_CONNECTION=".$request->db_connection."
DB_HOST=".$request->db_host."
DB_PORT=".$request->db_port."
DB_DATABASE=".$request->db_database."
DB_USERNAME=".$request->db_username."
DB_PASSWORD=".$request->db_password."

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=database

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=".$request->mail_driver."
MAIL_HOST=".$request->mail_host."
MAIL_PORT=".$request->mail_port."
MAIL_USERNAME=".$request->mail_username."
MAIL_PASSWORD=".$request->mail_password."
MAIL_ENCRYPTION=".$request->mail_encryption."

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
        ";
        
        //Save our content to the file.
        file_put_contents(base_path(".env"), $contents);
        $artisan_op = [];
        Artisan::call('config:cache');
        array_push($artisan_op, 'Cache created successfully!');
        Artisan::call('db:wipe');
        array_push($artisan_op, Artisan::output());
        Artisan::call('migrate:fresh');
        array_push($artisan_op, Artisan::output());
        Artisan::call('db:seed');
        array_push($artisan_op, 'DB:SEED Success, Default data added successfully!');
        Artisan::call('initial:run');
        array_push($artisan_op, 'Initial Run executed!');

        // Store SMTP details in the database
        SMTP::create([
            'mail_driver'=>$request->mail_driver,
            'mail_host'=>$request->mail_host,
            'mail_port'=>$request->mail_port,
            'mail_username'=>$request->mail_username,
            'mail_password'=>$request->mail_password,
            'mail_encryption'=>$request->mail_encryption,
        ]);

        return view('installation.final', compact('contents','artisan_op'));
    }

    public function save_install_final(Request $request){
        // First clear the file!
        file_put_contents(base_path(".env"), "");
        //Save our content to the file.
        file_put_contents(base_path(".env"), $request->env);
        $artisan_op = [];
        Artisan::call('config:cache');
        array_push($artisan_op, 'Cache created successfully!');
      
        Artisan::call('storage:link');
        User::create([
            'name'=>'Admin',
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role_id'=>1
        ]);
        array_push($artisan_op, Artisan::output());
        // INSTALLED file create and put some content in it.
        $installed = 'App installed at '.now().' Do not delete this file, it prevents the users to run the installer again!'; 
        file_put_contents(STORAGE_PATH("INSTALLED"), $installed);
        return redirect(url('/'));
    }

}
