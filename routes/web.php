<?php

use App\Http\Controllers\NoteContentController;
use Illuminate\Support\Facades\Route;
// use Laravel\Prompts\Note;

Route::get('/', [NoteContentController::class, 'index'])->name('home');
Route::resource('content', NoteContentController::class);
Route::get('/content/{id}', [NoteContentController::class, 'show'])->name('content.show');
// Route::post('/content/{id}/update', [NoteContentController::class, 'update'])->name('content.update');
