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
  // Route::get('/user',function(){
  //   return 'ok';
  // });
  Route::middleware('auth:api')->group(function(){
    Route::get('/user',function(){
      return 'okw';
    });
  });
  
 });

