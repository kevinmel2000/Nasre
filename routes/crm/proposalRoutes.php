<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;

Route::group(['prefix'=>'/proposal','middleware'=>['auth']], function(){

    // SECTION Proposal Routes
    Route::get('/', [ProposalController::class, 'index']);
    Route::get('/email/{proposal}', [ProposalController::class, 'mailToClient']);
    Route::get('/create/{relation?}/{id?}', [ProposalController::class, 'create']);
    Route::post('/store', [ProposalController::class, 'store']);
    Route::get('/edit/{proposal}', [ProposalController::class, 'edit']);
    Route::put('/update/{proposal}', [ProposalController::class, 'update']);
    Route::delete('/destroy/{proposal}', [ProposalController::class, 'destroy']);

    Route::get('/proposal_pdf/{proposal}', [ProposalController::class, 'proposal_pdf']);
    // !SECTION Product Routes

});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('proposal/getProduct', [ProposalController::class, 'getProduct']);
    Route::post('proposal/getCustomers', [ProposalController::class, 'getCustomers']);
    Route::post('proposal/getLeads', [ProposalController::class, 'getLeads']);
    Route::post('proposal/getProposalProducts', [ProposalController::class, 'getProposalProducts']);
});

?>