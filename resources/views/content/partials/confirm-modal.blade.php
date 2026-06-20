<div id="confirmModal" class="fixed inset-0 z-[100] items-center justify-center hidden bg-slate-950/40 backdrop-blur-sm">
    <div
        class="p-6 text-center duration-150 bg-white border shadow-2xl dark:bg-slate-900 dark:border-slate-800 rounded-2xl w-80 animate-in fade-in zoom-in-95">
        <div
            class="flex items-center justify-center w-12 h-12 mx-auto mb-4 text-red-500 rounded-xl bg-red-50 dark:bg-red-950/40">
            <i class="text-lg fa-solid fa-triangle-exclamation"></i>
        </div>
        <h2 class="mb-1 text-base font-bold text-slate-800 dark:text-white">Delete Document?</h2>
        <p class="mb-5 text-sm text-slate-500 dark:text-slate-400">This item will be moved to the Trash workspace
            section.</p>
        <div class="flex justify-center gap-2">
            <button type="button" onclick="closeConfirmModal()"
                class="flex-1 px-4 py-2 text-xs font-semibold bg-white border text-slate-600 dark:text-slate-300 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50">
                Cancel
            </button>
            <button type="button" id="confirmDeleteBtn"
                class="flex-1 px-4 py-2 text-xs font-semibold text-white bg-red-600 shadow-sm rounded-xl hover:bg-red-700 shadow-red-600/10">
                Confirm
            </button>
        </div>
    </div>
</div>
