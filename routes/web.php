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

Route::get('/','PagesController@index')->name('home');
Route::get('/about-us','PagesController@about')->name('about-us');
Route::get('/join-us','PagesController@join')->name('join-us');
Route::get('/media/TV','PagesController@TV')->name('media-TV');
Route::get('/media/Newspaper','PagesController@Newspaper')->name('media-newspaper');
Route::get('/feedback','PagesController@feedback')->name('feedback');
//Contact
Route::get('/contact','PagesController@contact')->name('contact');
Route::post('/contact','PagesController@SubmitContact')->name('contact-submit');
//Tansik routes
Route::get('/Tansik/Previous-Years-Edges','PagesController@TansikPrevEdges')->name('Tansik-Previous-Edges');
//Geographic Distribution for AXIOS
Route::post('/Tansik/gov','PagesController@getAdmin')->name('get-admin');
Route::post('/Tansik/admin','PagesController@getDist')->name('get-dist');
//Faculties' edges for AXIOS
Route::post('/Tansik/edges','PagesController@getEdges')->name('get-edges');

Route::get('/Tansik/Geographic-Distibution','PagesController@TansikGeoDist')->name('Tansik-Geo-Dist');
Route::get('/Tansik/Geographic-Distibution-Information','PagesController@TansikGeoDistInfo')->name('Tansik-Geo-Dist-Info');
Route::get('/Tansik/Tzalom','PagesController@TansikTzalom')->name('Tansik-Tzalom');
Route::get('/Tansik/Taqleel-al-eghterab','PagesController@TansikReduceAlienation')->name('Tansik-ReduceAlienation');

//Route::get('/','PagesController@index')->name('home');
Route::get('/faculty/getEdges','FacultyController@SaveEdges');
Route::resource('/faculty','FacultyController');

//Deployment
Route::post('deploy', 'DeployController@deploy');