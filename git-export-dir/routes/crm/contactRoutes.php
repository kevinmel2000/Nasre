<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Contact\ContactNoteController;
use App\Http\Controllers\Contact\ContactTitleController;
Route::group(['middleware'=>['auth']], function(){

    // Customer Routes
    Route::get('/customer/create/{lead?}', [ContactController::class, 'create'])->middleware(['can:create-contact']);
    Route::get('/customer/email/{customer}', [ContactController::class, 'mailToClient']);
    Route::get('/customer', [ContactController::class, 'index'])->middleware(['can:view-contact']);
    Route::post('/customer', [ContactController::class, 'store'])->middleware(['can:create-contact']);
    Route::get('/customer/show/{customer}',[ContactController::class, 'show'])->middleware(['can:view-contact']);
    Route::put('/customer/{customer}', [ContactController::class, 'update'])->middleware(['can:update-contact']);
    Route::delete('/customer/destroy/{customer}', [ContactController::class, 'destroy'])->middleware(['can:delete-contact']);

    // For contact only
    Route::post('/customer/contact', [ContactController::class, 'storeContact'])->middleware(['can:create-contact']);
    Route::put('/customer/contact/{contact}', [ContactController::class, 'updateContact'])->middleware(['can:update-contact']);
    Route::put('/customer/contact/makeContactPrimary/{contact}', [ContactController::class, 'makeContactPrimary'])->middleware(['can:update-contact']);
    Route::delete('/customer/contact/destroy/{contact}', [ContactController::class, 'destroyContact'])->middleware(['can:delete-contact']);

    // Lead to Customer
    Route::put('/contact/leadCustomer/{lead}', [ContactController::class, 'leadToCustomer'])->middleware(['can:create-contact']);

    // Note Routes
    Route::get('/customer/{customer}/notes', [ContactNoteController::class, 'index'])->middleware(['can:view-contact']);
    Route::get('/customer/{customer}/proposals/', [ContactController::class, 'getProposals'])->middleware(['can:view-lead']);
    Route::get('/customer/{customer}/invoices/', [ContactController::class, 'getInvoices'])->middleware(['can:view-contact']);
    Route::get('/customer/{customer}/estimates/', [ContactController::class, 'getEstimates'])->middleware(['can:view-contact']);
    Route::get('/customer/{customer}/tasks/', [ContactController::class, 'getTasks'])->middleware(['can:view-lead']);
    Route::get('/customer/{customer}/media/', [ContactController::class, 'getMedia'])->middleware(['can:view-lead']);
    Route::get('/customer/{customer}/reminder/', [ContactController::class, 'getReminder'])->middleware(['can:view-lead']);

    // Contact Title Routes
    Route::get('/contact/title', [ContactTitleController::class, 'index'])->middleware(['can:view-contact']);
    Route::post('/contact/title', [ContactTitleController::class, 'store'])->middleware(['can:create-contact']);
    Route::post('/contact/title/{contactTitle}', [ContactTitleController::class, 'update'])->middleware(['can:update-contact']);
    Route::delete('/contact/title/destroy/{contactTitle}', [ContactTitleController::class, 'destroy'])->middleware(['can:delete-contact']);

    // Bulk Excel Import 
    Route::get('customer/import', [ ContactController::class, 'import'])->middleware(['can:create-contact']);
    Route::post('customer/import', [ ContactController::class, 'importStore'])->middleware(['can:create-contact']);
});

// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE API lead TITLE ROUTES
    Route::get('contact/getTitles', [ContactTitleController::class, 'getContactTitles']);
    Route::post('contact/storeTitle', [ContactTitleController::class, 'storeTitle']);

    // Submit Note from Contact Show Route - Note Section
    Route::post('customer/note', [ContactNoteController::class, 'storeNote']);
    Route::delete('/customer/note/{note}', [ContactNoteController::class, 'destroyNote'])->middleware(['can:delete-contact']);

    // NOTE API LEAD check_email_availability
    Route::post('contact/check_email_availability', [ContactController::class, 'check_email_availability']);
    Route::post('customer/check_user_id', [ContactController::class, 'check_user_id']);
});
?>
