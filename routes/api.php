<?php

use App\Http\Controllers\Api\Admin\BlockUserController;
use App\Http\Controllers\Api\Admin\ResetUserPasswordController;
use App\Http\Controllers\Api\Admin\RolePermissionsController;
use App\Http\Controllers\Api\Admin\RoleUserController;
use App\Http\Controllers\Api\Admin\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\PermissionsController;
use App\Http\Controllers\Api\Admin\SyncPermissionController;
use App\Http\Controllers\Api\Admin\RolesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:sanctum'], function() {
    //admin
    Route::group(['prefix' => 'admin'], function() {
        Route::get('sync-permissions', SyncPermissionController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::resource('roles', RolesController::class);
        Route::get('role-permissions/{roleId}', [RolePermissionsController::class, 'index']);
        Route::put('role-permissions/update-role-permissions/{roleId}', [RolePermissionsController::class, 'update']);
        Route::delete('role-permissions/revoke-role-permission/{permissionId}/{roleId}', [RolePermissionsController::class, 'destroy']);

        Route::resource('users', UsersController::class);

        Route::put('recover-user-password/{user_id}', [ResetUserPasswordController::class, 'update']);
        Route::put('block-user/{user_id}', [BlockUserController::class, 'update']);

        Route::post('role-users', [RoleUserController::class, 'store']);
        Route::delete('role-users/{user_id}/{role_id}', [RoleUserController::class, 'destroy']);
    });

    //app
    Route::group(['prefix' => 'app'], function() {

    });
});
