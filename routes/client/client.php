<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\MediaController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\EstimateController;
use App\Http\Controllers\Client\ProposalController;
Route::group(['prefix' => 'client', 'middleware'=>'isClient'], function () {

  Route::get('home', [HomeController::class, 'home']);
  Route::post('logout', [HomeController::class, 'logout']);

  Route::get('profile', [HomeController::class, 'profile']);
  Route::post('profile', [HomeController::class, 'profileUpdate']);
  Route::post('profile/update_password', [HomeController::class, 'updatePassword']);
   
  Route::get('proposals', [ProposalController::class, 'index']);
  Route::get('invoices', [InvoiceController::class, 'index']);
  Route::get('estimates', [EstimateController::class, 'index']);
  Route::get('estimate/toInvoice/{estimate}/{token}', [EstimateController::class, 'convertToInvoice']);
  Route::get('media', [MediaController::class, 'index']);
  
  Route::get('invoice/get_details/{id}', [InvoiceController::class, 'get_pay_details']);
  Route::post('invoice/pay', [InvoiceController::class, 'pay_invoice']);
});

