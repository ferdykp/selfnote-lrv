<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← tambahkan ini

class NoteContent extends Model
{
    use SoftDeletes; // ← aktifkan fitur soft delete

    protected $fillable = [
        'title',
        'content',
        'images',
        'date',
        'status'
    ];

    // Opsi tambahan (tidak wajib, tapi disarankan)
    protected $dates = ['deleted_at'];
}
