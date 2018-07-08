<?php

Auth::routes(); 

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/home', function(){
	return redirect('/');
});

Route::get('/',function(){
	return view('welcome');
});

Route::get('/upload','Video\UploadController@index');

Route::post('/upload','Video\UploadController@store');

Route::get('/search/{title}','Video\VideoController@search');
Route::get('/video/{id}','Video\VideoController@show');
Route::post('/edit/','Video\VideoController@edit');

Route::get('like/{video_id}','Social\RatesController@like');
Route::get('dislike/{video_id}','Social\RatesController@dislike');

Route::get('/account','DashboardController@index');
Route::get('/edit/{video_id}','DashboardController@edit');
Route::get('/delete/{video_id}','DashboardController@delete');