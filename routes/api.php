<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\hsq;

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

Route::post('email','Lsf\AdminController@lsf_send_email');

Route::post('/forgetpwd','Lsf\AdminController@lsf_up_paw');

Route::get('all_stu','zm\AllinfoController@zmSelect');
Route::get('lea_search','zm\SelectController@zmsearch');

Route::any('change','zm\AllinfoController@zmchangetable');
Route::get('/home',function (){
   echo 'Holle';
});
Route::any('/enroll',[hsq\hsq_enroll::class,'add_user']);
Route::any('/login',[hsq\hsq_login::class,'dd']);
Route::any('/hsqsenddemail',[hsq\hsq_enroll::class,'hsq_send_email']);

