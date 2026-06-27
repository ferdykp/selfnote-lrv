{{-- SCRIPT UTAMA APLIKASI --}}
{{-- <script>
    const notesContainer = document.getElementById('notesContainer');

    // ===== 1. TEXT EDITOR TOOLBAR (RICH TEXT) =====
    document.querySelectorAll('.toolbar button[data-cmd]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.execCommand(this.dataset.cmd, false, null);
        });
    });

    // ===== 2. IMAGE UPLOAD HANDLING =====
    const uploadIconBtn = document.getElementById('uploadIconBtn');
    const imageInput = document.getElementById('imageInput');
    const editUploadIconBtn = document.getElementById('editUploadIconBtn');
    const editImageInput = document.getElementById('editImageInput');
    const fileNameDisplay = document.getElementById('fileName');
    const editFileNameDisplay = document.getElementById('editFileName');

    if (uploadIconBtn && imageInput) {
        uploadIconBtn.addEventListener('click', () => imageInput.click());
        imageInput.addEventListener('change', e => {
            fileNameDisplay.textContent = e.target.files[0]?.name || '';
        });
    }

    if (editUploadIconBtn && editImageInput) {
        editUploadIconBtn.addEventListener('click', () => editImageInput.click());
        editImageInput.addEventListener('change', e => {
            if (editFileNameDisplay) {
                editFileNameDisplay.textContent = e.target.files[0]?.name || '';
            }
        });
    }

    // ===== 3. PREMIUM TOAST NOTIFICATION =====
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className =
            `toast ${type === 'success' ? 'bg-emerald-500/90 border border-emerald-400/20' : 'bg-rose-500/90 border border-rose-400/20'} text-white shadow-xl rounded-xl px-4 py-3 flex items-center space-x-3 transform translate-y-[-20px] opacity-0 transition-all duration-500 ease-out backdrop-blur-md`;
        toast.innerHTML =
            `<i class="text-lg ${type === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'}"></i><span class="text-xs font-medium">${message}</span>`;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-y-[-20px]', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-10px]', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 2500);
        }, 10);
    }

    // ===== 4. CREATE MODAL SYSTEM =====
    const createModal = document.getElementById('createModal');
    const createModalContent = document.getElementById('createModalContent');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeCreateBtn = document.getElementById('closeCreateBtn');
    const closeCreateIcon = document.getElementById('closeCreateIcon');

    function openCreateModal() {
        if (!createModal || !createModalContent) return;
        createModal.classList.remove('hidden', 'pointer-events-none');
        setTimeout(() => {
            createModal.classList.add('opacity-100');
            createModalContent.classList.add('translate-y-0', 'scale-100');
            createModalContent.classList.remove('translate-y-4', 'scale-95');
        }, 10);
    }

    function closeCreateModal() {
        if (!createModal || !createModalContent) return;
        createModal.classList.add('opacity-0');
        createModalContent.classList.add('translate-y-4', 'scale-95');
        createModalContent.classList.remove('translate-y-0', 'scale-100');
        setTimeout(() => createModal.classList.add('hidden', 'pointer-events-none'), 300);
    }

    if (openModalBtn) openModalBtn.addEventListener('click', openCreateModal);
    if (closeCreateBtn) closeCreateBtn.addEventListener('click', closeCreateModal);
    if (closeCreateIcon) closeCreateIcon.addEventListener('click', closeCreateModal);
    if (createModal) {
        createModal.addEventListener('click', e => {
            if (e.target === createModal) closeCreateModal();
        });
    }

    // ===== 5. AJAX CREATE NOTE SUBMIT =====
    // ===== 5. AJAX CREATE NOTE SUBMIT =====
    const createNoteForm = document.getElementById('createNoteForm');
    if (createNoteForm) {
        createNoteForm.addEventListener('submit', async e => {
            e.preventDefault();

            const editorContent = document.getElementById('editor').innerHTML.trim();
            document.getElementById('hiddenContent').value = editorContent;

            // Ambil semua data form, otomatis termasuk #createStatusInput yang sudah diubah nilainya
            const formData = new FormData(createNoteForm);

            try {
                const res = await fetch(createNoteForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (!res.ok) throw new Error('Server error');

                const note = await res.json();
                upsertNoteInDOM(note);

                createNoteForm.reset();
                document.getElementById('editor').innerHTML = '';
                if (fileNameDisplay) fileNameDisplay.textContent = '';
                closeCreateModal();

                // Toast notifikasi dinamis menyesuaikan status dari server
                showToast(note.status === 'published' ? 'Note published to portfolio!' :
                    'Draft saved successfully!');
            } catch (err) {
                console.error(err);
                showToast('Failed to save note', 'error');
            }
        });
    }

    // ===== 6. EDIT MODAL SYSTEM =====
    const editModal = document.getElementById('editModal');
    const editModalContent = document.getElementById('editModalContent');
    const closeEditBtn = document.getElementById('closeEditBtn');
    const closeEditIcon = document.getElementById('closeEditIcon');
    const editForm = document.getElementById('editNoteForm');

    // Fungsi untuk menutup modal secara visual (tanpa proses submit)
    function hideEditModal() {
        if (!editModal || !editModalContent) return;
        editModal.classList.add('opacity-0');
        editModalContent.classList.add('translate-y-4', 'scale-95');
        editModalContent.classList.remove('translate-y-0', 'scale-100');
        setTimeout(() => editModal.classList.add('hidden', 'pointer-events-none'), 300);
    }

    // Pasang event listener untuk tombol close / cancel
    if (closeEditBtn) closeEditBtn.addEventListener('click', hideEditModal);
    if (closeEditIcon) closeEditIcon.addEventListener('click', hideEditModal);
    if (editModal) {
        editModal.addEventListener('click', e => {
            if (e.target === editModal) hideEditModal();
        });
    }

    // Interseptor Event Submit Form Edit (AJAX yang sesungguhnya)
    if (editForm) {
        editForm.addEventListener('submit', async e => {
            e.preventDefault();

            // Pindahkan content terbaru dari div contenteditable ke hidden textarea
            document.getElementById('editHiddenContent').value = document.getElementById('editEditor')
                .innerHTML.trim();

            const formData = new FormData(editForm);
            formData.append('_method', 'PUT');

            // ====================================================================
            // FIX: Amankan dan kunci nilai status terbaru agar pasti terkirim ke Laravel
            // ====================================================================
            const currentEditStatus = document.getElementById('editStatusInput')?.value || 'draft';
            formData.set('status', currentEditStatus);
            // ====================================================================

            try {
                const res = await fetch(editForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (!res.ok) {
                    const errorData = await res.json().catch(() => ({}));
                    console.error('Validation/Server Errors:', errorData);
                    throw new Error('Update failed');
                }

                const note = await res.json();

                // 1. Perbarui tampilan card di DOM secara real-time
                upsertNoteInDOM(note);

                // 2. TUTUP MODAL setelah sukses tersimpan
                hideEditModal();

                // 3. Tampilkan Toast Notification sesuai status
                showToast(note.status === 'published' ? 'Note synced & live on portfolio!' :
                    'Changes saved as draft!');
            } catch (err) {
                console.error(err);
                showToast('Failed to update note', 'error');
            }
        });
    }

    // Penutupan Modal Edit yang Fleksibel (save = true/false)
    async function closeEditModal(save = true) {
        if (!editModal || !editModalContent) return;
        if (save) await submitEditForm();

        editModal.classList.add('opacity-0');
        editModalContent.classList.add('translate-y-4', 'scale-95');
        editModalContent.classList.remove('translate-y-0', 'scale-100');
        setTimeout(() => editModal.classList.add('hidden', 'pointer-events-none'), 300);
    }

    if (closeEditBtn) closeEditBtn.addEventListener('click', () => closeEditModal(false));
    if (closeEditIcon) closeEditIcon.addEventListener('click', () => closeEditModal(false));
    if (editModal) {
        editModal.addEventListener('click', e => {
            if (e.target === editModal) closeEditModal(false);
        });
    }
    if (editForm) {
        editForm.addEventListener('submit', async e => {
            e.preventDefault();
            await closeEditModal(true);
        });
    }

    // ===== 7. OPEN EDIT MODAL VIA CLICK EVENT =====
    if (notesContainer) {
        notesContainer.addEventListener('click', async e => {
            if (e.target.closest('.delete-form') ||
                e.target.closest('button[onclick*="openConfirmModal"]') ||
                e.target.closest('#confirmModal')) {
                return;
            }

            const noteCard = e.target.closest('.note-card');
            if (!noteCard) return;

            const id = noteCard.dataset.id;
            if (!id) return;

            try {
                const res = await fetch(`/content/${id}`);
                if (!res.ok) throw new Error('Data fetch failed');

                const note = await res.json();

                if (editForm) editForm.action = `/content/${id}`;

                const editTitleEl = document.getElementById('editTitle');
                const editEditorEl = document.getElementById('editEditor');
                const editStatusInput = document.getElementById('editStatusInput');

                if (editTitleEl) editTitleEl.value = note.title || '';
                if (editEditorEl) editEditorEl.innerHTML = note.content || '';
                if (editStatusInput) editStatusInput.value = note.status || 'draft';
                if (editFileNameDisplay) editFileNameDisplay.textContent = '';

                if (editModal && editModalContent) {
                    editModal.classList.remove('hidden', 'pointer-events-none');
                    setTimeout(() => {
                        editModal.classList.add('opacity-100');
                        editModalContent.classList.remove('translate-y-4', 'scale-95',
                            'translate-y-8');
                        editModalContent.classList.add('translate-y-0', 'scale-100');
                    }, 30);
                }
            } catch (err) {
                console.error('Error detail:', err);
                showToast('Failed to load note data', 'error');
            }
        });
    }

    // ===== 8. AJAX SEARCH / FILTER / SORT SYSTEM =====
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const sortSelect = document.getElementById('sortSelect');
    const resetBtn = document.getElementById('resetFilterBtn');

    async function fetchFilteredNotes() {
        if (!notesContainer) return;
        const params = new URLSearchParams({
            search: searchInput?.value.trim() || '',
            date: dateFilter?.value || '',
            sort: sortSelect?.value || 'desc'
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
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(fetchFilteredNotes, 400);
        });
    }
    if (dateFilter) dateFilter.addEventListener('change', fetchFilteredNotes);
    if (sortSelect) sortSelect.addEventListener('change', fetchFilteredNotes);
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (dateFilter) dateFilter.value = '';
            if (sortSelect) sortSelect.value = 'desc';
            fetchFilteredNotes();
        });
    }

    // ===== 9. SYSTEM FLASH MESSAGES =====
    @if (session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if (session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
</script> --}}

