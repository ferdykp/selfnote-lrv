<div class="relative note-card flex flex-col justify-between p-6 transition-all duration-300 bg-white border cursor-pointer group dark:bg-slate-900 border-slate-200/60 dark:border-slate-800/60 rounded-2xl hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-xl hover:shadow-slate-100 dark:hover:shadow-none hover:-translate-y-0.5"
    data-id="{{ $note->id }}" data-timestamp="{{ \Carbon\Carbon::parse($note->updated_at)->getTimestamp() * 1000 }}"
    data-title="{{ strtolower($note->title) }}"
    data-date="{{ \Carbon\Carbon::parse($note->updated_at)->toDateString() }}">

    {{-- Container untuk Status Badge & Delete Button --}}
    <div class="absolute z-10 flex items-center space-x-2 top-4 right-4">

        {{-- FIX 1: Menampilkan Badge Status Mengikuti Data Database Saat Reload --}}
        @if ($note->status === 'published')
            <span
                class="px-2 py-0.5 text-[10px] font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-md">
                <i class="mr-1 fa-solid fa-globe"></i>Published
            </span>
        @else
            <span
                class="px-2 py-0.5 text-[10px] font-semibold text-slate-500 bg-slate-100 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-md">
                <i class="mr-1 fa-solid fa-file-lines"></i>Draft
            </span>
        @endif

        {{-- Floating Delete Button - Hanya muncul penuh saat card di-hover --}}
        <form action="{{ route('content.destroy', $note->id) }}" method="POST"
            class="transition-all duration-200 opacity-0 group-hover:opacity-100 delete-form">
            @csrf
            @method('DELETE')
            <button type="button"
                class="flex items-center justify-center w-8 h-8 transition-all bg-white border rounded-lg shadow-sm text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:border-slate-700 hover:shadow"
                onclick="openConfirmModal(event, this)">
                <i class="text-xs fa-solid fa-trash-can"></i>
            </button>
        </form>
    </div>

    <div>
        {{-- FIX 2: Menyesuaikan properti dari $note->image ke $note->images sesuai skema database --}}
        @if ($note->images)
            <div class="w-full mb-4 overflow-hidden border h-44 rounded-xl border-slate-100 dark:border-slate-800">
                <img src="{{ asset('storage/' . $note->images) }}"
                    class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
            </div>
        @endif

        {{-- Note Title --}}
        <h3
            class="mt-2 text-lg font-semibold tracking-tight break-words transition-colors text-slate-800 dark:text-slate-100 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
            {{ $note->title ?? 'Untitled Note' }}
        </h3>

        {{-- Content Preview --}}
        <div class="relative mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-3">
            {!! strip_tags($note->content) !!}
        </div>
    </div>

    {{-- Footer Meta info --}}
    <div class="flex items-center justify-between pt-4 mt-5 border-t border-slate-100 dark:border-slate-800/80">
        <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 font-medium">
            <i class="text-[10px] fa-regular fa-clock"></i>
            {{ \Carbon\Carbon::parse($note->updated_at)->timezone('Asia/Jakarta')->format('d M, H:i') }}
        </span>
        <span
            class="flex items-center gap-1 text-xs font-semibold text-indigo-500 transition-opacity duration-200 opacity-0 group-hover:opacity-100">
            Open <i class="text-[10px] fa-solid fa-arrow-right"></i>
        </span>
    </div>
</div>
