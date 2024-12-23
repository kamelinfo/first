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

Route::get('/users', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);


// Groupement des routes liées aux films avec le middleware 'auth'
Route::middleware(['auth'])->group(function () {

    // Route d'affichage de la liste des films accessible à tous les rôles authentifiés
    Route::get('/films', [FilmController::class, 'index'])
        ->middleware('role:admin,gestionaire,spectateur')
        ->name('films.index');

    // Routes réservées à 'admin' et 'gestionaire' pour créer et stocker des films
    Route::get('/films/create', [FilmController::class, 'create'])
        ->middleware('role:admin,gestionaire')
        ->name('films.create');

    // Route d'affichage d'un film spécifique accessible à tous les rôles authentifiés
    Route::get('/films/{film}', [FilmController::class, 'show'])
        ->middleware('role:admin,gestionaire,spectateur')
        ->name('films.show');


    Route::post('/films', [FilmController::class, 'store'])
        ->middleware('role:admin,gestionaire')
        ->name('films.store');

    // Routes réservées uniquement à 'admin' pour éditer, mettre à jour et supprimer des films
    Route::get('/films/{film}/edit', [FilmController::class, 'edit'])
        ->middleware('role:admin')
        ->name('films.edit');

    Route::put('/films/{film}', [FilmController::class, 'update'])
        ->middleware('role:admin')
        ->name('films.update');

    Route::delete('/films/{film}', [FilmController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('films.destroy');
    // Routes pour les catégories de films
    Route::get('category/{slug}/films', [FilmController::class, 'index'])
        ->middleware('role:admin,gestionaire,spectateur')
        ->name('films.category');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
