@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto">

            {{-- Toast --}}
            @include('content.partials.toast-container')

            {{-- Header (sticky) --}}
            <div
                class="sticky top-0 z-50 flex flex-col items-start justify-between px-8 py-3 mb-6 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900 md:flex-row md:items-center">
                <h1 class="text-3xl font-bold text-gray-700 dark:text-gray-100">Selfnote</h1>

                <div class="flex flex-wrap items-center mt-3 space-x-3 md:mt-0">
                    <input type="text" id="searchInput" placeholder="Search notes..."
                        class="px-3 py-2 text-sm border rounded-lg w-60 focus:ring focus:ring-blue-200 focus:outline-none">

                    <input type="date" id="dateFilter"
                        class="px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">

                    <select id="sortSelect"
                        class="px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                        <option value="desc" selected>Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>

                    <button id="resetFilterBtn"
                        class="px-4 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Reset
                    </button>

                    <button id="openModalBtn"
                        class="px-4 py-2 text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                        + Create Note
                    </button>
                </div>
            </div>

            {{-- Notes --}}
            <div id="notesContainer" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($contents as $note)
                    @include('content.partials.note-card', ['note' => $note])
                @endforeach
            </div>
        </div>

        {{-- Modal Create --}}
        @include('content.partials.create-modal')

        {{-- Modal Edit --}}
        @include('content.partials.edit-modal')

        <!-- Modal Konfirmasi Global -->
        <div id="confirmModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/40 backdrop-blur-sm">
            <div class="p-6 text-center bg-white shadow-lg rounded-xl w-80">
                <h2 class="mb-3 text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                <p class="mb-5 text-sm text-gray-600">Apakah kamu yakin ingin menghapus catatan ini?</p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeConfirmModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            </div>
        </div>

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
    </section>
@endsection
