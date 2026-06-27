@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-slate-50/50 dark:bg-slate-950/20">
        <div class="max-w-6xl mx-auto">

            {{-- Toast Container --}}
            @include('content.partials.toast-container')

            {{-- Filter & Control Bar --}}
            @include('content.partials.filter-bar')

            {{-- Notes Grid --}}
            <div id="notesContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @forelse ($contents as $note)
                    @include('content.partials.note-card', ['note' => $note])
                @empty
                    <div class="py-20 text-sm font-medium text-center text-slate-400 dark:text-slate-600 col-span-full">
                        Belum ada catatan yang tersimpan.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Modals --}}
        {{-- @include('content.partials.create-modal')
        @include('content.partials.edit-modal') --}}
        @include('content.partials.confirm-modal')
    </section>
@endsection

@push('scripts')
    <script>
        let currentForm = null;

        function openConfirmModal(event, button) {
            event.stopPropagation();
            currentForm = button.closest('form');
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentForm = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentForm) currentForm.submit();
        });
    </script>
@endpush
