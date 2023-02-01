<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@showLandingPage');
Route::get('/home', 'HomeController@showLandingPage');

Route::auth();

/*
Route::get('/', function () {
    SEO::setTitle('خدمات گردشگری ایرانی - شب');
    SEO::setDescription('خدمات گردشگری ایرانی');
    return view('welcome_temp');
});
*/

Route::get('sitemap', 'HomeController@generateSitemap');

//Route::get('/home', 'HomeController@index');

Route::get('houses/show/{house}', 'HouseController@showHouse');

Route::get('houses', ['as' => 'dashboard-houses', 'middleware' => 'auth', 'uses' => 'HouseController@index']);

Route::get('houses/new', ['middleware' => 'auth', 'uses' => 'HouseController@create']);

//Route::get('houses/new_tmp', ['middleware' => 'auth', 'uses' => 'HouseController@create_tmp']);

Route::post('houses/new', ['middleware' => 'auth','uses' => 'HouseController@store']);

//Route::post('houses/new_tmp', ['middleware' => 'auth','uses' => 'HouseController@store_tmp']);

Route::get('houses/edit/{id}', ['middleware' => 'auth','uses' => 'HouseController@edit']);

//Route::get('houses/edit_tmp/{id}', ['middleware' => 'auth','uses' => 'HouseController@edit_tmp']);

Route::post('houses/edit/{id}', ['middleware' => 'auth','uses' => 'HouseController@update']);

//Route::post('houses/edit_tmp/{id}', ['middleware' => 'auth','uses' => 'HouseController@updateHouse']);

Route::get('houses/delete/{id}', ['middleware' => 'auth','uses' => 'HouseController@destroy']);

Route::get('users/edit', ['as' => 'profile', 'middleware' => 'auth','uses' => 'UserController@edit']);

Route::post('users/edit', ['middleware' => 'auth','uses' => 'UserController@update']);

Route::post('users/upload_pic', ['middleware' => 'auth','uses' => 'UserController@updatePicture']);

Route::get('users/security', ['as' => 'security', 'middleware' => 'auth','uses' => 'UserController@changePassword']);

Route::post('users/security/password', ['middleware' => 'auth','uses' => 'UserController@updatePassword']);

Route::get('dashboard', ['as' => 'dashboard', 'middleware' => 'auth','uses' => 'UserController@showDashboard']);

Route::get('my_reservations', ['middleware' => 'auth','uses' => 'UserController@showMyReservations']);

Route::get('trips', ['as' => 'trips', 'middleware' => 'auth','uses' => 'UserController@showTrips']);

Route::get('search', 'SearchController@showSearch');

Route::get('search/city/{city}', 'SearchController@searchCity');

Route::get('search/province/{province}', 'SearchController@searchProvince');

Route::get('search/province/{province}/city/{city}', 'SearchController@searchProvinceCity');

Route::get('search/tag/{tag}', 'SearchController@searchTag');

Route::post('search', 'SearchController@search');

Route::post('search/get', 'SearchController@getHouses');

Route::get('policies', 'HomeController@showPolicies');

Route::get('careers' , ['as' => 'careers', 'uses' => 'HomeController@showCareers']);

Route::post('careers' , 'HomeController@submitCareerForm');

Route::get('about'   , 'HomeController@showAbout');

Route::get('terms'   , 'HomeController@showTerms');

Route::get('refund'  , 'HomeController@showRefund');

Route::get('complaints', 'HomeController@showComplaints');

Route::get('help/host', 'HomeController@showHelpHost');

Route::get('help/guest', 'HomeController@showHelpGuest');

Route::get('help/trust', 'HomeController@showHelpTrust');

Route::post('houses/reserve/{id}', ['middleware' => 'auth','uses' => 'ReservationController@reserve']);

Route::post('houses/reservebytel/{id}', ['middleware' => 'auth','uses' => 'ReservationController@reserveByTel']);

Route::get('payment/zarinpal/verify', ['uses' => 'HouseController@verify_payment']);

Route::get('houses/reserve/{id}', ['middleware' => 'auth','uses' => 'InvoiceController@showPayment']);

Route::get('guide/roads', 'HomeController@showGuideRoads');

Route::get('guide/village', 'HomeController@showGuideVillage');

Route::get('guide/seasonal', 'HomeController@showGuideSeasonal');

Route::get('guide/historical', 'HomeController@showGuideHistorical');

Route::post('subscribe/newsletter', 'HomeController@subscribeNewsletter');

//Route::get('admins/houses', 'HouseController@showAllHouses');

