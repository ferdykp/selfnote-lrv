{{-- Modal Edit Note --}}
<div id="editModal"
    class="fixed inset-0 z-[60] hidden flex items-center justify-center transition-all duration-300 opacity-0 bg-black/50 backdrop-blur-sm pointer-events-none">
    <div id="editModalContent"
        class="relative w-[90%] max-w-[800px] max-h-[90vh] overflow-y-auto p-6 transition-all duration-300 scale-95 translate-y-8 bg-white shadow-2xl rounded-2xl scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Edit Note</h2>

        <form id="editNoteForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="editTitle"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none"
                    placeholder="Enter title">
            </div>

            {{-- Content --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Content</label>

                {{-- Toolbar --}}
                <div
                    class="flex flex-wrap items-center gap-3 p-2 mb-2 text-gray-600 border rounded-lg toolbar bg-gray-50">
                    <button type="button" data-cmd="bold" title="Bold"><i class="fa-solid fa-bold"></i></button>
                    <button type="button" data-cmd="italic" title="Italic"><i class="fa-solid fa-italic"></i></button>
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
                    <button type="button" id="editUploadIconBtn" title="Add Image"><i
                            class="fa-solid fa-image"></i></button>
                    <input type="file" id="editImageInput" name="image" hidden>
                </div>

                {{-- Editable area --}}
                <div id="editEditor" contenteditable="true"
                    class="w-full p-3 border border-gray-300 rounded-lg min-h-[200px] max-h-[400px] overflow-y-auto focus:outline-none focus:ring focus:ring-blue-200 bg-white text-gray-800 leading-relaxed">
                </div>

                <textarea name="content" id="editHiddenContent" hidden></textarea>
            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end mt-4 space-x-2">
                <button type="button" id="closeEditBtn"
                    class="px-4 py-2 transition bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">Update</button>
            </div>
        </form>

        <button id="closeEditIcon" class="absolute text-lg text-gray-500 top-3 right-3 hover:text-gray-700">✕</button>
    </div>
</div>