{{-- SCRIPT METADATA DOM SINKRONISASI --}}
{{-- <script>
    function upsertNoteInDOM(note) {
        if (!notesContainer) return;

        const cardDate = note.updated_at ? new Date(note.updated_at) : new Date();
        const timestamp = cardDate.getTime();

        const allCardsData = Array.from(notesContainer.querySelectorAll('.note-card')).map(card => {
            return {
                id: card.dataset.id,
                timestamp: parseInt(card.dataset.timestamp) || 0,
                html: card.outerHTML
            };
        });

        const dateText = cardDate.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short'
        });
        const timeText = cardDate.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        // Tentukan template badge status publikasi secara dinamis
        const statusBadgeHtml = note.status === 'published' ?
            `<span class="px-2 py-0.5 text-[10px] font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-md"><i class="mr-1 fa-solid fa-globe"></i>Published</span>` :
            `<span class="px-2 py-0.5 text-[10px] font-semibold text-slate-500 bg-slate-100 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-md"><i class="mr-1 fa-solid fa-file-lines"></i>Draft</span>`;

        // Siapkan string template HTML dengan pembaruan variabel field 'images'
        const newNoteHtml = `
<div class="relative note-card flex flex-col justify-between p-6 transition-all duration-300 bg-white border cursor-pointer group dark:bg-slate-900 border-slate-200/60 dark:border-slate-800/60 rounded-2xl hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-xl hover:shadow-slate-100 dark:hover:shadow-none hover:-translate-y-0.5"
    data-id="${note.id}" data-timestamp="${timestamp}" data-title="${note.title.toLowerCase()}" data-date="${cardDate.toISOString().split('T')[0]}">

    <div class="absolute z-10 flex items-center space-x-2 top-4 right-4">
        ${statusBadgeHtml}
        <form action="/content/${note.id}" method="POST" class="transition-all duration-200 opacity-0 group-hover:opacity-100 delete-form">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="button"
                class="flex items-center justify-center w-8 h-8 transition-all bg-white border rounded-lg shadow-sm text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:border-slate-700 hover:shadow"
                onclick="openConfirmModal(event, this)">
                <i class="text-xs fa-solid fa-trash-can"></i>
            </button>
        </form>
    </div>

    <div class="mt-2">
        ${note.images ? `
            <div class="w-full mb-4 overflow-hidden border h-44 rounded-xl border-slate-100 dark:border-slate-800">
                <img src="/storage/${note.images}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
            </div>
        ` : ''}

        <h3 class="text-lg font-semibold tracking-tight break-words transition-colors text-slate-800 dark:text-slate-100 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
            ${note.title || 'Untitled Note'}
        </h3>

        <div class="relative mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-3">
            ${note.content ? note.content.replace(/<\/?[^>]+(>|$)/g, "") : ''}
        </div>
    </div>

    <div class="flex items-center justify-between pt-4 mt-5 border-t border-slate-100 dark:border-slate-800/80">
        <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 font-medium">
            <i class="text-[10px] fa-regular fa-clock"></i>
            ${dateText}, ${timeText}
        </span>
        <span class="flex items-center gap-1 text-xs font-semibold text-indigo-500 transition-opacity duration-200 opacity-0 group-hover:opacity-100">
            Open <i class="text-[10px] fa-solid fa-arrow-right"></i>
        </span>
    </div>
</div>`;

        const existingIndex = allCardsData.findIndex(c => String(c.id) === String(note.id));

        if (existingIndex !== -1) {
            allCardsData[existingIndex].timestamp = timestamp;
            allCardsData[existingIndex].html = newNoteHtml;
        } else {
            allCardsData.push({
                id: note.id,
                timestamp: timestamp,
                html: newNoteHtml
            });
        }

        const currentSort = document.getElementById('sortSelect')?.value || 'desc';
        allCardsData.sort((a, b) => {
            return currentSort === 'desc' ? (b.timestamp - a.timestamp) : (a.timestamp - b.timestamp);
        });

        notesContainer.innerHTML = '';
        allCardsData.forEach(cardObj => {
            notesContainer.insertAdjacentHTML('beforeend', cardObj.html);
        });
    }
