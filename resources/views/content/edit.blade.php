@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-slate-50/50 dark:bg-slate-950/20">
        <div class="mx-auto max-w-7xl">

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('content.index') }}"
                        class="p-2 transition bg-white border rounded-xl dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <i class="text-sm fa-solid fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Edit Note</h2>
                </div>
            </div>

            <div
                class="overflow-hidden bg-white border shadow-sm dark:bg-slate-900 rounded-2xl border-slate-200/80 dark:border-slate-800/80">
                <form id="editNoteForm" action="{{ route('content.update', $content->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="status" id="editStatusInput" value="{{ $content->status }}">

                    <div class="p-8 space-y-6">
                        {{-- Title --}}
                        <input type="text" name="title" id="editTitle" value="{{ $content->title }}"
                            placeholder="Untitled Note" autocomplete="off"
                            class="w-full px-0 py-1 text-3xl font-bold bg-transparent border-0 border-b border-transparent focus:border-slate-100 dark:focus:border-slate-800 focus:ring-0 focus:outline-none text-slate-800 dark:text-white">

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
                        <div id="editEditor" contenteditable="true"
                            class="w-full min-h-[400px] focus:outline-none bg-transparent text-base leading-relaxed text-slate-700 dark:text-slate-300 break-words prose dark:prose-invert">
                            {!! $content->content !!}
                        </div>

                        <textarea name="content" id="editHiddenContent" hidden></textarea>
                    </div>

                    {{-- Action buttons --}}
                    <div
                        class="flex justify-end px-8 py-4 space-x-3 border-t bg-slate-50/50 dark:bg-slate-950/30 border-slate-100 dark:border-slate-800/80">
                        <a href="{{ route('content.index') }}"
                            class="px-5 py-2.5 text-sm font-medium transition bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700">Cancel</a>

                        <button type="button" onclick="submitEditForm('draft')"
                            class="px-5 py-2.5 text-sm font-medium transition border text-slate-700 border-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 rounded-xl">
                            Save as Draft
                        </button>

                        <button type="button" onclick="submitEditForm('published')"
                            class="px-6 py-2.5 text-sm font-medium text-white transition bg-indigo-600 shadow-lg rounded-xl hover:bg-indigo-700 shadow-indigo-600/10">
                            Publish & Sync
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Toolbar Handler
        document.querySelectorAll('[data-cmd]').forEach(btn => {
            btn.addEventListener('click', function() {
                document.execCommand(this.dataset.cmd, false, null);
            });
        });

        // Edit Image Upload
        const editUploadIconBtn = document.getElementById('editUploadIconBtn');
        const editImageInput = document.getElementById('editImageInput');
        const editFileNameDisplay = document.getElementById('editFileName');

        if (editUploadIconBtn && editImageInput) {
            editUploadIconBtn.addEventListener('click', () => editImageInput.click());
            editImageInput.addEventListener('change', e => {
                if (editFileNameDisplay) {
                    editFileNameDisplay.textContent = e.target.files[0]?.name || '';
                }
            });
        }

        function submitEditForm(status) {
            const form = document.getElementById('editNoteForm');
            const editor = document.getElementById('editEditor');
            const hiddenContent = document.getElementById('editHiddenContent');
            const statusInput = document.getElementById('editStatusInput');

            if (editor && hiddenContent) {
                hiddenContent.value = editor.innerHTML.trim();
            }
            if (statusInput) {
                statusInput.value = status;
            }

            form.submit();
        }
    </script>
@endpush
