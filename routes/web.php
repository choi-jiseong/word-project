<?php

use App\Http\Controllers\WordNoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/notes', [WordNoteController::class, 'index'])->name('notes.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/notes/show/{noteId}', [WordNoteController::class, 'show'])->name('notes.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/notes/create', [WordNoteController::class, 'create'])->name('notes.create');

Route::middleware(['auth:sanctum', 'verified'])->post('/notes/store', [WordNoteController::class, 'store'])->name('notes.store');

Route::middleware(['auth:sanctum', 'verified'])->patch('/notes/update/{noteId}', [WordNoteController::class, 'update'])->name('notes.update');

Route::middleware(['auth:sanctum', 'verified'])->delete('/notes/delete/{noteId}', [WordNoteController::class, 'destroy'])->name('notes.destroy');
