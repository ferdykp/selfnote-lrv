<?php

use App\Http\Controllers\NoteContentController;
use Illuminate\Support\Facades\Route;
// use Laravel\Prompts\Note;

Route::get('/', [NoteContentController::class, 'index'])->name('home');
Route::patch('/content/{content}/toggle/{field}', [NoteContentController::class, 'toggle'])->name('content.toggle');
Route::get('/content/{content}/export', [NoteContentController::class, 'export'])->name('content.export');
Route::get('/content/{content}/revisions', [NoteContentController::class, 'revisions'])->name('content.revisions');
Route::post('/content/{content}/revisions/{revision}/restore', [NoteContentController::class, 'restoreRevision'])->name('content.revisions.restore');
Route::resource('content', NoteContentController::class);
// Route::get('/content/{id}', [NoteContentController::class, 'show'])->name('content.show');
// Route::post('/content/{id}/update', [NoteContentController::class, 'update'])->name('content.update');

Route::get('/trash', [NoteContentController::class, 'trash'])->name('content.trash');
Route::patch('/trash/{id}/restore', [NoteContentController::class, 'restore'])->name('content.restore');
Route::delete('/trash/{id}/force', [NoteContentController::class, 'forceDelete'])->name('content.forceDelete');
