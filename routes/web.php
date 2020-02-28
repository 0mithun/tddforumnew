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

Route::get('/home', 'ThreadsController@index');

Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('threads/create', 'ThreadsController@create');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');


Route::post('threads', 'ThreadsController@store')->middleware('must-be-confirmed');
Route::get('threads/{channel}', 'ThreadsController@index');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');


Route::get('/tags','FrontendController@getTags');

Route::get("/tags/{tag}/threads",'ThreadsController@loadByTag')->name('tags.threads.list');

Route::get("threads/most-likes",'ThreadsController@loadByLikes')->name('likes.threads.list');
Route::get("/threads/most-views",'ThreadsController@loadByViews')->name('views.threads.list');
Route::get("/threads/most-recents",'ThreadsController@loadByRecents')->name('recents.threads.list');
Route::get("/threads/top-rated",'ThreadsController@loadByTopRated')->name('toprated.threads.list');
Route::get("/threads/best-of-week",'ThreadsController@loadByBestOfWeek')->name('bestofweek.threads.list');


Route::get('/user/confirm-new-email','ProfilesController@confirmNewEmail')->name('conform.new.email');
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');


Route::get('/contact','FrontendController@contact')->name('contact');
Route::get('/privacy-policy','FrontendController@privacyPolicy')->name('privacypolicy');
Route::get('/tos','FrontendController@tos')->name('tos');
Route::get('/faq','FrontendController@faq')->name('faq');
Route::post('contact','FrontendController@contactAdmin')->name('contactadmin');

Route::get('/replies/{reply}/load-reply','RepliesController@lodReply');





Route::middleware(['auth'])->group(function (){

    //Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');
    Route::post('threads/{channel}/{thread}', 'ThreadsController@update');
    Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');



    Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
    Route::patch('/replies/{reply}', 'RepliesController@update');
    Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
    Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');
    Route::post('/replies/{reply}/new-reply','RepliesController@newReply');

    Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
    Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
    Route::post('/thread/{thread}/favorites', 'FavoritesController@threadStore');
    Route::delete('/thread/{thread}/favorites', 'FavoritesController@thraeadDestroy');
    Route::post('/thread/{thread}/likes', 'LikeController@like');
    Route::post('/thread/{thread}/dislikes', 'LikeController@dislike');



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
    Route::get('/profiles/{user}/my-likes','ProfilesController@myLikesShow')->name('profile.likes');


    Route::get('/profiles/{user}/settings','UserSettingsController@index')->name('user.settnigs');
    Route::post('/profiles/{user}/settings','UserSettingsController@update')->name('user.settnigs.update');


    Route::post('/tags/load','FrontendController@tagLoad')->name('tags.load');




    Route::get('api/users', 'Api\UsersController@index');
    Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
    Route::get('/users/change-password','ProfilesController@editPassword')->name('user.edit.password');
    Route::post('/user/update-password','ProfilesController@updatePassword')->name('user.update.password');

    Route::get("/threads/my-favorites",'ThreadsController@loadByMyFavorites')->name('myfavorites.threads.list');
});


Route::post('/tags/all-tags','FrontendController@allTags');

Route::post('/channel/search', 'ChannelController@search')->name('chanel.search');



Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


//Route::get('/profiles/{user}/settings/notifications','UserSettingsController@notifications')->name('user.settnigs.notifications');
//Route::get('/profiles/{user}/settings/subscriptions','UserSettingsController@subscriptions')->name('user.settnigs.subscriptions');



/*
 * Admin Route
 *
 * */
Route::middleware(['admin'])->group(function (){
    Route::get('/admin/site-settings','AdminController@siteSettings')->name('admin.setesettings');
    Route::post('/admin/site-settings','AdminController@siteSettingsUpdate')->name('admin.setesettings.update');

    Route::get('/admin/tags','AdminController@tags')->name('admin.tag');
    Route::post('/admin/tags/add','AdminController@tagsAdd')->name('admin.tag.create');
    Route::post('/admin/tags/update','AdminController@tagsUpdate')->name('admin.tag.update');

    Route::get('/admin/tos','AdminController@tos')->name('admin.tos');
    Route::get('/admin/privacy-policy','AdminController@privacyPolicy')->name('admin.privacypolicy');
    Route::get('/admin/faq','AdminController@faq')->name('admin.faq');


    Route::post('/admin/tos','AdminController@tosUpdate')->name('admin.tos.update');
    Route::post('/admin/privacy-policy','AdminController@privacyPolicyUpdate')->name('admin.privacypolicy.update');
    Route::post('/admin/faq','AdminController@faqUpdate')->name('admin.faq.update');


    Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store');
    Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy');


//    Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
//    Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');;
});









