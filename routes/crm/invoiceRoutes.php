<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::group(['prefix'=>'/invoice','middleware'=>['auth']], function(){
    Route::get('/', [InvoiceController::class, 'index']);
    Route::get('/email/{invoice}', [InvoiceController::class, 'mailToClient']);
    Route::get('/create/{relation?}/{id?}', [InvoiceController::class, 'create']);
    Route::post('/store', [InvoiceController::class, 'store']);
    Route::post('/confirm_payment', [InvoiceController::class, 'confirm_payment']);
    Route::get('/edit/{invoice}', [InvoiceController::class, 'edit']);
    Route::put('/update/{invoice}', [InvoiceController::class, 'update']);
    Route::delete('/destroy/{invoice}', [InvoiceController::class, 'destroy']);

    Route::get('get_details/{id}', [InvoiceController::class, 'get_pay_details']);
    Route::post('pay', [InvoiceController::class, 'pay_invoice']);

    Route::get('/invoice_pdf/{invoice}', [InvoiceController::class, 'invoice_pdf']);

});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){
    // NOTE TITLE ROUTES
    Route::post('invoice/getProduct', [InvoiceController::class, 'getProduct']);
    Route::post('invoice/getCustomers', [InvoiceController::class, 'getCustomers']);
    Route::post('invoice/getInvoiceProducts', [InvoiceController::class, 'getInvoiceProducts']);
});

?>