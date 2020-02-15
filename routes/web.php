<?php
use App\Http\Controllers\PagesController;

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
Route::get('/home','PagesController@index')->name('home');
Route::get('/about-us','PagesController@about')->name('about-us');
Route::get('/join-us','PagesController@join')->name('join-us');
Route::get('/media/TV','PagesController@TV')->name('media-TV');
Route::get('/media/Newspaper','PagesController@Newspaper')->name('media-newspaper');
Route::get('/feedback','PagesController@feedback')->name('feedback');
//Contact
Route::get('/contact','PagesController@contact')->name('contact');
Route::post('/contact','PagesController@SubmitContact')->name('contact-submit');

//Tansik routes
Route::prefix('tansik')->group(function() {
    Route::get('previous-years-edges', 'PagesController@TansikPrevEdges')->name('Tansik-Previous-Edges');
    //Geographic Distribution for AXIOS
    Route::post('gov', 'PagesController@getAdmin')->name('get-admin');
    Route::post('admin', 'PagesController@getDist')->name('get-dist');
    //Faculties' edges for AXIOS
    Route::post('edges', 'PagesController@getEdges')->name('get-edges');

    Route::get('geographic-distribution', 'PagesController@TansikGeoDist')->name('Tansik-Geo-Dist');
    Route::get('geographic-distribution-information', 'PagesController@TansikGeoDistInfo')->name('Tansik-Geo-Dist-Info');
    Route::get('tzalom', 'PagesController@TansikTzalom')->name('Tansik-Tzalom');
    Route::get('stages-information', 'PagesController@TansikStagesInfo')->name('Tansik-Stages-Info');
    Route::get('taqleel-al-eghterab', 'PagesController@TansikReduceAlienation')->name('Tansik-ReduceAlienation');
});

//Privacy Policy
Route::get('/privacy-policy-and-terms','PagesController@privacyPolicy');

//Offline
Route::get('/offline','PagesController@offline')->name('offline');

//TAS Routes
Route::prefix('TAS')->name('tas.')->group(function() {
    Route::get('countdown','TASController@countdown')->name('countdown');
    Route::get('home','TASController@home')->name('home');
    Route::get('buy-ticket-online','TASController@buyTicketOnline')->name('buy-ticket-online');
    Route::get('schedule','TASController@schedule')->name('schedule');
    
    //Tickets Routes
    Route::prefix('tickets')->name('tickets.')->middleware('auth')->group(function() {
        //User Tickets
        Route::get('/','TicketsController@index')->name('view')->middleware('ensureUserHasMobile');
        //Tickets Storage files Routes
        Route::get('image/{ticketSerial}', 'TicketsController@getImage')->name('image');
        Route::get('image/{ticketSerial}/download', 'TicketsController@DownloadImage')->name('download');
        //Get Ticket Image
        //Route::get('image/{user}/{ticket}','TicketsController@getImageLink')->middleware('signed')->name('image');
        //Verify at entry
        Route::get('event-entry','TicketsController@eventEntry')->middleware('role:TAteam');
        Route::post('verify','TicketsController@verify')->middleware('role:TAteam');
        //Register ticket to user
        Route::get('register','TASController@registerTicket')->name('register')->middleware('ensureUserHasMobile');
        Route::post('register','TicketsController@registerToUser');
        Route::post('register-to-mobile','TicketsController@registerToMobile');
    });

    //Payment Routes
    Route::resource('payments','PaymentController')->except(['show'])->middleware('auth');
    Route::prefix('payments')->middleware('auth')->name('payments.')->group(function() {
        
    });
});

//Deployment
Route::post('deploy', 'DeployController@deploy');

//Auth & Facebook Login
Auth::routes();
Route::get('users/{user}/edit','UsersController@edit')->middleware('can:update,user')->name('edit-user');
Route::patch('users/{user}/edit','UsersController@update')->middleware('can:update,user')->name('edit-user');
//Socialite
Route::get('auth/{provider}', 'SocialController@redirectToProvider')->name('ProviderAuth');
Route::get('callback/{provider}', 'SocialController@handleProviderCallback');
