<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RankController;
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

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/home/foo', [App\Http\Controllers\HomeController::class, 'foo'])->name('foo');

Route::group(['middleware' => ['auth','user.type.is:1'], 'prefix' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'admin']);
    Route::get('/categories', [ForumController::class, 'categories']);

    Route::group(['prefix' => 'group'], function() {
        Route::post('/', [GroupController::class, 'create_group']);
    });

    Route::group(['prefix' => 'rank'], function() {
        Route::post('/', [RankController::class, 'create_rank']);
    });

    Route::group(['prefix' => 'custom-field'], function() {
       Route::post('/', [CustomFieldController::class, 'createCustomField'])->name('createCustomField');
    });
});
