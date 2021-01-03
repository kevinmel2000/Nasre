<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstimateController;

// public route
Route::put('/estimate/toInvoice/{estimate}', [EstimateController::class, 'convertToInvoice']);

Route::group(['prefix'=>'/estimate','middleware'=>['auth']], function(){

    Route::get('/', [EstimateController::class, 'index']);
    Route::get('/email/{estimate}', [EstimateController::class, 'mailToClient']);
    Route::get('/create/{relation?}/{id?}', [EstimateController::class, 'create']);
    Route::post('/store', [EstimateController::class, 'store']);
    Route::get('/edit/{estimate}', [EstimateController::class, 'edit']);
    Route::put('/update/{estimate}', [EstimateController::class, 'update']);
    Route::get('/toInvoice/{estimate}/{token}', [EstimateController::class, 'convertToInvoice']);
    Route::delete('/destroy/{estimate}', [EstimateController::class, 'destroy']);

    Route::get('/estimate_pdf/{estimate}', [EstimateController::class, 'estimate_pdf']);
});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('estimate/getProduct', [EstimateController::class, 'getProduct']);
    Route::post('estimate/getCustomers', [EstimateController::class, 'getCustomers']);
    Route::post('estimate/getestimateProducts', [EstimateController::class, 'getestimateProducts']);
});

?>