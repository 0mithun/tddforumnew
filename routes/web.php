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

Route::get('/','ThreadsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('threads/create', 'ThreadsController@create');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
//Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');
Route::post('threads/{channel}/{thread}', 'ThreadsController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::get('threads/{channel}', 'ThreadsController@index');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');


Route::post('/thread/{thread}/favorites', 'FavoritesController@threadStore');
Route::delete('/thread/{thread}/favorites', 'FavoritesController@thraeadDestroy');




//Route::post('/replies/{reply}/report', 'RepliesController@report');
Route::post('/replies/{reply}/report', 'ReportController@reply');

//Route::post('/threads/report','ThreadsController@report');
Route::post('/threads/report','ReportController@thread');

//Route::post('api/users/report','Api\UsersController@report');
Route::post('api/users/report','ReportController@user');
//Route::post('/users/report', '')





Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/profiles/{user}/avatar','ProfilesController@avatar')->name('profile.avatar.page');
Route::post('/profiles/{user}/avatar/change','ProfilesController@avatarChange')->name('profile.avatar.change');


Route::get('/profiles/{user}/edit', 'ProfilesController@edit')->name('profile.user.edit');
Route::post('/profiles/{user}/update', 'ProfilesController@update')->name('profile.user.update');


Route::get('/profiles/{user}/my-subscriptions','ProfilesController@mySubscriptionsShow')->name('profile.subscriptions');
Route::get('/profiles/{user}/my-favorites','ProfilesController@myFavoritesShow')->name('profile.favorites');
Route::get('/profiles/{user}/my-threads','ProfilesController@myThreadsShow')->name('profile.threads');


Route::get('/profiles/{user}/settings','UserSettingsController@index')->name('user.settnigs');
Route::get('/profiles/{user}/settings/notifications','UserSettingsController@notifications')->name('user.settnigs.notifications');
Route::get('/profiles/{user}/settings/subscriptions','UserSettingsController@subscriptions')->name('user.settnigs.subscriptions');

Route::get('/user/confirm-new-email','ProfilesController@confirmNewEmail')->name('conform.new.email');

Route::get('/users/change-password','ProfilesController@editPassword')->name('user.edit.password');
Route::post('/user/update-password','ProfilesController@updatePassword')->name('user.update.password');







Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');



Route::post('/channel/search', 'ChannelController@search')->name('chanel.search');


Route::get('/contact','FrontendController@contact')->name('contact');
Route::get('/privacy-policy','FrontendController@privacyPolicy')->name('privacypolicy');
Route::get('/tos','FrontendController@tos')->name('tos');
Route::get('/faq','FrontendController@faq')->name('faq');


Route::post('contact','FrontendController@contactAdmin')->name('contactadmin');

