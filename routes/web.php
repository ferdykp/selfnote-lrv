<?php

use App\Http\Controllers\NoteContentController;
use Illuminate\Support\Facades\Route;
// use Laravel\Prompts\Note;

Route::get('/', [NoteContentController::class, 'index'])->name('home');
Route::resource('content', NoteContentController::class);
Route::get('/content/{id}', [NoteContentController::class, 'show'])->name('content.show');
// Route::post('/content/{id}/update', [NoteContentController::class, 'update'])->name('content.update');

Route::get('/trash', [NoteContentController::class, 'trash'])->name('content.trash');
Route::patch('/trash/{id}/restore', [NoteContentController::class, 'restore'])->name('content.restore');
Route::delete('/trash/{id}/force', [NoteContentController::class, 'forceDelete'])->name('content.forceDelete');
