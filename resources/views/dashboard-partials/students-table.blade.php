<table class="w-full bg-white border border-gray-300 table-auto text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-1 px-4 border-b text-center">#</th>
            @foreach($selectedColumns as $column)
                <th class="border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">{{__(ucwords(str_replace('_',' ',$column)))}}</th>
            @endforeach
            <th class="border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider"></th>
        </tr>
    </thead>
    <tbody class="bg-white">
    <!-- Loop through students here -->
    @foreach($students as $student)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 px-6 py-1">{{ $loop->iteration }}</td>
            @foreach($selectedColumns as $column)
                <td class="border border-gray-300 px-6 py-1 text-center truncate">
                    @if($column == 'pupil_status_label')
                        @php
                            // Define a variable to store the background color based on the status
                            $statusColor = match($student->pupil_status) {
                                1 => 'bg-green-200 text-green-800',
                                -1 => 'bg-red-200 text-red-800',
                                0 => 'bg-yellow-200 text-yellow-800',
                                default => 'bg-gray-200 text-gray-800', // Fallback color
                            };
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                        {{ __($student->$column) }}
                    </span>
                    @else
                        {{ $student->$column }}
                    @endif
                </td>
            @endforeach
            <td class="px-3 py-1 text-center border border-gray-300">
                <!-- Edit Button -->
                <a href="{{ route('student.edit', $student->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
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
