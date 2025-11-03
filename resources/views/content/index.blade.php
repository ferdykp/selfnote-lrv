@extends('layouts.master')

@section('content')
    <section class="min-h-screen p-6 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto"> {{-- Toast --}}
            @include('content.partials.toast-container')

            {{-- Header --}}
            <div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
                <h1 class="text-3xl font-bold text-gray-700 dark:text-gray-100">My Notes</h1>

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
    </section>
@endsection
