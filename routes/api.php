<?php

use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login/', 'AuthController@login');
Route::post('logout/', 'AuthController@logout');

Route::middleware(['auth:api'])->group(function () {

    Route::post('admin/import/', 'UserController@store');
    Route::post('users/search/', 'UserController@search');
    
});
