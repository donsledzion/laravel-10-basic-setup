<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/',[LicenseController::class, 'index'])->name('license.index')->middleware('auth','verified');
Route::get('/home',[LicenseController::class, 'index'])->name('license.index')->middleware('auth','verified');
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::resource('license',LicenseController::class)->middleware(['auth']);
Route::get('license',[LicenseController::class, 'index'])->name('license.index')->middleware('auth','verified');
Route::get('license/create',[LicenseController::class, 'create'])->name('license.create')->middleware('auth','verified');
Route::get('license/{string}',[LicenseController::class, 'show'])->name('license.show')->middleware('auth','verified');
Route::get('license/{string}/edit',[LicenseController::class, 'edit'])->name('license.edit')->middleware('auth','verified');
Route::post('license',[LicenseController::class, 'store'])->name('license.store')->middleware('auth','verified');
Route::delete('license/{string}',[LicenseController::class, 'destroy'])->name('license.delete')->middleware('auth','verified');
Route::patch('license/{string}',[LicenseController::class, 'update'])->name('license.update')->middleware('auth','verified');
Route::patch('license/{string}/turn-on',[LicenseController::class, 'turn_on'])->name('license.turn-on')->middleware('auth','verified');
Route::patch('license/{string}/turn-off',[LicenseController::class, 'turn_off'])->name('license.turn-off')->middleware('auth','verified');

Route::post('license-activate',[LicenseController::class, 'activate'])->name('license.activate');
Route::get('license-check/{string}', [LicenseController::class, 'check']);
