<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('auth/user', 'AuthController@me');
    Route::post('auth/logout', 'AuthController@logout');

    Route::post('auth/verify', 'Auth\VerificationController@verify');

    // roles
    Route::get('roles', 'RoleController@index');

    // bot
    Route::post('bot/register', 'Bot\BotController@register');
    Route::get('bot', 'Bot\BotController@index');
    Route::get('bot/{id}', 'Bot\BotController@show');
    Route::post('bot/{id}', 'Bot\BotController@edit');
    Route::get('bot/reload/{token}', 'Bot\BotController@reload');

    Route::get('menu/{id}', 'Menu\MenuController@show');
    Route::get('menu', 'Menu\MenuController@showUserMenu');
    Route::get('menu/{id}/categories', 'Menu\MenuController@menuCategories');
    Route::post('menu/{id}/categories', 'Menu\MenuController@createMenuCategory');

    Route::get('menu_categories/{id}/items', 'Menu\MenuCategoryController@items');
    Route::post('menu_categories/{id}/item', 'Menu\MenuItemController@createItem');

    Route::post('menu_item/{id}', 'Menu\MenuItemController@edit');
    Route::delete('menu_item/{id}', 'Menu\MenuItemController@delete');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::post('comment/{id}/seen', 'CommentController@seen');

    Route::get('user/comments/unseen', 'CommentController@getUnseenUserComments');
    Route::get('user/comments', 'CommentController@userComments');

    Route::get('gallery/{id}', 'Menu\GalleryController@show');


});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('comment/item/{item_id}', 'CommentController@submitItem');
    Route::post('auth/login', 'AuthController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::get('getme', 'TelegramController@getMe');
Route::get('setwebhook', 'TelegramController@setWebhook');
Route::post('/{token}/webhook', 'TelegramController@webhook');
