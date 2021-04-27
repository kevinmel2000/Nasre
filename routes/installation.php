<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\InstallController;

Route::get('/install', function(){
  if (file_exists(STORAGE_PATH('INSTALLED'))) {
      abort('403', 'You have already initialized the installation process, delete the "INSTALLED" file from the app folder and try again.');
  }else{
      file_put_contents(BASE_PATH(".env"), "APP_NAME='PT MANDALA DWIPANTARA PROTEKSI' 
      APP_ENV=local
      APP_KEY=base64:RGNjN09HSjh2WWprU2I3MjQ4eElJR1FSQjZOZkVtODM=
      APP_DEBUG=true
      APP_LOG_LEVEL=debug
      APP_URL=http://localhost:8000");
      $artisan_op = [];
      array_push($artisan_op, '.env generated in the root directory with default content!');
      // Artisan::call('optimize:clear');
      // array_push($artisan_op, Artisan::output());
      // Artisan::call('key:generate');
      // array_push($artisan_op, Artisan::output());

      return view('installation.install', compact('artisan_op'));
  }
});

Route::get('install/steps', [InstallController::class, 'install_steps']);
Route::post('install/submit', [InstallController::class, 'save_install_steps']);
Route::post('install/final', [InstallController::class, 'save_install_final']);

?>