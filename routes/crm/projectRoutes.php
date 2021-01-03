<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
Route::group(['prefix'=>'/project','middleware'=>['auth']], function(){

    // SECTION Project Routes
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/create', [ProjectController::class, 'create']);
    Route::post('/store', [ProjectController::class, 'store']);
    Route::get('/edit/{project}', [ProjectController::class, 'edit']);
    Route::put('/update/{project}', [ProjectController::class, 'update']);
    Route::delete('/destroy/{project}', [ProjectController::class, 'destroy']);
    // !SECTION Product Routes

});

?>