<table class="w-full bg-white border border-gray-300 table-auto text-sm">
    <thead>
    <tr>
        <th class="py-2 px-4 border-b text-left">#</th>
        @foreach($selectedColumns as $column)
            <th class="py-2 px-4 border-b text-left">{{__(ucwords(str_replace('_',' ',$column)))}}</th>
        @endforeach
        <th class="py-2 px-4 border-b text-left">@lang('Actions')</th>
    </tr>
    </thead>
    <tbody>
    <!-- Loop through students here -->
    @foreach($students as $student)
        <tr>
            <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
            @foreach($selectedColumns as $column)
                <td class="py-2 px-4 border-b">{{ $student->$column }}</td>
            @endforeach
            <td class="py-2 px-4 border-b">
                <!-- Edit Button -->
                <a href="{{ route('student.edit', $student->id) }}" class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-edit"></i>
                </a>

                <!-- Delete Button triggers the modal -->
                <button class="text-red-500 hover:text-red-700 ml-2" onclick="showModal('delete', 'student', {{ $student->id }})">
                    <i class="fas fa-trash"></i>
                </button>

                <div id="modal-delete-student-{{ $student->id }}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <!-- Modal content -->
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
                            <h2 class="text-xl font-semibold mb-4">@lang('Are you sure you want to delete this student?')</h2>
                            <p class="text-gray-600">@lang('This action cannot be undone')</p>
                            <div class="mt-6 flex justify-end space-x-4">
                                <button onclick="hideModal('delete', 'student', {{ $student->id }})" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">@lang('Cancel')</button>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">@lang('Delete')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
