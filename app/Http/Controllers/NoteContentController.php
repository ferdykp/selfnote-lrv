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
        $contents = $query->orderBy('updated_at', $sort)->get();

        if ($request->ajax()) {
            return view('content.index', compact('contents'))->render();
        }

        return view('content.index', compact('contents'));
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
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'  => 'required|in:draft,published', // Validasi status enum
        ]);

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

    // ===== UPDATE NOTE =====
    public function update(Request $request, $id)
    {
        $noteContent = NoteContent::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'  => 'required|in:draft,published', // Validasi status enum
        ]);

        if ($request->hasFile('image')) {
            if ($noteContent->images && Storage::disk('public')->exists($noteContent->images)) {
                Storage::disk('public')->delete($noteContent->images);
            }
            $validated['images'] = $request->file('image')->store('notes', 'public');
        }

        $validated['date'] = now()->toDateString();

        $noteContent->update($validated);

        if ($request->ajax()) {
            return response()->json($noteContent);
        }

        return redirect()->route('content.index')->with('success', 'Note updated successfully!');
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
        NoteContent::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('content.trash')->with('status', 'Catatan dihapus permanen.');
    }
}
