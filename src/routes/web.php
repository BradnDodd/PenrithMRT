<?php

use App\Http\Controllers\VehicleAllocationController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/stay-safe', [App\Http\Controllers\StaySafeController::class, 'index'])->name('stay-safe');
Route::get('/get-involved', [App\Http\Controllers\HomeController::class, 'index'])->name('get-involved');
Route::get('/team', [App\Http\Controllers\TeamController::class, 'index'])->name('team');
Route::get('/news', [App\Http\Controllers\HomeController::class, 'index'])->name('news');
Route::get('/contact', [App\Http\Controllers\ContactUsController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactUsController::class, 'mailContactForm'])->name('contactForm');
Route::get('/donate', [App\Http\Controllers\DonateController::class, 'index'])->name('donate');
Route::get('/vehicle/allocation', [VehicleAllocationController::class, 'show']);

Route::resource('callouts', App\Http\Controllers\CalloutController::class);
