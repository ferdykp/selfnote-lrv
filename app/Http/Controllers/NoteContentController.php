<?php

namespace App\Http\Controllers;

use App\Models\NoteContent;
use App\Support\NoteHtml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteContentController extends Controller
{
    // ===== LIST NOTES =====
    public function index(Request $request)
    {
        $query = NoteContent::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        if ($request->input('view') === 'favorites') $query->where('is_favorite', true);
        if ($request->input('view') === 'pinned') $query->where('is_pinned', true);
        if ($request->filled('tag')) $query->where('tags', 'like', '%'.str_replace(['%', '_'], ['\\%', '\\_'], $request->tag).'%');
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $sort = $request->input('sort') === 'asc' ? 'asc' : 'desc';
        $contents = $query->orderByDesc('is_pinned')->orderBy('updated_at', $sort)->get();

        if ($request->ajax()) {
            return view('content.index', compact('contents'))->render();
        }

        return view('content.index', compact('contents'));
    }

    public function create()
    {
        return view('content.create');
    }

    // ===== GET SINGLE NOTE =====
    public function show(NoteContent $content)
    {
        // Jangan di-markdown dulu di sini agar saat diedit tag aslinya tidak rusak di contenteditable
        return response()->json($content);
    }

    // ===== CREATE NOTE =====
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|max:1000000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|string|max:500',
            'status'  => 'required|in:draft,published', // Validasi status enum
        ]);

        $validated['content'] = NoteHtml::clean($validated['content']);
        // Seleraskan dengan nama kolom database baru: 'images'
        if ($request->hasFile('image')) {
            $validated['images'] = $request->file('image')->store('notes', 'public');
        }

        $validated['date'] = now()->toDateString();

        $note = NoteContent::create($validated);

        if ($request->ajax()) {
            return response()->json($note);
        }

        return redirect()->route('content.index')->with('success', 'Note saved successfully!');
    }

    public function edit($id)
    {
        $content = NoteContent::findOrFail($id);
        return view('content.edit', compact('content'));
    }

    // ===== UPDATE NOTE =====
    public function update(Request $request, $id)
    {
        $noteContent = NoteContent::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|max:1000000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|string|max:500',
            'status'  => 'required|in:draft,published', // Validasi status enum
        ]);

        if ($request->hasFile('image')) {
            if ($noteContent->images && Storage::disk('public')->exists($noteContent->images)) {
                Storage::disk('public')->delete($noteContent->images);
            }
            $validated['images'] = $request->file('image')->store('notes', 'public');
        }

        $validated['content'] = NoteHtml::clean($validated['content']);
        $validated['date'] = $noteContent->date ?? now()->toDateString();
        if ($noteContent->title !== $validated['title'] || $noteContent->content !== $validated['content'] || $noteContent->status !== $validated['status']) {
            $noteContent->revisions()->create(['title'=>$noteContent->title,'content'=>$noteContent->content,'status'=>$noteContent->status]);
            $noteContent->revisions()->latest()->skip(30)->pluck('id')->each(fn($id) => $noteContent->revisions()->whereKey($id)->delete());
        }
        $noteContent->update($validated);

        if ($request->ajax()) {
            return response()->json($noteContent);
        }

        return redirect()->route('content.index')->with('success', 'Note updated successfully!');
    }

    public function toggle(NoteContent $content, string $field) {
        abort_unless(in_array($field, ['pin','favorite'], true), 404);
        $column=$field==='pin'?'is_pinned':'is_favorite';
        $content->update([$column=>!$content->$column]);
        return back()->with('success', $field==='pin'?'Pin catatan diperbarui.':'Favorit diperbarui.');
    }

    public function export(NoteContent $content) {
        $text=$content->title."\n\n".html_entity_decode(strip_tags(str_replace(['</p>','<br>','<br/>','</li>'],"\n",$content->content)),ENT_QUOTES|ENT_HTML5,'UTF-8');
        $name=\Illuminate\Support\Str::slug($content->title) ?: 'catatan';
        return response($text,200,['Content-Type'=>'text/plain; charset=utf-8','Content-Disposition'=>"attachment; filename=\"$name.txt\""]);
    }

    public function revisions(NoteContent $content) {
        return view('content.revisions', ['note'=>$content,'revisions'=>$content->revisions()->limit(30)->get()]);
    }

    public function restoreRevision(NoteContent $content, \App\Models\NoteRevision $revision) {
        abort_unless($revision->note_content_id === $content->id, 404);
        $content->revisions()->create(['title'=>$content->title,'content'=>$content->content,'status'=>$content->status]);
        $content->update(['title'=>$revision->title,'content'=>NoteHtml::clean($revision->content),'status'=>$revision->status]);
        return redirect()->route('content.edit',$content)->with('success','Versi catatan berhasil dipulihkan.');
    }

    // ===== SOFT DELETE, TRASH, RESTORE, FORCE DELETE (Tetap Sama) =====
    public function destroy($id)
    {
        NoteContent::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Catatan dipindahkan ke Sampah.');
    }

    public function trash()
    {
        $notes = NoteContent::onlyTrashed()->get();
        return view('content.trash', compact('notes'));
    }

    public function restore($id)
    {
        NoteContent::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('content.trash')->with('status', 'Catatan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $note = NoteContent::onlyTrashed()->findOrFail($id);
        if ($note->images) {
            Storage::disk('public')->delete($note->images);
        }
        $note->forceDelete();
        return redirect()->route('content.trash')->with('status', 'Catatan dihapus permanen.');
    }
}
