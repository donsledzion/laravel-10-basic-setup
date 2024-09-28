<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AnsweringInteractionTypeController;
use App\Http\Controllers\AudioBackgroundController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\SkyboxBackgroundController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ScenarioController;
use App\Http\Controllers\PermissionController;

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
})->name('welcome');

Route::get('/home', function(){
    return view('home');
})->name('home')->middleware(['auth','verified']);

Route::get('/organization/{organization}/create-manager', [UserController::class, "createManager"])
        ->name('organization.create.manager')
        ->middleware(['auth','verified']);
Route::get('/organization/{organization}/create-trainer', [UserController::class, "createTrainer"])
        ->name('organization.create.trainer')
        ->middleware(['auth','verified']);
Route::get('/organization/{organization}/create-admin', [UserController::class, "createAdmin"])
        ->name('organization.create.admin')
        ->middleware(['auth','verified']);
Route::get('/organization/{organization}/remove-member/{user}',[OrganizationController::class,'removeMember'])
        ->name('organization.remove-member')
        ->middleware(['auth','verified']);

Route::get('/quiz/create/{scenario}', [QuizController::class, "create"])->name('quiz.create')->middleware(['auth','verified']);
Route::post('/quiz/{scenario}', [QuizController::class, "store"])->name('quiz.store')->middleware(['auth','verified']);
Route::get('/quiz/{quiz}', [QuizController::class,"show"])->name('quiz.show')->middleware(['auth','verified']);
Route::patch('quiz/{quiz}',[QuizController::class,"update"])->name('quiz.update')->middleware(['auth','verified']);
Route::delete('/quiz/{quiz}',[QuizController::class, "destroy"])->name('quiz.destroy')->middleware(['auth','verified']);
Route::get('/quiz/{quiz}/edit',[QuizController::class, "edit"])->name('quiz.edit')->middleware(['auth','verified']);



Route::post('/answer/{quiz}',[AnswerController::class, "store"])->name('answer.store')->middleware(['auth','verified']);
Route::patch('/answer/{answer}',[AnswerController::class, "update"])->name('answer.update')->middleware(['auth','verified']);
Route::get('/answer/{answer}/edit',[AnswerController::class, "edit"])->name('answer.edit')->middleware(['auth','verified']);
Route::delete('/answer/{answer}',[AnswerController::class, "destroy"])->name('answer.destroy')->middleware(['auth','verified']);
Route::post('/answer/{answer}/move-up',[AnswerController::class, "moveUp"])->name('answer.move-up')->middleware(['auth','verified']);
Route::post('/answer/{answer}/move-down',[AnswerController::class, "moveDown"])->name('answer.move-down')->middleware(['auth','verified']);


Route::resource('user', UserController::class)->middleware(['auth', 'verified']);
Route::resource('organization', OrganizationController::class)->middleware(['auth', 'verified']);
Route::resource('scenario', ScenarioController::class)->middleware(['auth', 'verified']);
Route::resource('answeringInteractionType',AnsweringInteractionTypeController::class)->middleware(['auth','verified']);
Route::get('/scenario/create/{organization}',[ScenarioController::class, 'create'])->name('scenario.create-for-organization')->middleware(['auth','verified']);

Route::resource('permission', PermissionController::class)->middleware(['auth','verified','admin']);
Route::get('permission/toggle/{permission}/{role}',[PermissionController::class,'toggle'])
        ->name('permission.toggle')
        ->middleware(['auth','verified','admin']);

Route::get('multimedia-files',[MultimediaController::class, "index"])->name('multimedia.index')->middleware(['auth','verified', 'admin']);

Route::resource('audioBackground', AudioBackgroundController::class)->middleware(['auth','verified']);
Route::resource('skyboxBackground', SkyboxBackgroundController::class)->middleware(['auth','verified']);


Auth::routes([
    'verify' => true,
    'register' => false
]);



