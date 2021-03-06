<?php

Auth::routes(); 

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/',function(){
	return view('welcome');
});

Route::get('/upload','Video\UploadController@index');

Route::post('/upload','Video\UploadController@store');

Route::get('/search/{title}','Video\VideoController@search');
Route::get('/video/{id}','Video\VideoController@show');
Route::get('/delete/{video_id}','Video\VideoController@delete');
Route::post('/edit/','Video\VideoController@edit');

Route::get('like/{video_id}','Social\RatesController@likeVideo');
Route::get('dislike/{video_id}','Social\RatesController@dislikeVideo');
Route::post('/video/','Social\CommentsController@store');
Route::get('/comment/edit/{id}','Social\CommentsController@edit');
Route::post('/comment/edit/','Social\CommentsController@update');
Route::get('/comment/delete/{id}','Social\CommentsController@delete');

Route::get('/comment/like/{id}','Social\RatesController@likeComment');
Route::get('/comment/dislike/{id}','Social\RatesController@dislikeComment');

Route::get('/account','DashboardController@index');
Route::get('/edit/{video_id}','DashboardController@edit');
