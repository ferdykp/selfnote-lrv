@extends('layouts.master')

@section('content')
    <section class="relative w-full h-full p-6 overflow-y-auto bg-gray-50">
        <div class="mx-auto max-w-7xl">
            <h2 class="mb-6 text-2xl font-semibold text-gray-800">🗑️ Sampah Catatan</h2>

            @if ($notes->isEmpty())
                <div class="flex items-center justify-center h-64 text-gray-500 bg-white shadow-inner rounded-xl">
                    Tidak ada catatan di sampah.
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($notes as $note)
                        <div
                            class="relative flex flex-col justify-between p-5 transition bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">

                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-800 break-words line-clamp-2">
                                    {{ $note->title }}
                                </h3>

                                <div class="relative mb-3 overflow-hidden text-sm text-gray-600 max-h-24">
                                    {!! $note->content !!}
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-white to-transparent">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-400">
                                    Terhapus: {{ $note->deleted_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div class="flex justify-between gap-2 mt-4">
                                <form action="{{ route('content.restore', $note->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="w-full px-3 py-2 text-sm font-medium text-white transition bg-green-500 rounded-lg hover:bg-green-600">
                                        <i class="mr-1 fa-solid fa-rotate-left"></i> Pulihkan
                                    </button>
                                </form>

                                <form action="{{ route('content.forceDelete', $note->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="w-full px-3 py-2 text-sm font-medium text-white transition bg-red-500 rounded-lg hover:bg-red-600">
                                        <i class="mr-1 fa-solid fa-trash"></i> Hapus
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
