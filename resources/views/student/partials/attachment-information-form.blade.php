<h2 class="text-lg font-semibold mb-4">@lang('Attachments')</h2>

@if(isset($student->attachments) && $student->attachments->count())
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">#</th>
                <th class="border px-4 py-2 text-left">@lang('File Name')</th>
                <th class="border px-4 py-2 text-left">@lang('Upload Date')</th>
                <th class="border px-4 py-2 text-left">@lang('Uploader Name')</th>
                <th class="border px-4 py-2 text-left">@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($student->attachments as $attachment)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ Storage::url('attachments/' . $attachment->filename) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                        {{ $attachment->filename }}
                    </a>
                </td>
                <td class="border px-4 py-2">{{ $attachment->upload_date }}</td>
                <td class="border px-4 py-2">{{ $attachment->user->name }}</td>
                <td class="border px-4 py-2">
                    <div class="flex justify-center space-x-4">
                        <a href="{{ Storage::url('attachments/' . $attachment->filename) }}" class="text-blue-500 hover:text-blue-700" download>
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="text-red-500 hover:text-red-700 ml-2" onclick="showModal('delete', 'attachment', {{ $attachment->id }})">
                            <i class="fas fa-trash"></i>
                        </button>

                        <div id="modal-delete-attachment-{{ $attachment->id }}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                            <!-- Modal content -->
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
                                    <h2 class="text-xl font-semibold mb-4">@lang('Are you sure you want to delete this attachment?')</h2>
                                    <p class="text-gray-600">@lang('This action cannot be undone')</p>
                                    <div class="mt-6 flex justify-end space-x-4">
                                        <button onclick="hideModal('delete', 'attachment', {{ $attachment->id }})" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">@lang('Cancel')</button>
                                        <form action="{{ route('attachment.destroy', $attachment->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">@lang('Delete')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>@lang('No files found')</p>
@endif
<div class="mt-4">
    <button
        id="addAttachmentBtn"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    >
        @lang('Add New File')
    </button>
</div>

<!-- Payment Form (Initially Hidden) -->
<div id="attachmentForm" class="mt-4 hidden">
    <form action="{{ route('attachment.store',$student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="filename" class="block text-gray-700">@lang('File Name'):</label>
            <input type="text" name="filename" id="filename" class="border border-gray-300 rounded px-4 py-2 w-full" required>
            @error('filename')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="attachment" class="block text-gray-700">@lang('Attachment')</label>
            <input type="file" name="attachment" id="attachment" class="border border-gray-300 rounded px-4 py-2 w-full" required>
            @error('attachment')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            @lang('Upload Attachment')
        </button>
    </form>
</div>
