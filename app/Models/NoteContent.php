<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteContent extends Model
{
    protected $fillable = [
        'title',
        'content',
        'images',
        'date'
    ];
}