</script> --}}

{{-- SECURITY PASTE & THEME SYSTEM --}}
{{-- <script>
    // Format Plaintext saat Paste di Editor Rich Text
    document.addEventListener('paste', function(e) {
        const editor = document.querySelector('#editor');
        const editEditor = document.querySelector('#editEditor');
        if ((editor && editor.contains(document.activeElement)) || (editEditor && editEditor.contains(document
                .activeElement))) {
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            document.execCommand('insertText', false, text);
        }
    });

    // Dark Mode LocalStorage Engine
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');
    const html = document.documentElement;

    function syncThemeIcon() {
        if (html.classList.contains('dark')) {
            if (icon) icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            if (icon) icon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    syncThemeIcon();

    if (toggle) {
        toggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            syncThemeIcon();
        });
    }
</script> --}}

{{-- SCRIPT UTAMA APLIKASI --}}
<script>
    const notesContainer = document.getElementById('notesContainer');

    // ===== 1. PREMIUM TOAST NOTIFICATION =====
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className =
            `toast ${type === 'success' ? 'bg-emerald-500/90 border border-emerald-400/20' : 'bg-rose-500/90 border border-rose-400/20'} text-white shadow-xl rounded-xl px-4 py-3 flex items-center space-x-3 transform translate-y-[-20px] opacity-0 transition-all duration-500 ease-out backdrop-blur-md`;
        toast.innerHTML =
            `<i class="text-lg ${type === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'}"></i><span class="text-xs font-medium">${message}</span>`;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-y-[-20px]', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-10px]', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 2500);
        }, 10);
    }

    // ===== 2. REDIRECT KE HALAMAN EDIT SAAT KARTU DIKLIK =====
    if (notesContainer) {
        notesContainer.addEventListener('click', e => {
            // Amankan tombol hapus/fitur confirm modal bawaan index agar tidak ikut terpicu redirect
            if (e.target.closest('.delete-form') ||
                e.target.closest('button[onclick*="openConfirmModal"]') ||
                e.target.closest('#confirmModal')) {
                return;
            }

            const noteCard = e.target.closest('.note-card');
            if (!noteCard) return;

            const id = noteCard.dataset.id;
            if (id) {
                // Arahkan user ke halaman edit spesifik
                window.location.href = `/content/${id}/edit`;
            }
        });
    }

    // ===== 3. AJAX SEARCH / FILTER / SORT SYSTEM (Tetap Dipertahankan) =====
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const sortSelect = document.getElementById('sortSelect');
    const resetBtn = document.getElementById('resetFilterBtn');

    async function fetchFilteredNotes() {
        if (!notesContainer) return;
        const params = new URLSearchParams({
            search: searchInput?.value.trim() || '',
            date: dateFilter?.value || '',
            sort: sortSelect?.value || 'desc'
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
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(fetchFilteredNotes, 400);
        });
    }
    if (dateFilter) dateFilter.addEventListener('change', fetchFilteredNotes);
    if (sortSelect) sortSelect.addEventListener('change', fetchFilteredNotes);
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (dateFilter) dateFilter.value = '';
            if (sortSelect) sortSelect.value = 'desc';
            fetchFilteredNotes();
        });
    }

    // ===== 4. SYSTEM FLASH MESSAGES =====
    @if (session('success'))
        showToast("{{ session('success') }}", 'success');
    @endif
    @if (session('status'))
        showToast("{{ session('status') }}", 'success');
    @endif
    @if (session('error'))
        showToast("{{ session('error') }}", 'error');
    @endif
</script>

{{-- SECURITY PASTE & THEME SYSTEM --}}
<script>
    // Format Plaintext saat Paste di Rich Text (Create & Edit page)
    document.addEventListener('paste', function(e) {
        const editor = document.querySelector('#editor');
        const editEditor = document.querySelector('#editEditor');
        if ((editor && editor.contains(document.activeElement)) || (editEditor && editEditor.contains(document
                .activeElement))) {
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            document.execCommand('insertText', false, text);
        }
    });

    // Dark Mode LocalStorage Engine
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');
    const html = document.documentElement;

    function syncThemeIcon() {
        if (html.classList.contains('dark')) {
            if (icon) icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            if (icon) icon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    syncThemeIcon();

    if (toggle) {
        toggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            syncThemeIcon();
        });
    }
</script>
