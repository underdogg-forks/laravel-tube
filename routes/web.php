<?php

Auth::routes(); 

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/home', function(){
	return redirect('/');
});

Route::get('/','HomeController@index');

Route::get('/upload','UploadController@index');

Route::post('/upload','UploadController@store');

Route::get('/search/{title}','VideoController@search');
Route::get('/video/{id}','VideoController@show');

Route::get('like/{video_id}','SocialController@like');
Route::get('dislike/{video_id}','SocialController@dislike');