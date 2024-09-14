<?php

use App\Http\Controllers\HeadsetController;
use App\Http\Controllers\ScenarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [HeadsetController::class, 'login']);

Route::post('/scenarios', [ScenarioController::class, 'index']);


Route::get('/some-file', function(){
    $image = Gdrive::get('quizzly/Bugsunited.png');

    return response($image->file, 200)
        ->header('Content-Type', $image->ext);
});
