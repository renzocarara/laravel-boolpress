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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// tutti queste rotte vengono gestite da un controller (Postcontroller) dedicato e specifico per le API
// creato in una cartella specifica e che si và ad affiancare ai controller della parte Pubblica e della parte Admin
// si trova nella cartella Api (che creo io) sotto app\Http\Controllers
// i metodi associati al controller non ritornano delle views ma dei JSON!!!
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// |  POST     | api/posts               |                     | App\Http\Controllers\Api\PostController@store      | api,auth:api |                                       |
// | GET|HEAD  | api/posts               |                     | App\Http\Controllers\Api\PostController@index      | api,auth:api |                                       |
// | DELETE    | api/posts/{id}          |                     | App\Http\Controllers\Api\PostController@destroy    | api,auth:api |                                       |
// | GET|HEAD  | api/posts/{id}          |                     | App\Http\Controllers\Api\PostController@show       | api,auth:api |                                       |
// | PUT       | api/posts/{id}          |                     | App\Http\Controllers\Api\PostController@update     | api,auth:api |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------|
Route::namespace('Api')->middleware('auth:api')->group(function(){
    Route::get('posts', 'PostController@index'); // restituisce tuttii posts
    Route::get('posts/{id}', 'PostController@show'); // restituisce un singolo post
    Route::post('posts', 'PostController@store'); // salva nel DB un post, ha lo stesso URI di update() e destroy() ma metodo diverso
    Route::put('posts/{id}', 'PostController@update'); // aggiorna un post nel DB, ha lo stesso URI di store() e destroy() ma metodo diverso
    Route::delete('posts/{id}', 'PostController@destroy'); // cancella un post dal DB,ha lo stesso URI di update() e store() ma metodo diverso
});
