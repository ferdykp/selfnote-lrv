<div class="relative p-4 transition bg-white shadow-md cursor-pointer note-card rounded-xl hover:shadow-lg"
    data-id="{{ $note->id }}" data-title="{{ strtolower($note->title) }}"
    data-date="{{ \Carbon\Carbon::parse($note->updated_at)->toDateString() }}">

    <form action="{{ route('content.destroy', $note->id) }}" method="POST"
        class="absolute z-10 bottom-3 right-3 delete-form">
        @csrf
        @method('DELETE')
        <button type="button"
            class="p-2 text-red-500 transition bg-white rounded-full shadow hover:bg-red-100 hover:text-red-600"
            onclick="openConfirmModal(event, this)">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>

    @if ($note->image)
        <img src="{{ asset('storage/' . $note->image) }}" class="object-cover w-full h-40 mb-3 rounded-lg">
    @endif

    <h2 class="text-lg font-semibold text-gray-800 break-words line-clamp-2">
        {{ $note->title }}
    </h2>

    <div class="relative mt-1 overflow-hidden text-sm text-gray-600 max-h-20">
        {!! $note->content !!}
        <div class="absolute bottom-0 left-0 w-full h-6"></div>
    </div>

    <p class="mt-2 text-xs text-gray-400">
        {{ \Carbon\Carbon::parse($note->updated_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
    </p>
</div>
