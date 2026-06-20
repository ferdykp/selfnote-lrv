<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col items-center justify-between w-20 py-6 transition-colors duration-300 bg-white border-r border-slate-200 dark:bg-slate-950 dark:border-slate-900">

    <div
        class="flex items-center justify-center w-10 h-10 text-white bg-indigo-600 border border-indigo-500 shadow-sm rounded-xl dark:bg-slate-900 dark:border-slate-800">
        <i class="text-base text-white dark:text-indigo-400 fa-solid fa-feather-pointed"></i>
    </div>

    <div class="flex flex-col items-center flex-1 py-10 space-y-4">
        {{-- All Notes --}}
        <div class="relative group">
            <a href="{{ route('content.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-200 {{ request()->routeIs('content.index') ? 'bg-slate-100 text-indigo-600 border border-slate-200 dark:bg-slate-900 dark:text-indigo-400 dark:border-slate-800 shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100/80 dark:text-slate-500 dark:hover:text-slate-300 dark:hover:bg-slate-900/50' }}">
                <i class="text-base fa-solid fa-grid-2"></i>
            </a>
            <div
                class="absolute z-50 px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-200 dark:text-slate-200 dark:bg-slate-900 dark:border-slate-800 rounded-lg shadow-xl opacity-0 left-14 top-1/2 -translate-y-1/2 pointer-events-none group-hover:opacity-100 transition-all duration-150 whitespace-nowrap">
                All Notes
            </div>
        </div>

        {{-- Trash Bin --}}
        <div class="relative group">
            <a href="{{ route('content.trash') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-200 {{ request()->routeIs('content.trash') ? 'bg-red-50 text-red-600 border border-red-100 dark:bg-slate-900 dark:text-red-400 dark:border-slate-800 shadow-sm' : 'text-slate-400 hover:text-slate-800 hover:bg-slate-100/80 dark:text-slate-500 dark:hover:text-slate-300 dark:hover:bg-slate-900/50' }}">
                <i class="text-base fa-solid fa-trash-can"></i>
            </a>
            <div
                class="absolute z-50 px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-200 dark:text-slate-200 dark:bg-slate-900 dark:border-slate-800 rounded-lg shadow-xl opacity-0 left-14 top-1/2 -translate-y-1/2 pointer-events-none group-hover:opacity-100 transition-all duration-150 whitespace-nowrap">
                Trash Bin
            </div>
        </div>

        <div class="w-6 my-1 border-b border-slate-200 dark:border-slate-900"></div>

        {{-- Preferences --}}
        <div class="relative group">
            <a href="#"
                class="flex items-center justify-center w-10 h-10 transition-all duration-200 text-slate-400 hover:text-slate-800 dark:text-slate-500 dark:hover:text-slate-300 rounded-xl hover:bg-slate-100/80 dark:hover:bg-slate-900/50">
                <i class="text-base fa-solid fa-sliders"></i>
            </a>
            <div
                class="absolute z-50 px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-200 dark:text-slate-200 dark:bg-slate-900 dark:border-slate-800 rounded-lg shadow-xl opacity-0 left-14 top-1/2 -translate-y-1/2 pointer-events-none group-hover:opacity-100 transition-all duration-150 whitespace-nowrap">
                Preferences
            </div>
        </div>
    </div>

    {{-- Theme Switcher --}}
    <div class="relative group">
        <button id="themeToggle"
            class="flex items-center justify-center w-10 h-10 transition-all duration-200 rounded-xl text-slate-400 hover:text-slate-800 hover:bg-slate-100/80 dark:text-slate-500 dark:hover:text-slate-300 dark:hover:bg-slate-900/50">
            <i id="themeIcon" class="text-base fa-solid fa-moon"></i>
        </button>
    </div>
</aside>