Route::get('/statistics', ['middleware' => 'auth.basic', 'uses' => 'HomeController@showStatistics']);

Route::post('/houses/photos/add/{id}'   , ['middleware' => 'auth','uses' => 'HouseController@addHousePhoto']);

Route::post('/houses/photos/remove/{id}', ['middleware' => 'auth','uses' => 'HouseController@removeHousePhoto']);

Route::post('/photos/{id}/cover'        , ['middleware' => 'auth','uses' => 'HouseController@setCoverPhoto']);

Route::get('/reservations/{id}/show', ['middleware' => 'auth','uses' => 'ReservationController@showReservation']);

Route::get('/invoices/{id}/show'    , ['middleware' => 'auth','uses' => 'InvoiceController@showInvoice']);

Route::get('/invoices/{id}/pay'    , ['middleware' => 'auth','uses' => 'InvoiceController@payInvoice']);
//Route::get('/invoices/{id}/pay'    , ['uses' => 'ReservationController@payInvoice']);

Route::post('/messaging/send', ['middleware' => 'auth','uses' => 'MessageController@sendMessage']);

Route::post('/messaging/get', ['middleware' => 'auth','uses' => 'MessageController@getMessages']);

Route::post('/messaging/seen', ['middleware' => 'auth','uses' => 'MessageController@markAsSeen']);

Route::get('/payments/{trackid}/show'         , ['middleware' => 'auth','uses' => 'PaymentController@showChargeCredit']);

Route::post('/payments/charge', ['middleware' => 'auth','uses' => 'PaymentController@chargeCredit']);

Route::get('password/reset/sms/{token}', 'Auth\PasswordController@showResetFormMobile');

Route::post('password/reset/sms', 'Auth\PasswordController@resetMobile');

Route::get('password/sms', 'Auth\PasswordController@showLinkRequestFormMobile');

Route::post('password/sms', ['middleware' => ['throttle:5,5'], 'uses' => 'Auth\PasswordController@sendResetLinkSMS']);

Route::get('sms/receive', ['uses' => 'HomeController@smsHandler']);

Route::post('/houses/populars', 'HouseController@getMostPopulars');

Route::post('/houses/{id}/similars', 'Api\HouseController@getSimilars');

Route::post('/houses/{id}/photos', 'HouseController@getHousePhotos');

Route::post('searchbox', 'SearchController@searchBox');

Route::get('/blog_posts', 'HomeController@getBlogPosts');

Route::post('/houses/{id}/comments', 'HouseController@getHouseComments');

Route::post('/houses/{id}/reviews', 'ReviewController@getHouseReviews');

Route::post('/reservations/{id}/accept', ['middleware' => 'auth', 'uses' => 'ReservationController@acceptReservation']);

Route::post('/reservations/{id}/reject', ['middleware' => 'auth', 'uses' => 'ReservationController@rejectReservation']);

Route::post('/reservations/{id}/cancel', ['middleware' => 'auth', 'uses' => 'ReservationController@cancelReservation']);

Route::get('/reservations/{id}/reviews/new', ['middleware' => 'auth', 'uses' => 'ReviewController@create']);
Route::post('/reservations/{id}/reviews/store', ['middleware' => 'auth', 'uses' => 'ReviewController@store']);

Route::get('/reviews/{id}/edit', ['middleware' => 'auth', 'uses' => 'ReviewController@edit']);
Route::post('/reviews/{id}/update', ['middleware' => 'auth', 'uses' => 'ReviewController@update']);

Route::get('/payments', ['middleware' => 'auth', 'uses' => 'PaymentController@index']);

Route::post('/calendars/show', 'CalendarController@getCalendar');

Route::post('/houses/{id}/statistics', 'HouseStatisticsController@getHouseStatistics');

Route::get('/calendars/disable/{from}/{to}', ['middleware' => 'auth', 'uses' => 'CalendarController@disableCalendarInterval']);

Route::get('/bookmarks', ['middleware' => 'auth', 'uses' => 'BookmarkController@index']);
Route::post('/houses/{id}/bookmark', ['middleware' => 'auth', 'uses' => 'BookmarkController@store']);
Route::post('/bookmarks/{id}/delete', ['middleware' => 'auth', 'uses' => 'BookmarkController@destroy']);

Route::post('/houses/{id}/price', 'InvoiceController@getTotalPrice');

