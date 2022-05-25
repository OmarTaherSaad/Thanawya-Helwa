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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'PagesController@index')->name('home');
Route::get('/home', 'PagesController@index')->name('home2');
Route::get('/about-us', 'PagesController@about')->name('about-us');
Route::get('get-members', 'PagesController@get_members');
Route::get('/join-us', 'PagesController@join')->name('join-us');
Route::get('/media/tv', 'PagesController@TV')->name('media.tv');
Route::get('/media/newspaper', 'PagesController@Newspaper')->name('media.newspaper');
Route::get('/feedback', 'PagesController@feedback')->name('feedback');
//Contact
Route::get('/contact', 'PagesController@contact')->name('contact');
Route::post('/contact', 'PagesController@SubmitContact')->name('contact.submit');

//Tansik routes
Route::prefix('tansik')->name('tansik.')->group(function () {
    Route::get('previous-years-edges', 'PagesController@TansikPrevEdges')->name('previous_edges');
    //Geographic Distribution for AXIOS
    Route::post('gov', 'PagesController@getAdmin')->name('get_admin');
    Route::post('admin', 'PagesController@getDist')->name('get_dist');
    //Faculties' edges for AXIOS
    Route::post('edges', 'PagesController@getEdges')->name('get_edges');

    Route::get('geographic-distribution', 'PagesController@TansikGeoDist')->name('geo_dist');
    Route::get('geographic-distribution-information', 'PagesController@TansikGeoDistInfo')->name('geo_dist_info');
    Route::get('tzalom', 'PagesController@TansikTzalom')->name('tzalom');
    Route::get('stages-information', 'PagesController@TansikStagesInfo')->name('stages_info');
    Route::get('taqleel-al-eghterab', 'PagesController@TansikReduceAlienation')->name('reduce_alienation');
});

//Privacy Policy
Route::get('/privacy-policy-and-terms', 'PagesController@privacyPolicy');

//Offline
Route::get('/offline', 'PagesController@offline')->name('offline');

//Auth & Facebook Login
Auth::routes();
//Notifications
Route::get('user/{user}/notifications', 'UsersController@notifications')->name('users.notifications');
//Mark Notifications as read via AXIOS
Route::post('user/{user}/notifications/mark-as-read', 'UsersController@markNotificationsAsRead')->name('users.notifications.mark-as-read');

//Users
Route::resource('users', 'UsersController');
//Socialite
Route::get('auth/{provider}', 'SocialController@redirectToProvider')->name('ProviderAuth');
Route::get('callback/{provider}', 'SocialController@handleProviderCallback');

Route::prefix('team')->group(function () {
    //Members
    Route::resource('members', 'MemberController')->middleware(['auth', 'role:THteam']);
    Route::post('members/upload', 'MemberController@store_image')->name('members.save_image');
    //Tags
    Route::resource('tags', 'TagController');
    //Posts
    Route::resource('posts', 'PostController');
    Route::prefix('posts')->name('posts.')->middleware('auth')->group(function () {
        Route::get('member/{member}', 'PostController@view_user_posts')->name('view-member-posts');
        Route::post('{post}/force-delete', 'PostController@forceDelete')->name('forceDelete');
        Route::post('{post}/restore', 'PostController@restore')->name('restore');
        //Posts Approval
        Route::get('approve-post/{post}', 'PostController@approve_post')->name('approve');
        Route::post('approve-post/{post}', 'PostController@approve');
    });

    //Tansik Data
    Route::prefix('tansik')->name('tansik.')->middleware(['auth', 'role:THteam'])->group(function () {
        Route::get('edges/edit/{FacultyEdge?}', 'TansikController@edit')->name('edges.edit');
        Route::get('edges/confirm/{FacultyEdge?}', 'TansikController@confirm_view')->name('edges.confirm_view');
        Route::get('edges/confirm2/{FacultyEdge?}', 'TansikController@confirm2_view')->name('edges.confirm_view2');
        Route::patch('edges/{facultyEdge}/confirm', 'TansikController@confirm')->name('edges.confirm');
        Route::patch('edges/{facultyEdge}/confirm2', 'TansikController@confirm2')->name('edges.confirm2');
        Route::patch('edges/{facultyEdge}', 'TansikController@update')->name('edges.update');
        Route::get('edges', 'TansikController@index')->name('edges.index');
    });


    //Admin Board
    Route::prefix('admins')->name('admins.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('all-post', 'PostController@all_post_for_admin')->name('all-posts');
        Route::get('edges', 'TansikController@all_member_counts')->name('all-edges');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');

        //Email Selector & Sender
        Route::get('email-sender', 'UsersController@email_sender')->name('email-sender');
        Route::post('email-sender', 'UsersController@email_sender_action')->name('email-sender-action');
    });
});
//Quizzes
Route::prefix('quiz')->name('quiz.')->group(function () {
    Route::get('{quiz}/revise', 'QuizController@revise_view')->name('revise');
});
Route::resource('quiz', 'QuizController');

Route::resource('ministryExam', 'MinistryExamController');
Route::get('ministryExam/{ministryExam}/download', 'MinistryExamController@download')->name('ministryExam.download');

//TAS Routes
/*
Route::prefix('TAS')->name('tas.')->group(function() {
    Route::get('countdown','TASController@countdown')->name('countdown');
    Route::get('home','TASController@home')->name('home');
    Route::get('countdown','TASController@countdown')->name('countdown');
    Route::get('buy-ticket-online','TASController@buyTicketOnline')->name('buy-ticket-online');
    Route::get('schedule','TASController@schedule')->name('schedule');

    //Tickets Routes
    Route::prefix('tickets')->name('tickets.')->middleware('auth')->group(function() {
        //User Tickets
        Route::get('/','TicketsController@index')->name('view')->middleware('ensureUserHasMobile');
        //Tickets Storage files Routes
        Route::get('image/{ticketSerial}', 'TicketsController@getImage')->name('image');
        Route::get('image/{ticketSerial}/download', 'TicketsController@DownloadImage')->name('download');
        Route::get('image/download/{user}', 'TicketsController@DownloadAll')->name('downloadAll');
        //Get Ticket Image
        //Route::get('image/{user}/{ticket}','TicketsController@getImageLink')->middleware('signed')->name('image');
        //Verify at entry
        Route::get('event-entry','TicketsController@eventEntry')->middleware('role:THteam')->name('eventEntry');
        Route::post('verify','TicketsController@verify')->middleware('role:THteam');
        //Ticket Entered
        Route::post('enter','TicketsController@eventEntered')->middleware('role:THteam');
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
 */
