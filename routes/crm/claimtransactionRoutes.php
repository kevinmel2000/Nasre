<?php

use App\Http\Controllers\KocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeLookupLocationController;
use App\Http\Controllers\GolfFieldHoleController;
use App\Http\Controllers\CedingBrokerController;
use App\Http\Controllers\FeSlipController;
use App\Http\Controllers\FinancialLineSlipController;
use App\Http\Controllers\HeMotorSlipController;
use App\Http\Controllers\MovePropSlipController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Claim_controller;



Route::group(['prefix'=>'/claimtransaction-data','middleware'=>['auth']], function(){
 
    // Claim Route
    Route::get('claim',[Claim_controller::class,'index']);    
    Route::get('/claim-index', [Claim_controller::class, 'indexclaim']);
    Route::post('/claim/store', [Claim_controller::class, 'storeclaiminsured']);
    Route::post('/claim/destroy/{id}', [Claim_controller::class, 'destroy']);
    Route::delete('/claim/destroy/{id}', [Claim_controller::class, 'destroy']);
    Route::get('/detailslipclaim/{idm}', [Claim_controller::class, 'getdetailSlipClaim']);
    Route::get('/updateclaim/{idm}', [Claim_controller::class, 'updateindex']);
    

});
?>