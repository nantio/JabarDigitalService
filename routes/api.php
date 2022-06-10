<?php

use Illuminate\Http\Request;

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
//1. Authentication App (Task1_1 - Task1_3)
Route::get('task1_1', 'AuthApp@task1_1');    
Route::post('task1_2', 'AuthApp@task1_2');   
Route::post('task1_3', 'AuthApp@task1_3');   

//2. Fetch App
Route::get('task3', 'FetchApp@task3');
Route::get('task4', 'FetchApp@task4');


//|--------------------------------------------------------------------------
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
