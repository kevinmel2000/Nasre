<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReminderController;
Route::group(['prefix'=>'/reminder','middleware'=>['auth']], function(){
    // SECTION reminder Routes
    Route::get('/', [ReminderController::class, 'index']);
    Route::get('/email/{reminder}', [ReminderController::class, 'mailToStaff']);
    Route::get('/create', [ReminderController::class, 'create']);
    Route::post('/store', [ReminderController::class, 'store']);
    Route::get('/edit/{reminder}', [ReminderController::class, 'edit']);
    Route::put('/update/{reminder}', [ReminderController::class, 'update']);
    Route::put('/updateNotification/{reminder}', [ReminderController::class, 'updateNotification']);
    Route::delete('/destroy/{reminder}', [ReminderController::class, 'destroy']);
    // !SECTION Product Routes
});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('reminder/getCustomers', [ReminderController::class, 'getCustomers']);
    Route::post('reminder/getLeads', [ReminderController::class, 'getLeads']);
});

?>