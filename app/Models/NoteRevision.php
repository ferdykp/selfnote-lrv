<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NoteRevision extends Model {
    protected $fillable=['title','content','status'];
    public function note(){ return $this->belongsTo(NoteContent::class,'note_content_id'); }
}
