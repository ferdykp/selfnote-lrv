{{-- Modal Create Note --}}
<div id="createModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-all duration-300 opacity-0 pointer-events-none bg-black/50 backdrop-blur-sm">

    <div id="createModalContent"
        class="relative w-full max-w-3xl mx-4 overflow-hidden transition-all duration-300 scale-95 translate-y-8 bg-white shadow-2xl rounded-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Create New Note</h2>
            <button id="closeCreateIcon" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        {{-- Form --}}
        <form id="createNoteForm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col h-[80vh] overflow-hidden">
            @csrf

            {{-- Body Form --}}
            <div class="flex-1 p-5 space-y-5 overflow-y-auto">

                {{-- Title --}}
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" placeholder="Enter title"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                </div>

                {{-- Content --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Content</label>

                    {{-- Toolbar --}}
                    <div class="flex flex-wrap items-center gap-3 p-2 mb-2 text-gray-700 border rounded-lg bg-gray-50">
                        <button type="button" data-cmd="bold" title="Bold"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" data-cmd="italic" title="Italic"><i
                                class="fa-solid fa-italic"></i></button>
                        <button type="button" data-cmd="underline" title="Underline"><i
                                class="fa-solid fa-underline"></i></button>
                        <button type="button" data-cmd="insertUnorderedList" title="Bullet List"><i
                                class="fa-solid fa-list-ul"></i></button>
                        <button type="button" data-cmd="insertOrderedList" title="Numbered List"><i
                                class="fa-solid fa-list-ol"></i></button>
                        <button type="button" data-cmd="justifyLeft" title="Align Left"><i
                                class="fa-solid fa-align-left"></i></button>
                        <button type="button" data-cmd="justifyCenter" title="Align Center"><i
                                class="fa-solid fa-align-center"></i></button>
                        <button type="button" data-cmd="justifyRight" title="Align Right"><i
                                class="fa-solid fa-align-right"></i></button>
                        <button type="button" id="uploadIconBtn" title="Upload Image"><i
                                class="fa-solid fa-image"></i></button>
                        <input type="file" id="imageInput" name="image" hidden>
                    </div>

                    {{-- Editor (scrollable + responsive) --}}
                    <div id="editor" contenteditable="true"
                        class="w-full p-3 border border-gray-300 rounded-lg min-h-[390px] max-h-[50vh] overflow-y-auto focus:outline-none focus:ring focus:ring-blue-200 bg-white break-words whitespace-pre-wrap text-gray-700">
                    </div>
                    <textarea name="content" id="hiddenContent" hidden></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between p-5 border-t bg-gray-50">
                <span id="fileName" class="text-sm text-gray-500"></span>
                <div class="flex space-x-2">
                    <button type="button" id="closeCreateBtn"
                        class="px-4 py-2 transition bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
