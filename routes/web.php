<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForumController;
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

Route::middleware([
    'auth',
    'user.type.is:1'
])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin']);
    Route::get('/admin/categories', [ForumController::class, 'categories']);
});