Route::group(['prefix' => 'api/v1', 'middleware' => 'throttle'], function () {
    Route::post('/login', 'Api\Auth\AuthController@getLogin');
    Route::post('/logout', 'Api\Auth\AuthController@getLogout');
    Route::post('/register', 'Api\Auth\AuthController@getRegister');
    Route::post('/send_code',['uses' => 'Auth\AuthController@sendCode']);
    Route::post('/verify_code', 'Auth\AuthController@verifyCode');
    Route::get('/test', 'HouseController@test');

    Route::post('searchbox', 'Api\HouseController@searchBox');
    Route::post('/search', 'Api\HouseController@search');
    //Route::get('/payments/verify', 'Api\ReservationController@verifyPayment');

    Route::get('/payments/{trackid}/verify/app', 'Api\ReservationController@verifyPayment');
    Route::get('/payments/{trackid}/show', 'Api\ReservationController@showChargeCredit');
    Route::post('/password/sms', ['middleware' => ['throttle:5,5'], 'uses' => 'Auth\PasswordController@sendResetLinkSMS']);

    Route::post('/houses/populars', 'Api\HouseController@getMostPopulars');
    Route::post('/houses/{id}/similars', 'Api\HouseController@getSimilars');
    Route::post('/cities', 'Api\HouseController@getCities');
    
    Route::any('/payments/{trackid}/verify', ['uses' => 'PaymentController@verifyChargePayment']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/houses/get/{id}', 'Api\HouseController@getHouse');
        Route::post('/houses/photos/{id}', 'Api\HouseController@getHousePhotos');
        Route::post('/houses/owner/{id}', 'Api\HouseController@getHouseOwner');
        Route::post('/houses/new', 'Api\HouseController@store');
        Route::post('/houses/edit/{id}', 'Api\HouseController@update');
        Route::post('/houses/delete/{id}', 'Api\HouseController@destroy');
        Route::post('/houses/photos/add/{id}', 'Api\HouseController@addHousePhoto');
        Route::post('/houses/photos/remove/{id}', 'Api\HouseController@removeHousePhoto');
        Route::post('/users/profile/get/{id}', 'Api\UserController@getProfile');
        Route::post('/users/changepic', 'Api\UserController@updatePicture');
        Route::post('/houses/reservebytel/{id}', 'Api\HouseController@reserveByTel');
        Route::post('/houses', 'Api\UserController@getHouses');
        Route::post('/houses/disable/{id}', 'Api\HouseController@disableHouse');
        Route::post('/trips', 'Api\UserController@getTrips');
        Route::post('/bookmarks', 'Api\HouseController@getBookmarks');
        Route::post('/bookmarks/set/{id}', 'Api\HouseController@setBookmark');

        Route::post('/myreservations', 'Api\UserController@showMyReservations');
        Route::post('/users/update/{id}', 'Api\UserController@update');
        Route::post('/users/security/password', 'Api\UserController@updatePassword');
        Route::post('/send_message', 'Api\UserController@sendMessage');
        Route::post('/get_messages', 'Api\UserController@getMessages');
        Route::post('/messages/seen', 'Api\UserController@markAsSeen');

        Route::post('/calendars/add', 'Api\CalendarController@addCalendar');
        Route::post('/calendars/{id}/edit', 'Api\CalendarController@editCalendar');
        Route::post('/calendars/show', 'Api\CalendarController@getCalendar');
        Route::post('/reservations/{id}/show', 'Api\ReservationController@showReservation');
        Route::post('/reservations/{id}/accept', 'Api\ReservationController@acceptReservation');
        Route::post('/reservations/{id}/reject', 'Api\ReservationController@rejectReservationByHost');
        Route::post('/invoices/preview', 'Api\ReservationController@showProformaInvoice');
        Route::post('/invoices/show', 'Api\ReservationController@showInvoice');
        Route::post('/invoices/{id}/pay', 'Api\ReservationController@payInvoice');
        Route::post('/users/charge', 'Api\ReservationController@chargeCredit');
        Route::post('/houses/{id}/reserve', 'Api\ReservationController@reserve');
        Route::post('/users/feedback', 'Api\UserController@sendFeedback');
        Route::post('/users/pushtoken', 'Api\UserController@registerToPushNotification');
        Route::post('/photos/{id}/cover', 'Api\HouseController@setCoverPhoto');

        Route::post('/houses/{id}/tag', 'Api\HouseController@addTag');
        Route::post('/houses/{id}/untag', 'Api\HouseController@removeTag');
        Route::post('/houses/{id}/reserve/preview', 'Api\ReservationController@showReservePreview');
        Route::post('/houses/{id}/comments', 'Api\HouseController@getHouseComments');
    });
});
