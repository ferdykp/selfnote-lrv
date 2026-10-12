@extends('layouts.master')

@section('content')
    <section class="writing-page">
        <div class="writing-width"> {{-- Diubah ke max-w-5xl agar editor terfokus di tengah seperti Notion --}}

            {{-- Header & Back Button --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('content.index') }}"
                        class="p-2 transition bg-white border rounded-xl dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <i class="text-sm fa-solid fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Catatan baru</h2>
                </div>
            </div>

            {{-- Form Card --}}
            <div
                class="writing-surface">
                <form id="createNoteForm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="createStatusInput" value="draft">

                    <div class="writing-content">
<div data-autosave-status role="status" aria-live="polite" class="text-xs text-indigo-600 dark:text-indigo-300">Autosave lokal aktif</div>
                        {{-- Title --}}
                        <input type="text" name="title" data-note-title="1" placeholder="Beri judul catatan…" autocomplete="off" required
                            class="w-full px-0 py-1 text-3xl font-bold bg-transparent border-0 border-b border-transparent focus:border-slate-100 dark:focus:border-slate-800 focus:ring-0 focus:outline-none placeholder-slate-300 dark:placeholder-slate-700 text-slate-800 dark:text-white">

                        <label class="block text-sm text-slate-600 dark:text-slate-300">Tag (pisahkan dengan koma)<input name="tags" value="{{ old('tags') }}" maxlength="500" placeholder="ide, kerja, personal" class="mt-2 w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-transparent"></label>
                        <div class="writing-toolbar" role="toolbar" aria-label="Alat pemformatan catatan">
  <div class="toolbar-group" aria-label="Gaya teks">
    <button type="button" data-cmd="bold" title="Tebal (⌘/Ctrl+B)" aria-label="Tebal"><i class="fa-solid fa-bold"></i></button>
    <button type="button" data-cmd="italic" title="Miring (⌘/Ctrl+I)" aria-label="Miring"><i class="fa-solid fa-italic"></i></button>
    <button type="button" data-cmd="underline" title="Garis bawah (⌘/Ctrl+U)" aria-label="Garis bawah"><i class="fa-solid fa-underline"></i></button>
    <button type="button" data-cmd="strike" title="Coret" aria-label="Coret"><i class="fa-solid fa-strikethrough"></i></button>
    <button type="button" data-cmd="code" title="Inline code" aria-label="Inline code"><i class="fa-solid fa-code"></i></button>
  </div><span class="toolbar-separator" aria-hidden="true"></span>
  <div class="toolbar-group" aria-label="Struktur">
    <button type="button" data-cmd="h1" title="Judul besar" aria-label="Heading 1">H1</button>
    <button type="button" data-cmd="h2" title="Subjudul" aria-label="Heading 2">H2</button>
    <button type="button" data-cmd="h3" title="Heading 3" aria-label="Heading 3">H3</button>
    <button type="button" data-cmd="paragraph" title="Paragraf" aria-label="Paragraf">¶</button>
    <button type="button" data-cmd="blockquote" title="Kutipan" aria-label="Kutipan"><i class="fa-solid fa-quote-left"></i></button>
  </div><span class="toolbar-separator" aria-hidden="true"></span>
  <div class="toolbar-group" aria-label="Daftar">
    <button type="button" data-cmd="insertUnorderedList" title="Daftar bullet" aria-label="Daftar bullet"><i class="fa-solid fa-list-ul"></i></button>
    <button type="button" data-cmd="insertOrderedList" title="Daftar angka" aria-label="Daftar angka"><i class="fa-solid fa-list-ol"></i></button>
  </div><span class="toolbar-separator" aria-hidden="true"></span>
  <div class="toolbar-group" aria-label="Perataan">
    <button type="button" data-cmd="align-left" title="Rata kiri" aria-label="Rata kiri"><i class="fa-solid fa-align-left"></i></button>
    <button type="button" data-cmd="align-center" title="Rata tengah" aria-label="Rata tengah"><i class="fa-solid fa-align-center"></i></button>
    <button type="button" data-cmd="align-right" title="Rata kanan" aria-label="Rata kanan"><i class="fa-solid fa-align-right"></i></button>
  </div><span class="toolbar-separator" aria-hidden="true"></span>
  <div class="toolbar-group" aria-label="Sisipkan dan alat">
    <button type="button" data-editor-link title="Sisipkan tautan" aria-label="Sisipkan tautan"><i class="fa-solid fa-link"></i></button>
    <button type="button" data-cover-trigger title="Pilih cover" aria-label="Pilih cover"><i class="fa-regular fa-image"></i></button>
    <button type="button" data-cmd="clear" title="Hapus format pada seleksi" aria-label="Hapus format"><i class="fa-solid fa-eraser"></i></button>
  </div>
  <input type="file" name="image" hidden accept="image/jpeg,image/png" />
</div>
<p class="editor-hint"><i class="fa-regular fa-keyboard"></i> Tips: <kbd>**tebal**</kbd> <kbd>*miring*</kbd> <kbd>~~coret~~</kbd> <kbd>`kode`</kbd> · di awal baris: <kbd>#</kbd> <kbd>##</kbd> <kbd>-</kbd> <kbd>1.</kbd> <kbd>&gt;</kbd></p>
<div id="editor" contenteditable="true" placeholder="Tulis ide dan pemikiranmu di sini..."
                            class="w-full min-h-[450px] focus:outline-none bg-transparent text-base leading-relaxed text-slate-700 dark:text-slate-300 break-words prose dark:prose-invert max-w-none focus:ring-0">
                        </div>
                        <textarea name="content" id="hiddenContent" hidden></textarea>
                    </div>

                    {{-- Footer Sticky/Bottom actions --}}
                    <div
                        class="flex items-center justify-between px-8 py-4 border-t bg-slate-50/50 dark:bg-slate-950/30 border-slate-100 dark:border-slate-800/80">
                        <span id="fileName" class="max-w-xs text-xs font-medium text-indigo-500 truncate"></span>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('content.index') }}"
                                class="px-5 py-2.5 text-sm font-medium transition bg-white border dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Cancel</a>

                            <button type="button" data-save-status="draft"
                                class="px-5 py-2.5 text-sm font-medium transition border text-slate-700 border-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 rounded-xl">
                                Simpan draft
                            </button>

                            <button type="button" data-save-status="published"
                                class="px-6 py-2.5 text-sm font-medium text-white transition bg-indigo-600 shadow-sm rounded-xl hover:bg-indigo-700 shadow-indigo-600/10">
                                Tandai selesai
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

