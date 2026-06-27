<?php

use App\Models\NoteContent; // Pastikan nama model Anda sesuai
use Illuminate\Support\Facades\Route;

// 1. Endpoint untuk mengambil semua artikel yang publish
Route::get('/portfolio-notes', function () {
    return response()->json(
        NoteContent::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get()
    );
});

// 2. Endpoint untuk mengambil detail satu artikel berdasarkan ID
Route::get('/portfolio-notes/{id}', function ($id) {
    $note = NoteContent::find($id);

    if (!$note) {
        return response()->json(['message' => 'Article not found'], 404);
    }

    return response()->json($note);
});
