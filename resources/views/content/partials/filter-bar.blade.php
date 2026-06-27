<div
    class="flex flex-col items-start justify-between gap-4 pt-4 pb-6 mb-6 transition-colors duration-300 border-b border-slate-200 dark:border-slate-900 md:flex-row md:items-center">
    <div>
        <h1 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-100">My Notebook</h1>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Manage and organize your thoughts beautifully.</p>
    </div>

    <div class="flex flex-wrap items-center w-full gap-2 md:w-auto">
        {{-- Search Input --}}
        <div class="relative flex-1 md:flex-initial">
            <i
                class="absolute text-xs -translate-y-1/2 fa-solid fa-magnifying-glass left-3 top-1/2 text-slate-400 dark:text-slate-500"></i>
            <input type="text" id="searchInput" placeholder="Quick search..."
                class="w-full md:w-48 pl-8 pr-3 py-1.5 text-xs transition-all border rounded-lg bg-white border-slate-200 dark:bg-slate-900/60 dark:border-slate-800 text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none">
        </div>

        {{-- Date Picker --}}
        <input type="date" id="dateFilter"
            class="px-2.5 py-1.5 text-xs transition-all border rounded-lg bg-white border-slate-200 dark:bg-slate-900/60 dark:border-slate-800 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:outline-none">

        {{-- Sort --}}
        <select id="sortSelect"
            class="px-2.5 py-1.5 text-xs transition-all border cursor-pointer rounded-lg bg-white border-slate-200 dark:bg-slate-900/60 dark:border-slate-800 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:outline-none">
            <option value="desc" selected>Newest</option>
            <option value="asc">Oldest</option>
        </select>

        {{-- Reset Button --}}
        <button id="resetFilterBtn"
            class="p-2 transition bg-white border rounded-lg border-slate-200 text-slate-400 hover:text-slate-600 dark:bg-slate-900/60 dark:border-slate-800 dark:hover:text-slate-200 dark:hover:bg-slate-900">
            <i class="text-xs fa-solid fa-arrow-rotate-left"></i>
        </button>

        {{-- Create Button --}}
        {{-- <button id="openModalBtn"
            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white transition-all bg-indigo-600 rounded-lg hover:bg-indigo-500 shadow-sm focus:outline-none shadow-indigo-600/10">
            <i class="text-[10px] fa-solid fa-plus"></i> New Note
        </button> --}}
        <a href="{{ route('content.create') }}"
            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white transition-all bg-indigo-600 rounded-lg hover:bg-indigo-500 shadow-sm focus:outline-none shadow-indigo-600/10">
            <i class="text-[10px] fa-solid fa-plus"></i> New Note
        </a>
    </div>
</div>
