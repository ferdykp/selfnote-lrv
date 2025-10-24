{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        // ===== CREATE MODAL =====
        const openModalBtn = document.getElementById('openModalBtn');
        const closeCreateBtn = document.getElementById('closeCreateBtn');
        const closeCreateIcon = document.getElementById('closeCreateIcon');
        const createModal = document.getElementById('createModal');
        const createModalContent = document.getElementById('createModalContent');

        if (createModal && openModalBtn) {
            function openCreateModal() {
                createModal.classList.remove('hidden', 'pointer-events-none');
                setTimeout(() => {
                    createModal.classList.add('opacity-100');
                    createModal.classList.remove('opacity-0');
                    createModalContent.classList.remove('translate-y-8', 'scale-95');
                    createModalContent.classList.add('translate-y-0', 'scale-100');
                }, 10);
            }

            function closeCreateModal() {
                createModal.classList.add('opacity-0');
                createModal.classList.remove('opacity-100');
                createModalContent.classList.add('translate-y-8', 'scale-95');
                createModalContent.classList.remove('translate-y-0', 'scale-100');
                setTimeout(() => {
                    createModal.classList.add('hidden', 'pointer-events-none');
                }, 300);
            }

            openModalBtn.addEventListener('click', openCreateModal);
            closeCreateBtn.addEventListener('click', closeCreateModal);
            closeCreateIcon.addEventListener('click', closeCreateModal);
            createModal.addEventListener('click', (e) => {
                if (e.target === createModal) closeCreateModal();
            });
        }

        // ===== TOAST ANIMATION =====
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach((toast, index) => {
            setTimeout(() => {
                toast.classList.remove('translate-y-[-20px]', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-[-10px]', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }, 2000);
            }, index * 150);
        });
    });
</script> --}}
