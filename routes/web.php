<?php

use App\Http\Controllers\ArcticleController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\UserController;
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

//cest moi le contact.../contact
// Route::get('/contact', function () {
//     return "cest moi le contact";
//    });

// Route::get('/{n}', function ($n) {
//  return "page ".$n;
// });

Route::get('/users',[UserController::class,'create'] );
Route::post('/users',[UserController::class,'store'] );
Route::resource('films', FilmController::class);

