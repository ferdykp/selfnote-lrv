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

                    // Gunakan upsertNoteInDOM secara konsisten
                    upsertNoteInDOM(note);

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

            // ===== SUBMIT EDIT FORM =====
            async function submitEditForm() {
                // Sync editor content ke hidden textarea
                document.getElementById('editHiddenContent').value = document.getElementById('editEditor').innerHTML.trim();
                const formData = new FormData(editForm);
                formData.append('_method', 'PUT');

                try {
                    const res = await fetch(editForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    if (!res.ok) throw new Error('Network response was not ok');

                    const note = await res.json();

                    // Gunakan upsertNoteInDOM secara konsisten
                    upsertNoteInDOM(note);

                    showToast('Note updated successfully!');
                } catch (err) {
                    console.error(err);
                    showToast('Failed to update note', 'error');
                }
            }

            // ===== CLOSE EDIT MODAL =====
            async function closeEditModal(save = true) {
                if (save) await submitEditForm();
                editModal.classList.add('opacity-0');
                editModalContent.classList.add('translate-y-8', 'scale-95');
                editModalContent.classList.remove('translate-y-0', 'scale-100');
                setTimeout(() => editModal.classList.add('hidden', 'pointer-events-none'), 300);
            }

            // Event listeners
            closeEditBtn.addEventListener('click', async () => await closeEditModal(true));
            closeEditIcon.addEventListener('click', async () => await closeEditModal(true));
            editModal.addEventListener('click', async e => {
                if (e.target === editModal) await closeEditModal(true);
            });
            editForm.addEventListener('submit', async e => {
                e.preventDefault();
                await closeEditModal(true);
            });



            // ===== OPEN EDIT MODAL =====
            notesContainer.addEventListener('click', async e => {
                const noteCard = e.target.closest('.note-card');
                if (!noteCard) return;
                const id = noteCard.dataset.id;
                try {
                    const res = await fetch(`/content/${id}`);
                    const note = await res.json();
                    upsertNoteInDOM(note);

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
            function upsertNoteInDOM(note) {
                const cardDate = note.updated_at ? new Date(note.updated_at) : new Date();
                const timestamp = cardDate.getTime();

                // Hapus card lama jika ada
                let card = document.querySelector(`.note-card[data-id="${note.id}"]`);
                if (card) card.remove();

                // Template HTML baru, sama dengan Blade
                const noteHtml = `
<div class="relative p-4 transition bg-white shadow-md cursor-pointer note-card rounded-xl hover:shadow-lg"
     data-id="${note.id}" data-timestamp="${timestamp}"
     data-title="${note.title.toLowerCase()}" data-date="${cardDate.toISOString().split('T')[0]}">

     <form action="/content/${note.id}" method="POST" class="absolute z-10 bottom-3 right-3 delete-form">
         @csrf
         @method('DELETE')
         <button type="button"
             class="p-2 text-red-500 transition bg-white rounded-full shadow hover:bg-red-100 hover:text-red-600"
             onclick="openConfirmModal(event, this)">
             <i class="fa-solid fa-trash"></i>
         </button>
     </form>

     ${note.image ? `<img src="/storage/${note.image}" class="object-cover w-full h-40 mb-3 rounded-lg">` : ''}

     <h2 class="text-lg font-semibold text-gray-800 break-words line-clamp-2">${note.title}</h2>

     <div class="relative mt-1 overflow-hidden text-sm text-gray-600 max-h-20 note-content">
         ${note.content}
         <div class="absolute bottom-0 left-0 w-full h-6 "></div>
     </div>

     <p class="mt-2 text-xs text-gray-400">
        ${cardDate.toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' })},
        ${cardDate.toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' })}
     </p>
</div>`;


                notesContainer.insertAdjacentHTML('afterbegin', noteHtml);

                // Urutkan ulang notes
                const allCards = Array.from(notesContainer.querySelectorAll('.note-card'));
                allCards.sort((a, b) => b.dataset.timestamp - a.dataset.timestamp);
                allCards.forEach(c => notesContainer.appendChild(c));
            }
        </script>
        <script>
            document.addEventListener('paste', function(e) {
                const editor = document.querySelector('#editor');
                if (editor && editor.contains(document.activeElement)) {
                    e.preventDefault();
                    const text = e.clipboardData.getData('text/plain');
                    document.execCommand('insertText', false, text);
                }
            });
        </script>

        <!-- Dark Mode Script -->
        <script>
            const toggle = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const html = document.documentElement;

            // Apply saved theme
            if (localStorage.getItem('theme') === 'dark') {
                html.classList.add('dark');
                icon.classList.replace('fa-moon', 'fa-sun');
            }

            toggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                icon.classList.toggle('fa-moon', !isDark);
                icon.classList.toggle('fa-sun', isDark);
            });
        </script>
