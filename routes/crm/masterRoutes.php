<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductGroupController;
Route::group(['prefix'=>'/master-data','middleware'=>['auth']], function(){

    // SECTION Product Group Routes
    Route::get('/country', [MasterController::class, 'indexcountry']);
    Route::post('/country/store', [MasterController::class, 'storecountry']);
    // Route::put('/productgroup/{productGroup}', [ProductGroupController::class, 'update']);
    // Route::delete('/productgroup/destroy/{productGroup}', [ProductGroupController::class, 'destroy']);
    // !SECTION Product Group Routes

    // SECTION Product Routes
    // Route::get('/', [ProductController::class, 'index'])->middleware(['can:view-product']);
    // Route::get('/create', [ProductController::class, 'create'])->middleware(['can:create-product']);
    // Route::post('/store', [ProductController::class, 'store'])->middleware(['can:create-product']);
    // Route::get('/edit/{product}', [ProductController::class, 'edit'])->middleware(['can:view-product']);
    // Route::put('/update/{product}', [ProductController::class, 'update'])->middleware(['can:update-product']);
    // Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->middleware(['can:delete-product']);
    
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    // !SECTION Product Routes


});
?>