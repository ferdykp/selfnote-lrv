@extends('layouts.master')

@section('content')
    <section class="p-6 bg-gray-100">
        <div class="max-w-6xl mx-auto">

            {{-- Toast Notification Container --}}
            <div id="toastContainer" class="fixed z-50 flex flex-col space-y-3 pointer-events-none top-5 right-5"></div>

            {{-- Header --}}
            <div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
                <h1 class="text-3xl font-bold text-gray-700">My Notes</h1>

                <div class="flex flex-wrap items-center mt-3 space-x-3 md:mt-0">
                    {{-- Search --}}
                    <input type="text" id="searchInput" placeholder="Search notes..."
                        class="px-3 py-2 text-sm border rounded-lg w-60 focus:ring focus:ring-blue-200 focus:outline-none">

                    {{-- Filter Date --}}
                    <input type="date" id="dateFilter"
                        class="px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">

                    {{-- Sort --}}
                    <select id="sortSelect"
                        class="px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                        <option value="desc" selected>Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>

                    {{-- Reset --}}
                    <button id="resetFilterBtn"
                        class="px-4 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Reset
                    </button>

                    {{-- Create Note --}}
                    <button id="openModalBtn"
                        class="px-4 py-2 text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                        + Create Note
                    </button>
                </div>
            </div>

            {{-- Daftar Notes --}}
            <div id="notesContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($contents as $note)
                    <div class="relative p-4 transition bg-white shadow-md cursor-pointer note-card rounded-xl hover:shadow-lg"
                        data-id="{{ $note->id }}" data-title="{{ strtolower($note->title) }}"
                        data-date="{{ \Carbon\Carbon::parse($note->updated_at)->toDateString() }}">

                        {{-- Tombol Delete --}}
                        <form action="{{ route('content.destroy', $note->id) }}" method="POST"
                            class="absolute z-10 top-3 right-3"
                            onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus catatan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 text-red-500 transition bg-white rounded-full shadow hover:bg-red-100 hover:text-red-600">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                        {{-- Konten Note --}}
                        @if ($note->image)
                            <img src="{{ asset('storage/' . $note->image) }}" alt="note image"
                                class="object-cover w-full h-40 mb-3 rounded-lg">
                        @endif
                        <h2 class="text-lg font-semibold text-gray-800">{{ $note->title }}</h2>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-3">{!! $note->content !!}</p>
                        <p class="mt-2 text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($note->updated_at)->format('d M Y, H:i') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Modal Create Note --}}
        <div id="createModal"
            class="fixed inset-0 z-50 flex items-center justify-center hidden transition-all duration-300 opacity-0 pointer-events-none bg-black/50 backdrop-blur-sm">
            <div id="createModalContent"
                class="relative w-[800px] p-6 transition-all duration-300 scale-95 translate-y-8 bg-white shadow-xl rounded-2xl">
                <h2 class="mb-4 text-xl font-semibold">Create New Note</h2>
                <form id="createNoteForm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" placeholder="Enter title"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Content</label>
                        <div class="flex flex-wrap items-center gap-3 p-2 mb-2 border rounded-lg toolbar bg-gray-50">
                            <button type="button" data-cmd="bold"><i class="fa-solid fa-bold"></i></button>
                            <button type="button" data-cmd="italic"><i class="fa-solid fa-italic"></i></button>
                            <button type="button" data-cmd="underline"><i class="fa-solid fa-underline"></i></button>
                            <button type="button" data-cmd="insertUnorderedList"><i
                                    class="fa-solid fa-list-ul"></i></button>
                            <button type="button" data-cmd="insertOrderedList"><i class="fa-solid fa-list-ol"></i></button>
                            <button type="button" data-cmd="justifyLeft"><i class="fa-solid fa-align-left"></i></button>
                            <button type="button" data-cmd="justifyCenter"><i
                                    class="fa-solid fa-align-center"></i></button>
                            <button type="button" data-cmd="justifyRight"><i class="fa-solid fa-align-right"></i></button>
                            <button type="button" id="uploadIconBtn"><i class="fa-solid fa-image"></i></button>
                            <input type="file" id="imageInput" name="image" hidden>
                        </div>
                        <div id="editor" contenteditable="true"
                            class="w-full p-3 border border-gray-300 rounded-lg min-h-[200px] focus:outline-none focus:ring focus:ring-blue-200 bg-white">
                        </div>
                        <textarea name="content" id="hiddenContent" hidden></textarea>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <span id="fileName" class="text-sm text-gray-500"></span>
                        <div class="flex space-x-2">
                            <button type="button" id="closeCreateBtn"
                                class="px-4 py-2 transition bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">Save</button>
                        </div>
                    </div>
                </form>
                <button id="closeCreateIcon" class="absolute text-gray-500 top-3 right-3 hover:text-gray-700">✕</button>
            </div>
        </div>

        {{-- Modal Edit Note --}}
        <div id="editModal"
            class="fixed inset-0 z-[60] hidden flex items-center justify-center transition-all duration-300 opacity-0 bg-black/50 backdrop-blur-sm pointer-events-none">
            <div id="editModalContent"
                class="relative w-[800px] p-6 transition-all duration-300 scale-95 translate-y-8 bg-white shadow-2xl rounded-2xl">
                <h2 class="mb-4 text-xl font-semibold">Edit Note</h2>
                <form id="editNoteForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="editTitle"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Content</label>
                        <div class="flex flex-wrap items-center gap-3 p-2 mb-2 border rounded-lg toolbar bg-gray-50">
                            <button type="button" data-cmd="bold"><i class="fa-solid fa-bold"></i></button>
                            <button type="button" data-cmd="italic"><i class="fa-solid fa-italic"></i></button>
                            <button type="button" data-cmd="underline"><i class="fa-solid fa-underline"></i></button>
                            <button type="button" data-cmd="insertUnorderedList"><i
                                    class="fa-solid fa-list-ul"></i></button>
                            <button type="button" data-cmd="insertOrderedList"><i
                                    class="fa-solid fa-list-ol"></i></button>
                            <button type="button" data-cmd="justifyLeft"><i class="fa-solid fa-align-left"></i></button>
                            <button type="button" data-cmd="justifyCenter"><i
                                    class="fa-solid fa-align-center"></i></button>
                            <button type="button" data-cmd="justifyRight"><i
                                    class="fa-solid fa-align-right"></i></button>
                            <button type="button" id="editUploadIconBtn"><i class="fa-solid fa-image"></i></button>
                            <input type="file" id="editImageInput" name="image" hidden>
                        </div>
                        <div id="editEditor" contenteditable="true"
                            class="w-full p-3 border border-gray-300 rounded-lg min-h-[200px] focus:outline-none focus:ring focus:ring-blue-200 bg-white">
                        </div>
                        <textarea name="content" id="editHiddenContent" hidden></textarea>
                    </div>

                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" id="closeEditBtn"
                            class="px-4 py-2 transition bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </form>
                <button id="closeEditIcon" class="absolute text-gray-500 top-3 right-3 hover:text-gray-700">✕</button>
            </div>
        </div>

        {{-- SCRIPT --}}
        <script>
            const notesContainer = document.getElementById('notesContainer');

            // ===== Toolbar =====
            document.querySelectorAll('.toolbar button[data-cmd]').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.execCommand(this.dataset.cmd, false, null);
                });
            });

            // ===== Image Upload =====
            document.getElementById('uploadIconBtn').addEventListener('click', () => document.getElementById('imageInput')
                .click());
            document.getElementById('imageInput').addEventListener('change', e => {
                document.getElementById('fileName').textContent = e.target.files[0]?.name || '';
            });
            document.getElementById('editUploadIconBtn').addEventListener('click', () => document.getElementById(
                'editImageInput').click());

            // ===== Toast Notification =====
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className =
                    `toast ${type==='success'?'bg-green-500/90':'bg-red-500/90'} text-white shadow-lg rounded-xl px-4 py-3 flex items-center space-x-3 transform translate-y-[-20px] opacity-0 transition-all duration-500 ease-out`;
                toast.innerHTML =
                    `<i class="text-xl ${type==='success'?'fa-solid fa-circle-check':'fa-solid fa-circle-xmark'}"></i><span>${message}</span>`;
                toastContainer.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-[-20px]', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');
                    setTimeout(() => {
                        toast.classList.remove('translate-y-0', 'opacity-100');
                        toast.classList.add('translate-y-[-10px]', 'opacity-0');
                        setTimeout(() => toast.remove(), 500);
                    }, 2000);
                }, 10);
            }

            // ===== CREATE MODAL =====
            const createModal = document.getElementById('createModal');
            const createModalContent = document.getElementById('createModalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeCreateBtn = document.getElementById('closeCreateBtn');
            const closeCreateIcon = document.getElementById('closeCreateIcon');

            function openCreateModal() {
                createModal.classList.remove('hidden', 'pointer-events-none');
                setTimeout(() => {
                    createModal.classList.add('opacity-100');
                    createModalContent.classList.add('translate-y-0', 'scale-100');
                    createModalContent.classList.remove('translate-y-8', 'scale-95');
                }, 10);
            }

            function closeCreateModal() {
                createModal.classList.add('opacity-0');
                createModalContent.classList.add('translate-y-8', 'scale-95');
                createModalContent.classList.remove('translate-y-0', 'scale-100');
                setTimeout(() => createModal.classList.add('hidden', 'pointer-events-none'), 300);
            }

            openModalBtn.addEventListener('click', openCreateModal);
            closeCreateBtn.addEventListener('click', closeCreateModal);
            closeCreateIcon.addEventListener('click', closeCreateModal);
            createModal.addEventListener('click', e => {
                if (e.target === createModal) closeCreateModal();
            });

            // ===== CREATE NOTE AJAX =====
            document.getElementById('createNoteForm').addEventListener('submit', async e => {
                e.preventDefault();

                // Sync editor content ke textarea
                const editorContent = document.getElementById('editor').innerHTML.trim();
                document.getElementById('hiddenContent').value = editorContent;

                const form = e.target;
                const formData = new FormData(form);

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    if (!res.ok) throw new Error('Network response was not ok');

                    const note = await res.json();

                    // Tambahkan note ke DOM
                    const noteHtml = `
        <div class="relative p-4 transition bg-white shadow-md cursor-pointer note-card rounded-xl hover:shadow-lg"
             data-id="${note.id}" data-title="${note.title.toLowerCase()}" data-date="${note.updated_at.split('T')[0]}">
             ${note.image?`<img src="/storage/${note.image}" class="object-cover w-full h-40 mb-3 rounded-lg">`:''}
             <h2 class="text-lg font-semibold text-gray-800">${note.title}</h2>
             <p class="mt-1 text-sm text-gray-600 line-clamp-3">${note.content}</p>
             <p class="mt-2 text-xs text-gray-400">${new Date(note.updated_at).toLocaleString()}</p>
        </div>`;
                    notesContainer.insertAdjacentHTML('afterbegin', noteHtml);

                    // Reset form
                    form.reset();
                    document.getElementById('editor').innerHTML = '';
                    document.getElementById('fileName').textContent = '';
                    closeCreateModal();
                    showToast('Note created successfully!');
                } catch (err) {
                    console.error(err);
                    showToast('Failed to create note', 'error');
                }
            });

            // ===== EDIT MODAL =====
            const editModal = document.getElementById('editModal');
            const editModalContent = document.getElementById('editModalContent');
            const closeEditBtn = document.getElementById('closeEditBtn');
            const closeEditIcon = document.getElementById('closeEditIcon');
            const editForm = document.getElementById('editNoteForm');

            async function submitEditForm() {
                document.getElementById('editHiddenContent').value = document.getElementById('editEditor').innerHTML.trim();
                const formData = new FormData(editForm);

                // Tambahkan _method=PUT agar Laravel mengenali update
                formData.append('_method', 'PUT');

                try {
                    const res = await fetch(editForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                    const note = await res.json();

                    // Update DOM
                    const card = document.querySelector(`.note-card[data-id="${note.id}"]`);
                    if (card) {
                        card.querySelector('h2').textContent = note.title;
                        card.querySelector('p').innerHTML = note.content;
                        card.dataset.title = note.title.toLowerCase();
                        card.dataset.date = note.updated_at.split('T')[0];
                    }

                    showToast('Note updated successfully!');
                } catch (err) {
                    console.error(err);
                    showToast('Failed to update note', 'error');
                }
            }

            function closeEditModal(save = true) {
                if (save) submitEditForm();
                editModal.classList.add('opacity-0');
                editModalContent.classList.add('translate-y-8', 'scale-95');
                editModalContent.classList.remove('translate-y-0', 'scale-100');
                setTimeout(() => editModal.classList.add('hidden', 'pointer-events-none'), 300);
            }

            closeEditBtn.addEventListener('click', () => closeEditModal(true));
            closeEditIcon.addEventListener('click', () => closeEditModal(true));
            editModal.addEventListener('click', e => {
                if (e.target === editModal) closeEditModal(true)
            });

            editForm.addEventListener('submit', e => {
                e.preventDefault();
                closeEditModal(true);
            });

            // ===== OPEN EDIT MODAL =====
            notesContainer.addEventListener('click', async e => {
                const noteCard = e.target.closest('.note-card');
                if (!noteCard) return;
                const id = noteCard.dataset.id;
                try {
                    const res = await fetch(`/content/${id}`);
                    const note = await res.json();

                    editForm.action = `/content/${id}`;
                    document.getElementById('editTitle').value = note.title;
                    document.getElementById('editEditor').innerHTML = note.content || '';
                    editModal.classList.remove('hidden', 'pointer-events-none');
                    setTimeout(() => {
                        editModal.classList.add('opacity-100');
                        editModalContent.classList.add('translate-y-0', 'scale-100');
                        editModalContent.classList.remove('translate-y-8', 'scale-95');
                    }, 10);
                } catch (err) {
                    console.error(err);
                    showToast('Failed to load note for editing', 'error');
                }
            });

            // ===== SEARCH / FILTER / SORT AJAX =====
            const searchInput = document.getElementById('searchInput');
            const dateFilter = document.getElementById('dateFilter');
            const sortSelect = document.getElementById('sortSelect');
            const resetBtn = document.getElementById('resetFilterBtn');

            async function fetchFilteredNotes() {
                const params = new URLSearchParams({
                    search: searchInput.value.trim(),
                    date: dateFilter.value,
                    sort: sortSelect.value
                });
                try {
                    const res = await fetch(`/content?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const html = await res.text();
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const newNotes = tempDiv.querySelector('#notesContainer')?.innerHTML;
                    if (newNotes) notesContainer.innerHTML = newNotes;
                } catch (err) {
                    console.error(err);
                }
            }

            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(fetchFilteredNotes, 400);
            });
            dateFilter.addEventListener('change', fetchFilteredNotes);
            sortSelect.addEventListener('change', fetchFilteredNotes);
            resetBtn.addEventListener('click', () => {
                searchInput.value = '';
                dateFilter.value = '';
                sortSelect.value = 'desc';
                fetchFilteredNotes();
            });

            // ===== INITIAL TOASTS FROM SESSION =====
            @if (session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif
            @if (session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
        </script>
        <script>
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
        </script>
    </section>
@endsection
