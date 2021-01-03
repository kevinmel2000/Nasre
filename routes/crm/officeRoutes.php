<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Office\SMTPController;
use App\Http\Controllers\Office\TaxRateController;
use App\Http\Controllers\Office\WebFormController;
use App\Http\Controllers\Office\CurrencyController;
use App\Http\Controllers\Office\FormFieldController;
use App\Http\Controllers\Office\PaymentModeController;
use App\Http\Controllers\Office\TechSettingsController;
use App\Http\Controllers\Office\GeneralSettingsController;

Route::group(['prefix'=>'/office','middleware'=>['auth']], function(){

    // SECTION TaxRate Routes
    Route::get('/taxrate', [TaxRateController::class, 'index'])->middleware('can:view-office');
    Route::post('/taxrate/store', [TaxRateController::class, 'store'])->middleware('can:create-office');
    Route::put('/taxrate/{taxRate}', [TaxRateController::class, 'update'])->middleware('can:update-office');
    Route::delete('/taxrate/destroy/{taxRate}', [TaxRateController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION TaxRate Routes

    // SECTION Currency Routes
    Route::get('/currency', [CurrencyController::class, 'index'])->middleware('can:view-office');
    Route::post('/currency/store', [CurrencyController::class, 'store'])->middleware('can:create-office');
    Route::put('/currency/{currency}', [CurrencyController::class, 'update'])->middleware('can:update-office');
    Route::put('/currency/base/{currency}', [CurrencyController::class, 'baseUpdate'])->middleware('can:update-office');
    Route::delete('/currency/destroy/{currency}', [CurrencyController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION Currency Routes

    // SECTION PaymentMode Routes
    Route::get('/paymentmode', [PaymentModeController::class, 'index'])->middleware('can:view-office');
    Route::post('/paymentmode/store', [PaymentModeController::class, 'store'])->middleware('can:create-office');
    Route::put('/paymentmode/{paymentMode}', [PaymentModeController::class, 'update'])->middleware('can:update-office');
    Route::delete('/paymentmode/destroy/{paymentMode}', [PaymentModeController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION PaymentMode Routes

    // SECTION Tech Setting Routes
    Route::get('/general_setting', [GeneralSettingsController::class, 'index'])->middleware(['can:view-office', 'password.confirm']);
    Route::post('/general_setting/logo/store', [GeneralSettingsController::class, 'store'])->middleware('can:create-office');
    Route::post('/general_setting/store', [GeneralSettingsController::class, 'storeDetails'])->middleware('can:create-office');
    Route::post('/general_setting/terms', [GeneralSettingsController::class, 'terms'])->middleware('can:create-office');
    Route::put('/general_setting/terms/{terms}', [GeneralSettingsController::class, 'termsUpdate'])->middleware('can:update-office');
    Route::put('/general_setting/{company_name}', [GeneralSettingsController::class, 'updateDetails'])->middleware('can:create-office');
    Route::put('/general_setting/logo/{logo}', [GeneralSettingsController::class, 'update'])->middleware('can:update-office');
    Route::get('/tech_setting', [TechSettingsController::class, 'index'])->middleware(['can:view-office', 'password.confirm']);
    // !SECTION Tech Setting Routes

    // SECTION FORM FIELDS Routes
    Route::get('/formfield', [FormFieldController::class, 'index'])->middleware(['can:view-office']);
    Route::post('/formfield/store', [FormFieldController::class, 'store'])->middleware('can:create-office');
    Route::put('/formfield/{formfield}', [FormFieldController::class, 'update'])->middleware('can:update-office');
    Route::delete('/formfield/destroy/{formfield}', [FormFieldController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION FORM FIELDS Routes

    // SECTION Web To Lead Forms Routes
    Route::get('/create_form', [WebFormController::class, 'create'])->middleware(['can:create-office']);
    Route::get('/web_forms', [WebFormController::class, 'index'])->middleware(['can:view-office']);
    Route::post('/web_form/store', [WebFormController::class, 'store'])->middleware('can:create-office');
    Route::put('/web_form/{web_form}', [WebFormController::class, 'update'])->middleware('can:update-office');
    Route::delete('/web_form/destroy/{web_form}', [WebFormController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION Web To Lead Forms Routes

  
    // SECTION SMTP Routes
    Route::post('/tech_setting/smtp/store', [SMTPController::class, 'store'])->middleware('can:create-office');
    Route::put('/tech_setting/smtp/{smtp}', [SMTPController::class, 'update'])->middleware('can:update-office');
    Route::delete('/tech_setting/smtp/destroy/{smtp}', [SMTPController::class, 'destroy'])->middleware('can:delete-office');
    // !SECTION SMTP Routes

});

// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    Route::get('office/formfield/{id}', [FormFieldController::class, 'getFormField']);
});


?>