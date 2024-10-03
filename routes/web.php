<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BinauralBeatsController;
use App\Http\Controllers\Admin\BackgroundAudioController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Frontend\AffirmationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** Admin Routes */
Route::get('welcome', function () {
    return view('welcome');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/login', [AdminLoginController::class, 'login'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'loginSubmit'])->name('login');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    // Route::get('/register', [AdminLoginController::class, 'register'])->name('customer.register');
    // Route::post('/register', [AdminLoginController::class, 'registerSubmit'])->name('customer.registerSubmit');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /**Password change module*/
        Route::get('/change-password', [AdminLoginController::class, 'changePassword'])->name('admin.change.password');
        Route::post('/change-password', [AdminLoginController::class, 'submitChangePassword'])->name('admin.change.password.submit');

        /** Category Module */
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create-or-edit/{id?}', [CategoryController::class, 'createOrEdit'])->name('category.createOrEdit');
        Route::post('/category/create-or-update/{id?}', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::post('/category-status-change', [CategoryController::class, 'changeStatus'])->name('category.change.status');
        Route::post('/category-check-name', [CategoryController::class, 'checkNameValid'])->name('category.check.name');

        /** Binaural Beats */
        Route::get('/binaural-beats', [BinauralBeatsController::class, 'index'])->name('binaural-beats.index');
        Route::get('/binaural-beats/create-or-edit/{id?}', [BinauralBeatsController::class, 'createOrEdit'])->name('binaural-beats.createOrEdit');
        Route::post('/binaural-beats/create-or-update/{id?}', [BinauralBeatsController::class, 'store'])->name('binaural-beats.store');
        Route::delete('/binaural-beats/delete/{id}', [BinauralBeatsController::class, 'delete'])->name('binaural-beats.delete');
        Route::post('/binaural-beats-status-change', [BinauralBeatsController::class, 'changeStatus'])->name('binaural-beats.change.status');

        /** Background Audio */
        Route::get('/background-audio', [BackgroundAudioController::class, 'index'])->name('background-audio.index');
        Route::get('/background-audio/create-or-edit/{id?}', [BackgroundAudioController::class, 'createOrEdit'])->name('background-audio.createOrEdit');
        Route::post('/background-audio/create-or-update/{id?}', [BackgroundAudioController::class, 'store'])->name('background-audio.store');
        Route::delete('/background-audio/delete/{id}', [BackgroundAudioController::class, 'delete'])->name('background-audio.delete');
        Route::post('/background-audio-status-change', [BackgroundAudioController::class, 'changeStatus'])->name('background-audio.change.status');

        /** Banner */
        Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/banner/create-or-edit/{id?}', [BannerController::class, 'createOrEdit'])->name('banner.createOrEdit');
        Route::post('/banner/create-or-update/{id?}', [BannerController::class, 'store'])->name('banner.store');
        Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
        Route::post('/banner-status-change', [BannerController::class, 'changeStatus'])->name('banner.change.status');

        /** Setting */
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting/bb', [SettingController::class, 'storeSetting'])->name('setting.store');
    });
});


/** Front Routes */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'login'])->name('customer.login');
Route::post('/login', [LoginController::class, 'loginSubmit'])->name('customer.login');
Route::get('/register', [LoginController::class, 'register'])->name('customer.register');
Route::post('/register', [LoginController::class, 'registerSubmit'])->name('customer.registerSubmit');
Route::post('/logout', [LoginController::class, 'logout'])->name('customer.logout');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');
Route::post('customer/password/email', [LoginController::class, 'sendResetLinkEmail'])->name('customer.password.email');
Route::get('customer/reset-password/{token}', [LoginController::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password', [LoginController::class, 'submitResetPasswordForm'])->name('reset.password.submit');

Route::middleware('user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('customer.profile');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [ProfileController::class, 'submitChangePassword'])->name('change.password.submit');
    Route::get('/affirmation', [AffirmationController::class, 'index'])->name('affirmation');
    Route::get('/affirmation/create/{id?}', [AffirmationController::class, 'createOrEdit'])->name('affirmation.create');
    Route::post('/affirmation/store', [AffirmationController::class, 'store'])->name('affirmation.store');
});
