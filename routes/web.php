<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Site\IndexController@index')->name('site');

//Multilingual
Route::group(['prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale()], function () {
    Auth::routes([
        'register' => false
    ]);

    Route::post('/2fa', 'Auth\TwoFactorAuthController@auth')->name('2fa')->middleware('2fa');

    Route::group(['prefix' => 'panel', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
        Route::get('/home', 'HomeController@index')->name('home');

        //User Profile
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', 'ProfileController@index')->name('profile.index')->middleware('permission:view profile');
            Route::put('/', 'ProfileController@update')->name('profile.update')->middleware('permission:view profile');
            Route::post('/upload', 'ProfileController@upload')->name('profile.upload')->middleware('permission:view profile');
            Route::get('/delete-avatar', 'ProfileController@deleteAvatar')->name('profile.deleteAvatar')->middleware('permission:view profile');
            Route::get('/update-two-step', 'ProfileController@updateTwoStep')->name('profile.googleTwoStep')->middleware('permission:view profile');
            Route::get('/regenerate-two-step-secret', 'ProfileController@regenerateTwoStepSecret')->name('profile.googleTwoStepRegenerate')->middleware('permission:view profile');
        });

        //Users Management
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index')->name('users.index')->middleware('permission:view users');
            Route::get('/create', 'UserController@create')->name('users.create')->middleware('permission:create users');
            Route::post('/store', 'UserController@store')->name('users.store')->middleware('permission:create users');
            Route::get('/{id}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:update users');
            Route::put('/{id}', 'UserController@update')->name('users.update')->middleware('permission:update users');
            Route::get('/{id}/reset-two-factor-auth', 'UserController@resetTwoFactorAuth')->name('users.2faReset')->middleware('permission:reset 2fa users');
            Route::delete('/{id}', 'UserController@destroy')->name('users.destroy')->middleware('permission:delete users');
        });

        Route::group(['prefix' => 'impersonate'], function () {
            Route::get('/logout', 'ImpersonateController@logout')->name('impersonate.logout');
            Route::get('/{id}', 'ImpersonateController@login')->name('impersonate.login')->middleware('permission:impersonate users');
        });

        //Roles & Permissions
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RoleController@index')->name('role.index')->middleware('permission:view roles');
            Route::post('/', 'RoleController@store')->name('role.store')->middleware('permission:create roles');
            Route::put('/{id}', 'RoleController@update')->name('role.update')->middleware('permission:update roles');
        });

        //News Management
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', 'NewsController@index')->name('news.index')->middleware('permission:view news');
            Route::get('/create', 'NewsController@create')->name('news.create')->middleware('permission:create news');
            Route::post('/', 'NewsController@store')->name('news.store')->middleware('permission:create news');
            Route::get('/{id}/edit', 'NewsController@edit')->name('news.edit')->middleware('permission:update news');
            Route::put('/{id}', 'NewsController@update')->name('news.update')->middleware('permission:update news');
            Route::delete('/{id}', 'NewsController@destroy')->name('news.destroy')->middleware('permission:delete news');
        });

        //Translations Management
        Route::group(['prefix' => 'translations'], function () {
            Route::get('/', 'TranslationController@index')->name('translations.index')->middleware('permission:view translations');
            Route::post('/store', 'TranslationController@store')->name('translations.store')->middleware('permission:update translations');
            Route::post('/store-language', 'TranslationController@storeLanguage')->name('translations.storeLanguage')->middleware('permission:create translations');
            Route::get('/rescan', 'TranslationController@rescan')->name('translations.rescan')->middleware('permission:rescan translations');
            Route::get('/export', 'TranslationController@export')->name('translations.export')->middleware('permission:export translations');
            Route::delete('/{locale}', 'TranslationController@destroy')->name('translations.destroy')->middleware('permission:delete translations');
        });

        //System Settings Management
        Route::group(['prefix' => 'system-settings'], function () {
            Route::get('/', 'SystemSettingsController@index')->name('systemSettings.index')->middleware('permission:view system settings');
            Route::put('/', 'SystemSettingsController@update')->name('systemSettings.update')->middleware('permission:update system settings');
        });
    });
});

//Route::group(['prefix' => 'telegram'], function () {
//    Route::post('/init', 'TelegramController@init')
//        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
//});
