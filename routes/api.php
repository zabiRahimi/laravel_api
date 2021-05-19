<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->namespace('App\Http\Controllers\Api\v1')->group(function(){

    //get collectionPage data
  Route::get('/courses','CourseController@index');
 
    //get singlePage data
  Route::get('/courses/{course}','CourseController@single');

  Route::post('/login','UserController@login');
  Route::post('/register','UserController@register');

  Route::post('/loginAdmin','AdminController@login');
  Route::post('/registerAdmin','AdminController@register');

  Route::get('passwordAdmin/reset/{token}', 'ResetPasswordAPIController@showResetForm');
  Route::post('passwordAdmin/reset', 'AdminResetPasswordController@reset');
  Route::post('passwordAdmin/email', 'AdminForgotPasswordController@sendResetLinkEmail');
  // Route::get('/user',function(){
  //   return 'ok';
  // });
  Route::middleware('auth:api')->group(function(){
    Route::get('/user',function(){
      return auth()->user();
    });
  });

  Route::middleware('auth:admin-api')->group(function(){
    // Route::get('/zabi','ZabiController@zabi');
    Route::get('/zabi',function(){
      return auth()->guard('admin-api')->user();
    });
  });
  
 });

