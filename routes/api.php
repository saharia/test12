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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::group(['middleware' => ['auth:api']], function() {
  
  Route::get('/song', 'Api\SongController@getAll');

  Route::post('/song/save', 'Api\SongController@save');
  Route::post('/song/{id}/update', 'Api\SongController@update');
  Route::delete('/song/{id}', 'Api\SongController@delete');


   Route::get('/artist', 'Api\ArtistController@getAll');

  Route::post('/artist/save', 'Api\ArtistController@save');
  Route::post('/artist/{id}/update', 'Api\ArtistController@update');
  Route::delete('/artist/{id}', 'Api\ArtistController@delete');


Route::get('/albums', 'Api\AlbumsController@getAll');
   Route::post('/albums/save', 'Api\AlbumsController@save');
  Route::post('/albums/{id}/update', 'Api\AlbumsController@update');
  Route::delete('/albums/{id}', 'Api\AlbumsController@delete');




/*
  Route::get('/product', 'Api\ProductController@getAll');

  Route::post('/category/save', 'Api\CategoryController@save');

  Route::post('/product/save', 'Api\ProductController@save');*/

  
});