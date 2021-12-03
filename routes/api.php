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


// メモ一覧表示
Route::get('/memos', 'MemoController@index');
// メモ新規作成
Route::post('/memos/memo','MemoController@store');
// 別メモ作成
Route::post('/memos/memo/make', 'MemoController@create');
// メモ詳細表示
Route::get('/memos/memo/{memo_id}', 'MemoController@show');
// メモ名編集
Route::put('/memos/memo/{memo_id}','MemoController@update');
// メモ削除
Route::delete('/memos/memo/{memo_id}','MemoController@destroy');
// メモ項目追加
Route::post('/memos/memo/{memo_id}','MemoItemController@store');
// メモ項目編集
Route::put('/memos/memo/{memo_id}/item','MemoItemController@update');
// メモ項目削除
Route::delete('/memos/memo/item/{item_id}','MemoItemController@destroy');
