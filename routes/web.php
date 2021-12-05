<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//全てのURLでapp.blade.phpが表示されるようにする
Route::get('/comimemo/{any}', function() {
     return view('app');
 })->where('any', '.*');
