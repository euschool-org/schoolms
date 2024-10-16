<div class="flex" id="tableContainer">
    <div class="sticky left-0 bg-white z-10 flex-shrink-0">
        <table id="leftTable" class="table-fixed bg-white border border-gray-300 text-sm">
            <thead class="bg-gray-100">
            <tr>
                <th class="py-1 px-4 border-b text-center">#</th>
                <th class="min-h-5 border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">@lang('Pupil Status')</th>
                <th class="min-h-5 border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">@lang('Name')</th>
                <th class="min-h-5 border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">@lang('Private Number')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                @php
                    $statusColor = match($student->pupil_status) {
                        1 => 'bg-green-200 text-green-800',
                        -1 => 'bg-red-200 text-red-800',
                        0 => 'bg-yellow-200 text-yellow-800',
                        default => 'bg-gray-200 text-gray-800',
                    };
                @endphp
                <tr class="hover:bg-gray-100" data-row-id="{{ $loop->index }}">
                    <td class="min-h-5 border border-gray-300 px-6 py-1 text-center">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-6 py-1 text-center truncate">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                            {{ $student->pupil_status_label }}
                        </span>
                    </td>
                    <td class="border border-gray-300 px-6 py-1 text-center truncate">
                        <a href="{{ route('student.edit', $student->id) }}">
                            {{ $student->name }}
                        </a>
                    </td>
                    <td class="border border-gray-300 px-6 py-1 text-center truncate">
                        <a href="{{ route('student.edit', $student->id) }}">
                            {{ $student->private_number }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto flex-grow">
        <table id="rightTable" class="table-auto bg-white border border-gray-300 text-sm">
            <thead class="bg-gray-100">
            <tr>
                @foreach($selectedColumns as $index => $column)
                    <th class="min-h-5 border border-gray-300 px-6 py-1 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __(ucwords(str_replace('_',' ', $column))) }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr class="hover:bg-gray-100" data-row-id="{{ $loop->index }}">
                    @foreach($selectedColumns as $index => $column)
                        <td class="min-h-5 border border-gray-300 px-6 py-1 text-center truncate">
                            {{ $student->$column }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
