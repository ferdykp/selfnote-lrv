@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-slate-50/50 dark:bg-slate-950/20">
        <div class="mx-auto max-w-7xl"> {{-- Diubah ke max-w-5xl agar editor terfokus di tengah seperti Notion --}}

            {{-- Header & Back Button --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('content.index') }}"
                        class="p-2 transition bg-white border rounded-xl dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <i class="text-sm fa-solid fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Draft New Note</h2>
                </div>
            </div>

            {{-- Form Card --}}
            <div
                class="overflow-hidden bg-white border shadow-sm dark:bg-slate-900 rounded-2xl border-slate-200/80 dark:border-slate-800/80">
                <form id="createNoteForm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="createStatusInput" value="draft">

                    <div class="p-8 space-y-6">
                        {{-- Title --}}
                        <input type="text" name="title" placeholder="Untitled Note" autocomplete="off" required
                            class="w-full px-0 py-1 text-3xl font-bold bg-transparent border-0 border-b border-transparent focus:border-slate-100 dark:focus:border-slate-800 focus:ring-0 focus:outline-none placeholder-slate-300 dark:placeholder-slate-700 text-slate-800 dark:text-white">

                        {{-- Toolbar Rich Text Lengkap --}}
                        <div
                            class="sticky top-4 z-20 flex flex-wrap items-center gap-1 p-1.5 border rounded-xl bg-white/80 dark:bg-slate-900/80 backdrop-blur border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 shadow-sm">

                            {{-- Text Style Group --}}
                            <button type="button" data-cmd="bold"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Bold (Ctrl+B)"><i class="text-xs fa-solid fa-bold"></i></button>
                            <button type="button" data-cmd="italic"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Italic (Ctrl+I)"><i class="text-xs fa-solid fa-italic"></i></button>
                            <button type="button" data-cmd="underline"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Underline (Ctrl+U)"><i class="text-xs fa-solid fa-underline"></i></button>
                            <button type="button" data-cmd="strikeThrough"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Strikethrough"><i class="text-xs fa-solid fa-strikethrough"></i></button>

                            <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div>

                            {{-- Headings & Paragraph Selector --}}
                            {{-- <button type="button" data-cmd="formatBlock" data-val="h1"
                                class="h-8 px-2 text-xs font-semibold transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Heading 1">H1</button>
                            <button type="button" data-cmd="formatBlock" data-val="h2"
                                class="h-8 px-2 text-xs font-semibold transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Heading 2">H2</button>
                            <button type="button" data-cmd="formatBlock" data-val="p"
                                class="h-8 px-2 text-xs font-semibold transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Paragraph">Text</button>

                            <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div> --}}

                            {{-- Alignments --}}
                            <button type="button" data-cmd="justifyLeft"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Align Left"><i class="text-xs fa-solid fa-align-left"></i></button>
                            <button type="button" data-cmd="justifyCenter"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Align Center"><i class="text-xs fa-solid fa-align-center"></i></button>
                            <button type="button" data-cmd="justifyRight"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Align Right"><i class="text-xs fa-solid fa-align-right"></i></button>

                            <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div>

                            {{-- Lists & Blockquote --}}
                            {{-- <button type="button" data-cmd="insertUnorderedList"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Bullet List"><i class="text-xs fa-solid fa-list-ul"></i></button>
                            <button type="button" data-cmd="insertOrderedList"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Numbered List"><i class="text-xs fa-solid fa-list-ol"></i></button>
                            <button type="button" data-cmd="formatBlock" data-val="blockquote"
                                class="w-8 h-8 transition rounded-lg editor-btn hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Quote"><i class="text-xs fa-solid fa-quote-left"></i></button>

                            <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div> --}}

                            {{-- Links & Utilities --}}
                            <button type="button" id="linkBtn"
                                class="w-8 h-8 transition rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white"
                                title="Insert Link"><i class="text-xs fa-solid fa-link"></i></button>
                            <button type="button" data-cmd="removeFormat"
                                class="w-8 h-8 transition rounded-lg text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-950/30"
                                title="Clear Formatting"><i class="text-xs fa-solid fa-eraser"></i></button>

                            <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div>

                            {{-- Cover Image --}}
                            <button type="button" id="uploadIconBtn"
                                class="flex items-center gap-1 px-2.5 h-8 text-xs font-medium rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white transition border border-transparent hover:border-slate-200/60 dark:hover:border-slate-800"
                                title="Attach Cover Image">
                                <i class="text-indigo-500 fa-solid fa-image"></i> <span>Cover Image</span>
                            </button>
                            <input type="file" id="imageInput" name="image" hidden accept="image/*">
                        </div>

                        {{-- Editor Area --}}
                        <div id="editor" contenteditable="true" placeholder="Start typing your ideas here..."
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

                            <button type="button" onclick="submitCreateForm('draft')"
                                class="px-5 py-2.5 text-sm font-medium transition border text-slate-700 border-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 rounded-xl">
                                Save Draft
                            </button>

                            <button type="button" onclick="submitCreateForm('published')"
                                class="px-6 py-2.5 text-sm font-medium text-white transition bg-indigo-600 shadow-sm rounded-xl hover:bg-indigo-700 shadow-indigo-600/10">
                                Publish to Blog
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const editor = document.getElementById('editor');

        // ===== 1. HANDLER TOOLBAR UTAMA =====
        document.querySelectorAll('[data-cmd]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const cmd = this.dataset.cmd;
                const val = this.dataset.val || null;

                document.execCommand(cmd, false, val);
                editor.focus();
                updateToolbarStates(); // Segarkan state tombol setelah perintah dieksekusi
            });
        });

        // ===== 2. HANDLER KHUSUS INSERT LINK =====
        document.getElementById('linkBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const url = prompt("Masukkan URL Tautan (Contoh: https://google.com):");
            if (url !== null && url.trim() !== "") {
                document.execCommand("createLink", false, url);
                editor.focus();
            }
        });

        // ===== 3. DETEKSI AKSI KURSOR UNTUK MENYALAKAN TOMBOL TOOLBAR (TOGGLE STATE) =====
        function updateToolbarStates() {
            document.querySelectorAll('.editor-btn[data-cmd]').forEach(btn => {
                const cmd = btn.dataset.cmd;
                const val = btn.dataset.val;

                // Cek perintah dasar seperti bold, italic, dsb.
                if (!val && document.queryCommandState(cmd)) {
                    btn.classList.add('bg-slate-200', 'dark:bg-slate-800', 'text-indigo-600',
                        'dark:text-indigo-400');
                } else if (val && document.queryCommandValue(cmd) === val) {
                    // Cek format block seperti h1, h2, blockquote
                    btn.classList.add('bg-slate-200', 'dark:bg-slate-800', 'text-indigo-600',
                        'dark:text-indigo-400');
                } else {
                    btn.classList.remove('bg-slate-200', 'dark:bg-slate-800', 'text-indigo-600',
                        'dark:text-indigo-400');
                }
            });
        }

        // Jalankan deteksi tombol aktif saat kursor berpindah atau saat mengetik
        editor.addEventListener('keyup', updateToolbarStates);
        editor.addEventListener('mouseup', updateToolbarStates);

        // ===== 4. COVER IMAGE HANDLING =====
        const uploadIconBtn = document.getElementById('uploadIconBtn');
        const imageInput = document.getElementById('imageInput');
        const fileNameDisplay = document.getElementById('fileName');

        if (uploadIconBtn && imageInput) {
            uploadIconBtn.addEventListener('click', () => imageInput.click());
            imageInput.addEventListener('change', e => {
                fileNameDisplay.textContent = e.target.files[0]?.name || '';
            });
        }

        // ===== 5. SUBMIT FORM VALIDATION =====
        function submitCreateForm(status) {
            const form = document.getElementById('createNoteForm');
            const hiddenContent = document.getElementById('hiddenContent');
            const statusInput = document.getElementById('createStatusInput');

            // Ambil konten HTML dan bersihkan whitespace kosong bawaan div contenteditable
            let editorContent = editor.innerHTML.trim();
            if (editorContent === '<br>' || editorContent === '<div><br></div>') {
                editorContent = '';
            }

            if (!editorContent) {
                alert('Konten catatan tidak boleh kosong!');
                editor.focus();
                return;
            }

            if (hiddenContent) {
                hiddenContent.value = editorContent;
            }
            if (statusInput) {
                statusInput.value = status;
            }

            form.submit();
        }
    </script>
@endpush
