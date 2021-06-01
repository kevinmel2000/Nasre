<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Health\FormProductController;
use App\Http\Controllers\Health\ProductController;

// Route::get('get-state-list','FeLookupLocationController@getStateList');
// Route::get('get-city-list','FeLookupLocationController@getCityList');
// Route::get('get-city-all','MasterController@getCityList');
// Route::get('get-cedingbroker-autocode','CedingBrokerController@generatecode')->name('cedingbroker.getcode');
// Route::get('get-koc-autocode','KocController@generatecode')->name('koc.getcode');
// Route::get('get-cob-autocode','MasterController@generatecodecob')->name('cob.getcode');
// Route::get('get-ocp-autocode','MasterController@generatecodeocp')->name('ocp.getcode');
// Route::get('get-state-all','StateController@getState')->name('state.getall');

Route::get('/data-maintenance/product', [ProductController::class, 'indexproduct']);
Route::get('/data-maintenance/formProduct', [FormProductController::class, 'indexformproduct']);
Route::group(['prefix'=>'/data-maintenance','middleware'=>['auth']], function(){
    // Route::get('/product', [MasterController::class, 'indexproduct'])->middleware(['can:create-product']);
    // Route::post('/country/store', [MasterController::class, 'storecountry']);
    // Route::put('country/{country}', [MasterController::class, 'updatecountry']);
    // Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry']);
});
?>
