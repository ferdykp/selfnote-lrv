<?php

namespace App\Http\Controllers;

use App\Models\NoteContent;
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

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $sort = $request->get('sort', 'desc');
        $contents = $query->orderBy('date', $sort)->get();

        // Partial view untuk AJAX
        if ($request->ajax()) {
            return view('content.index', compact('contents'))->render();
        }

        return view('content.index', compact('contents'));
    }

    // ===== GET SINGLE NOTE =====
    public function show(NoteContent $content)
    {
        // Render Markdown ke HTML saat ditampilkan via API
        $content->content = Str::markdown($content->content);
        return response()->json($content);
    }

    // ===== CREATE NOTE =====
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('notes', 'public');
        }

        $validated['date'] = now()->toDateString();

        // Simpan note ke database
        $note = NoteContent::create($validated);

        // 🔥 Render Markdown ke HTML sebelum dikirim via AJAX
        $note->content = Str::markdown($note->content);

        // Jika AJAX, kembalikan JSON agar frontend langsung tampil bold, dll.
        if ($request->ajax()) {
            return response()->json($note);
        }

        return redirect()->route('content.index')->with('success', 'Note created successfully!');
    }

    // ===== UPDATE NOTE =====
    public function update(Request $request, $id)
    {
        $noteContent = NoteContent::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            if ($noteContent->image && Storage::disk('public')->exists($noteContent->image)) {
                Storage::disk('public')->delete($noteContent->image);
            }
            $validated['image'] = $request->file('image')->store('notes', 'public');
        } else {
            $validated['image'] = $noteContent->image;
        }

        $validated['date'] = now()->toDateTimeString();

        $noteContent->update($validated);

        // 🔥 Render Markdown ke HTML sebelum dikirim via AJAX
        $noteContent->content = Str::markdown($noteContent->content);

        if ($request->ajax()) {
            return response()->json($noteContent);
        }

        return redirect()->route('content.index')->with('success', 'Note updated successfully!');
    }

    // ===== DELETE NOTE (Soft Delete) =====
    public function destroy($id)
    {
        $note = NoteContent::findOrFail($id);
        $note->delete(); // Soft delete
        return redirect()->back()->with('status', 'Catatan dipindahkan ke Sampah.');
    }

    // ===== TRASH VIEW =====
    public function trash()
    {
        $notes = NoteContent::onlyTrashed()->get();
        return view('content.trash', compact('notes'));
    }

    // ===== RESTORE NOTE =====
    public function restore($id)
    {
        $note = NoteContent::onlyTrashed()->findOrFail($id);
        $note->restore();
        return redirect()->route('content.trash')->with('status', 'Catatan berhasil dipulihkan.');
    }

    // ===== FORCE DELETE =====
    public function forceDelete($id)
    {
        $note = NoteContent::onlyTrashed()->findOrFail($id);
        $note->forceDelete();
        return redirect()->route('content.trash')->with('status', 'Catatan dihapus permanen.');
    }
}
