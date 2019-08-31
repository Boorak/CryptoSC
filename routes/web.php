<?php

Auth::routes();
/*
 |--------------------------------------------------------
 |                Home Controller Routes
 |--------------------------------------------------------
 */
Route::get('/', 'HomeController@index')->name('home');

/*
 |--------------------------------------------------------
 |                Thread Controller Routes
 |--------------------------------------------------------
 */
Route::get('threads', 'ThreadController@index')->name('threads');
Route::get('threads/create', 'ThreadController@create')->name('threads.create');

Route::post('threads/{analysisId}', 'ThreadController@store')->name('threads.store')->middleware('must-be-confirmed');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
/*
 |--------------------------------------------------------
 |                Replies Controller Routes
 |--------------------------------------------------------
 */
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
/*
 |--------------------------------------------------------
 |               Best Replies Controller Routes
 |--------------------------------------------------------
 */
Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');
/*
 |--------------------------------------------------------
 |                Favorites Controller Routes
 |--------------------------------------------------------
 */
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
/*
 |--------------------------------------------------------
 |                Profiles Controller Routes
 |--------------------------------------------------------
 */
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
/*
 |--------------------------------------------------------
 |           UserNotifications Controller Routes
 |--------------------------------------------------------
 */
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
/*
 |--------------------------------------------------------
 |          ThreadSubscriptions Controller Routes
 |--------------------------------------------------------
 */
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');
/*
 |--------------------------------------------------------
 |            UsersController Controller Routes
 |--------------------------------------------------------
 */
Route::get('api/users', 'Api\UsersController@index');
/*
 |--------------------------------------------------------
 |         UsersAvatarController Controller Routes
 |--------------------------------------------------------
 */
Route::post('api/users/{user}/avatar', 'Api\UsersAvatarController@store')->middleware('auth')->name('avatar');
/*
 |--------------------------------------------------------
 |            RegistrationConfirm Controller
 |--------------------------------------------------------
 */
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');
/*
 |--------------------------------------------------------
 |           LockedThreadsController Controller
 |--------------------------------------------------------
 */
Route::post('/lock-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/lock-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');
/*
 |--------------------------------------------------------
 |             SearchController Controller
 |--------------------------------------------------------
 */
Route::get('threads/search', 'SearchController@show');
/*
 |--------------------------------------------------------
 |               Chart Controller Routes
 |--------------------------------------------------------
 */
Route::get('analysis/chart', 'AnalysisController@index')->name('analysis.index');
Route::post('analysis/chart', 'AnalysisController@store')->name('analysis.store')->middleware('auth');
/*
 |--------------------------------------------------------
 |               Threads Comments Routes
 |--------------------------------------------------------
 */
Route::post('analysis/{thread}/comment', 'ThreadsCommentsController@store')->name('threads.comments.store')->middleware('auth');
Route::get('analysis/{thread}/comments', 'ThreadsCommentsController@index')->name('threads.comments.index');
Route::get('threads/{channel}/{thread}/attach', 'ThreadsCommentsController@show')->name('threads.comment.show')->middleware('auth');
/*
 |--------------------------------------------------------
 |            Thread Favorites Controller Routes
 |--------------------------------------------------------
 */
Route::post('/threads/{thread}/favorites', 'ThreadFavoritesController@store');
Route::delete('/threads/{thread}/favorites', 'ThreadFavoritesController@destroy');
/*
 |--------------------------------------------------------
 |               Administrators Routes
 |--------------------------------------------------------
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::get('', 'DashboardController@index')->name('admin.dashboard.index');
//    Route::post('channels', 'ChannelsController@store')->name('admin.channels.store');
//    Route::get('channels', 'ChannelsController@index')->name('admin.channels.index');
//    Route::get('channels/create', 'ChannelsController@create')->name('admin.channels.create');
});


Route::get('test', function () {

    $popularThreads = \App\Thread::orderBy('replies_count', 'desc')->take(2)->get();
    return $popularThreads;

});

