@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-slate-50/50 dark:bg-slate-950/20">
        <div class="max-w-6xl mx-auto">
            {{-- Header Title --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Archived Trash Bin</h2>
                <p class="text-sm text-slate-400 dark:text-slate-400">Items here are preserved until force deleted
                    permanently.</p>
            </div>

            @if ($notes->isEmpty())
                <div
                    class="flex flex-col items-center justify-center py-20 text-center bg-white border shadow-sm dark:bg-slate-900 border-slate-200/60 dark:border-slate-800/60 rounded-2xl">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-4 text-slate-400 bg-slate-50 dark:bg-slate-950 rounded-xl">
                        <i class="text-lg fa-solid fa-trash-can-slash"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Trash workspace is completely empty</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($notes as $note)
                        <div
                            class="flex flex-col justify-between p-6 transition-all bg-white border shadow-sm dark:bg-slate-900 border-slate-200/60 dark:border-slate-800/60 rounded-2xl hover:shadow-md">
                            <div>
                                <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100 line-clamp-1">
                                    {{ $note->title ?? 'Untitled Archive' }}
                                </h3>
                                <div class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-2">
                                    {!! strip_tags($note->content) !!}
                                </div>
                                <p class="mt-4 text-[11px] font-medium text-slate-400 inline-flex items-center gap-1">
                                    <i class="fa-regular fa-calendar-xmark"></i> Removed:
                                    {{ $note->deleted_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div class="flex gap-2 pt-4 mt-6 border-t border-slate-100 dark:border-slate-800/60">
                                <form action="{{ route('content.restore', $note->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 transition bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-900/50 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-950/60">
                                        <i class="fa-solid fa-arrow-rotate-left"></i> Restore
                                    </button>
                                </form>

                                <form action="{{ route('content.forceDelete', $note->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-red-600 dark:text-red-400 transition bg-red-50 dark:bg-red-950/30 border border-red-100 dark:border-red-900/50 rounded-xl hover:bg-red-100 dark:hover:bg-red-950/60">
                                        <i class="fa-solid fa-fire"></i> Purge
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
