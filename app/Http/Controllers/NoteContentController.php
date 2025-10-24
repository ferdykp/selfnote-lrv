<?php

namespace App\Http\Controllers;

use App\Models\NoteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('notes', 'public');
        }

        $validated['date'] = now()->toDateString();

        $note = NoteContent::create($validated);

        // Jika AJAX, kembalikan JSON
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

        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($noteContent->image && Storage::disk('public')->exists($noteContent->image)) {
                Storage::disk('public')->delete($noteContent->image);
            }
            $validated['image'] = $request->file('image')->store('notes', 'public');
        } else {
            $validated['image'] = $noteContent->image;
        }

        $validated['date'] = now()->toDateTimeString();

        $noteContent->update($validated);

        // Jika AJAX, kembalikan JSON
        if ($request->ajax()) {
            return response()->json($noteContent);
        }

        return redirect()->route('content.index')->with('success', 'Note updated successfully!');
    }

    // ===== DELETE NOTE =====
    public function destroy($id)
    {
        $noteContent = NoteContent::findOrFail($id);

        if ($noteContent->image && Storage::disk('public')->exists($noteContent->image)) {
            Storage::disk('public')->delete($noteContent->image);
        }

        $noteContent->delete();

        // Jika AJAX, kembalikan JSON sukses
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('content.index')->with('success', 'Note deleted successfully!');
    }
}
