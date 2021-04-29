<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\PermissionsController;

Route::group(['prefix'=>'/user','middleware'=>['auth']], function(){

    // user routes
    Route::get('/', [ UserController::class, 'index'])->middleware(['can:view-user']);
    Route::post('/store', [ UserController::class, 'store'])->middleware(['can:create-user']);
    Route::put('/{user}', [ UserController::class, 'update'])->middleware(['can:update-user']);
    Route::delete('/destroy/{user}', [ UserController::class, 'destroy'])->middleware(['can:delete-user']);
    
    // Bulk Excel Import Users
    Route::get('/import', [ UserController::class, 'import'])->middleware(['can:create-user']);
    Route::post('/import', [ UserController::class, 'importStore'])->middleware(['can:create-user']);

    // Profile Routes - User's own routes - no need of permissions
    Route::get('/profile', [ UserController::class, 'userProfile'])->middleware(['password.confirm']);
    Route::put('/profile/{user}', [ UserController::class, 'updatePorfile']);
    Route::put('/profile/update_password/{user}', [ UserController::class, 'updatePassword']);


    // Role Permission routes
    Route::get('/role', [ RoleController::class, 'index'])->middleware(['can:view-role']);
    Route::post('/role/store', [ RoleController::class, 'store'])->middleware(['can:create-role']);
    Route::put('/role/{role}',  [ RoleController::class, 'update'])->middleware(['can:update-role']);
    Route::put('/role/default/{role}', [RoleController::class, 'default'])->middleware(['can:update-role']);
    Route::delete('/role/destroy/{role}', [RoleController::class, 'destroy'])->middleware(['can:delete-role']);
    
    // Admin Protected Routes
    Route::group(['middleware'=>'isAdmin'], function(){
        Route::get('/role/permissions/', [PermissionsController::class, 'index']);
        Route::post('/role/permissions/', [PermissionsController::class, 'store'])->name('post_role_permissions');
        Route::put('/role/permissions/{module}', [PermissionsController::class, 'update']);
    
        Route::post('/role/permissions/roleid', [PermissionsController::class, 'permissionsByUser']);
        Route::get('/role/permissions/roleid/{role?}', [PermissionsController::class, 'getPermissionsByUser'])->name('permissions_role_id');
    });
    
});
?>