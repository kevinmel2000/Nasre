<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::group(['prefix'=>'/media','middleware'=>['auth']], function(){

    // SECTION media Routes
    Route::get('/', [MediaController::class, 'index']);
    Route::get('/create', [MediaController::class, 'create']);
    Route::post('/store', [MediaController::class, 'store']);
    Route::get('/edit/{media}', [MediaController::class, 'edit']);
    Route::put('/update/{media}',   [MediaController::class, 'update']);
    Route::delete('/destroy/{media}',   [MediaController::class, 'destroy']);
    // !SECTION Product Routes

});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('media/getCustomers',   [MediaController::class, 'getCustomers']);
    Route::post('media/getLeads', [MediaController::class, 'getLeads']);

});

?>