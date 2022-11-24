<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/correcting','Lsf\AdminController@lsf_correct');

Route::get('/test_vi','Lsf\TestController@vi');

//Route::get('/test/code','Lsf\TestController@create_email');
Route::get('/test_email','Lsf\TestController@sendEmail');

Route::post('email','Lsf\AdminController@lsf_send_email');

Route::post('/forgetpwd','Lsf\AdminController@lsf_up_paw');

Route::post('login','Lsf\TestController@creat_token');

//Route::post('/correcting','Lsf\AdminController@lsf_get_token');
