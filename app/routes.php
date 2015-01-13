<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Blade::setContentTags('[[', ']]'); // for variables and all things Blade
Blade::setEscapedContentTags('[[[', ']]]'); // for escaped data

Route::get('/', 'PagesController@index');

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');

Route::resource('users', 'UsersController');
Route::resource('sessions', 'SessionsController');

Route::resource('portfolio', 'PortfolioController');
Route::get('allArtworks', 'PortfolioController@allArtworks');
Route::get('allArtworks/{artworkId}', 'PortfolioController@getArtwork');
Route::delete('image/{imageId}', 'PortfolioController@destroyImage');

Route::post('upload', 'PortfolioController@upload');

Route::get('contact', 'PagesController@contact');

Route::get('admin', function() {
	return 'this is admin page';
})->before('auth');