<div id="createModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-all duration-300 opacity-0 pointer-events-none bg-slate-950/40 backdrop-blur-md">

    <div id="createModalContent"
        class="relative w-full max-w-2xl mx-4 overflow-hidden transition-all duration-300 scale-95 translate-y-4 bg-white border shadow-2xl dark:bg-slate-900 rounded-2xl border-slate-200/80 dark:border-slate-800/80">

        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">Draft New Note</h2>
            <button type="button" id="closeCreateIcon"
                class="text-sm transition text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">✕</button>
        </div>

        <form id="createNoteForm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Input Hidden untuk menampung status penulisan --}}
            <input type="hidden" name="status" id="createStatusInput" value="draft">

            <div class="p-6 space-y-4">
                <input type="text" name="title" placeholder="Untitled Note"
                    class="w-full px-0 py-1 text-2xl font-bold bg-transparent border-0 border-b border-transparent focus:border-slate-100 dark:focus:border-slate-800 focus:ring-0 focus:outline-none placeholder-slate-300 dark:placeholder-slate-700 text-slate-800 dark:text-white">

                <div
                    class="flex flex-wrap items-center gap-1.5 p-1.5 border rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400">
                    <button type="button" data-cmd="bold"
                        class="w-8 h-8 transition rounded-lg hover:bg-white dark:hover:bg-slate-900 hover:text-slate-800 dark:hover:text-white"
                        title="Bold"><i class="text-xs fa-solid fa-bold"></i></button>
                    <button type="button" data-cmd="italic"
                        class="w-8 h-8 transition rounded-lg hover:bg-white dark:hover:bg-slate-900 hover:text-slate-800 dark:hover:text-white"
                        title="Italic"><i class="text-xs fa-solid fa-italic"></i></button>
                    <button type="button" data-cmd="insertUnorderedList"
                        class="w-8 h-8 transition rounded-lg hover:bg-white dark:hover:bg-slate-900 hover:text-slate-800 dark:hover:text-white"
                        title="List"><i class="text-xs fa-solid fa-list-ul"></i></button>
                    <div class="w-px h-4 mx-1 bg-slate-200 dark:bg-slate-800"></div>
                    <button type="button" id="uploadIconBtn"
                        class="flex items-center gap-1 px-2.5 h-8 text-xs font-medium rounded-lg hover:bg-white dark:hover:bg-slate-900 hover:text-slate-800 dark:hover:text-white transition border border-transparent hover:border-slate-200/60 dark:hover:border-slate-800"
                        title="Attach Image">
                        <i class="fa-solid fa-image"></i> <span>Cover Image</span>
                    </button>
                    <input type="file" id="imageInput" name="image" hidden accept="image/*">
                </div>

                <div id="editor" contenteditable="true" placeholder="Start typing your ideas here..."
                    class="w-full min-h-[260px] max-h-[45vh] overflow-y-auto focus:outline-none bg-transparent text-sm leading-relaxed text-slate-700 dark:text-slate-300 break-words prose dark:prose-invert">
                </div>
                <textarea name="content" id="hiddenContent" hidden></textarea>
            </div>

            {{-- Footer dengan Dual Actions Button --}}
            <div
                class="flex items-center justify-between px-6 py-4 border-t bg-slate-50/50 dark:bg-slate-950/30 border-slate-100 dark:border-slate-800/80">
                <span id="fileName" class="max-w-xs text-xs font-medium text-indigo-500 truncate"></span>
                <div class="flex items-center space-x-2">
                    <button type="button" id="closeCreateBtn"
                        class="px-4 py-2 text-sm font-medium transition bg-white border dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Cancel</button>

                    {{-- Tombol Save Draft --}}
                    <button type="button" onclick="submitCreateForm('draft')"
                        class="px-4 py-2 text-sm font-medium transition border text-slate-700 border-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 rounded-xl">
                        Save Draft
                    </button>

                    {{-- Tombol Publish --}}
                    <button type="button" onclick="submitCreateForm('published')"
                        class="px-5 py-2 text-sm font-medium text-white transition bg-indigo-600 shadow-sm rounded-xl hover:bg-indigo-700 shadow-indigo-600/10">
                        Publish to Blog
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function submitCreateForm(status) {
        const form = document.getElementById('createNoteForm');
        const editor = document.getElementById('editor');
        const hiddenContent = document.getElementById('hiddenContent');
        const statusInput = document.getElementById('createStatusInput');

        if (!form) return;

        // 1. Amankan konten text editor ke textarea hidden
        if (editor && hiddenContent) {
            hiddenContent.value = editor.innerHTML.trim();
        }

        // 2. Set nilai status dengan pasti ke dalam value input hidden
        if (statusInput) {
            statusInput.value = status;
        }

        // 3. Trigger submit biasa, biarkan scripts.blade.php yang menangani AJAX-nya
        form.requestSubmit();
    }
</script>
