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
        'status', 'is_pinned', 'is_favorite', 'tags'
    ];

    // Opsi tambahan (tidak wajib, tapi disarankan)
    protected $casts = ['is_pinned'=>'boolean', 'is_favorite'=>'boolean'];
    public function revisions(){ return $this->hasMany(NoteRevision::class)->latest(); }

    protected $dates = ['deleted_at'];
}
