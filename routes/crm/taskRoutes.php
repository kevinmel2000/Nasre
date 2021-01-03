<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
Route::group(['prefix'=>'/task','middleware'=>['auth']], function(){
    // SECTION task Routes
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/email/{task}', [TaskController::class, 'mailToStaff']);
    Route::get('/create',   [TaskController::class, 'create']);
    Route::post('/store', [TaskController::class, 'store']);
    Route::get('/edit/{task}', [TaskController::class, 'edit']);
    Route::put('/update/{task}', [TaskController::class, 'update']);
    Route::delete('/destroy/{task}', [TaskController::class, 'destroy']);
    // !SECTION Product Routes
});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('task/getCustomers', [TaskController::class, 'getCustomers']);
    Route::post('task/getLeads', [TaskController::class, 'getLeads']);
});

?>