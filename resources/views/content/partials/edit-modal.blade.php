{{-- Modal Edit Note --}}
<div id="editModal"
    class="fixed inset-0 z-[60] hidden flex items-center justify-center transition-all duration-300 opacity-0 bg-black/60 backdrop-blur-sm pointer-events-none">
    <div id="editModalContent"
        class="relative w-[90%] max-w-[800px] max-h-[90vh] overflow-y-auto p-6 transition-all duration-300 scale-95 translate-y-8 bg-white dark:bg-slate-900 shadow-2xl rounded-2xl border border-slate-100 dark:border-slate-800/80 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-700 scrollbar-track-transparent">

        <h2 class="mb-4 text-xl font-bold text-slate-800 dark:text-slate-100">Edit Note</h2>

        <form id="editNoteForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Input Hidden Status Edit --}}
            <input type="hidden" name="status" id="editStatusInput" value="draft">

            {{-- Title --}}
            <div>
                <label class="block mb-1 text-sm font-semibold text-slate-500 dark:text-slate-400">Title</label>
                <input type="text" name="title" id="editTitle"
                    class="w-full p-2.5 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition-all"
                    placeholder="Enter title">
            </div>

            {{-- Content --}}
            <div>
                <label class="block mb-1 text-sm font-semibold text-slate-500 dark:text-slate-400">Content</label>

                {{-- Toolbar --}}
                <div
                    class="flex flex-wrap items-center gap-3 p-2 mb-2 border text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700/80 rounded-xl bg-slate-50 dark:bg-slate-950">
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="bold" title="Bold"><i class="fa-solid fa-bold"></i></button>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="italic" title="Italic"><i class="fa-solid fa-italic"></i></button>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="underline" title="Underline"><i class="fa-solid fa-underline"></i></button>
                    <div class="w-px h-4 bg-slate-200 dark:bg-slate-800"></div>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="insertUnorderedList" title="Bullet List"><i class="fa-solid fa-list-ul"></i></button>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="insertOrderedList" title="Numbered List"><i class="fa-solid fa-list-ol"></i></button>
                    <div class="w-px h-4 bg-slate-200 dark:bg-slate-800"></div>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="justifyLeft" title="Align Left"><i class="fa-solid fa-align-left"></i></button>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="justifyCenter" title="Align Center"><i class="fa-solid fa-align-center"></i></button>
                    <button type="button" class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800"
                        data-cmd="justifyRight" title="Align Right"><i class="fa-solid fa-align-right"></i></button>

                    <div class="w-px h-4 bg-slate-200 dark:bg-slate-800"></div>

                    <button type="button" id="editUploadIconBtn"
                        class="p-1 transition rounded hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-400 hover:text-indigo-500"
                        title="Change Image">
                        <i class="fa-solid fa-image"></i>
                    </button>
                    <input type="file" id="editImageInput" name="image" hidden accept="image/*">
                    <span id="editFileName" class="text-xs font-medium text-emerald-500 truncate max-w-[180px]"></span>
                </div>

                {{-- Editable area --}}
                <div id="editEditor" contenteditable="true"
                    class="w-full p-4 border border-slate-200 dark:border-slate-700 rounded-xl min-h-[220px] max-h-[400px] overflow-y-auto focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 leading-relaxed transition-all">
                </div>

                <textarea name="content" id="editHiddenContent" hidden></textarea>
            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end mt-6 space-x-2">
                <button type="button" id="closeEditBtn"
                    class="px-4 py-2 text-sm font-medium transition bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700">Cancel</button>

                {{-- Demote/Keep as Draft --}}
                <button type="button" name="status" value="draft" onclick="submitEditForm('draft')"
                    class="px-4 py-2 text-sm font-medium transition border text-slate-700 border-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 rounded-xl">
                    Save as Draft
                </button>

                {{-- Push to Live Published
                <button type="button" name="status" value="published" onclick="submitEditForm('published')"
                    class="px-5 py-2 text-sm font-medium text-white transition bg-indigo-600 shadow-lg rounded-xl hover:bg-indigo-700 shadow-indigo-600/10">
                    Publish & Sync
                </button> --}}
                <button type="button"
                    class="px-5 py-2 text-sm font-medium text-white transition bg-indigo-600 shadow-lg rounded-xl hover:bg-indigo-700 shadow-indigo-600/10"
                    onclick="document.getElementById('editStatusInput').value = 'published'; document.getElementById('editNoteForm').requestSubmit();">
                    Publish & Sync
                </button>
            </div>
        </form>

        <button type="button" id="closeEditIcon"
            class="absolute text-lg transition text-slate-400 top-4 right-4 hover:text-slate-600 dark:hover:text-slate-200">✕</button>
    </div>
</div>

<script>
    function submitEditForm(status) {
        const form = document.getElementById('editNoteForm');
        const editor = document.getElementById('editEditor');
        const hiddenContent = document.getElementById('editHiddenContent');
        const statusInput = document.getElementById('editStatusInput');

        if (!form) return;

        // 1. Amankan konten rich text editor ke textarea hidden
        if (editor && hiddenContent) {
            hiddenContent.value = editor.innerHTML.trim();
        }

        // 2. Set nilai status pada input hidden DOM
        if (statusInput) {
            statusInput.value = status;
        }

        // 3. Buat element submitter dummy untuk mengikat payload status saat requestSubmit dipicu
        const dummySubmitter = document.createElement('button');
        dummySubmitter.type = 'submit';
        dummySubmitter.name = 'status';
        dummySubmitter.value = status;
        dummySubmitter.style.display = 'none';

        form.appendChild(dummySubmitter);

        // 4. Kirim form menggunakan submitter khusus agar ditangkap oleh AJAX di scripts.blade.php secara presisi
        form.requestSubmit(dummySubmitter);

        // 5. Bersihkan element dummy dari form
        dummySubmitter.remove();
    }
</script>
