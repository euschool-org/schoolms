<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Dashboard')
        </h2>
    </x-slot>
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <a href="{{ route('student.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                            @lang('Add New Student')
                        </a>
                    </div>
                    <!-- Students Table -->
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <th class="py-2 px-4 border-b">#</th>
                            <th class="py-2 px-4 border-b">@lang('Firstname')</th>
                            <th class="py-2 px-4 border-b">@lang('Lastname')</th>
                            <th class="py-2 px-4 border-b">@lang('Private Number')</th>
                            <th class="py-2 px-4 border-b">@lang('Grade')</th>
                            <th class="py-2 px-4 border-b">@lang('Sector')</th>
                            <th class="py-2 px-4 border-b">@lang('Parent Mail')</th>
                            <th class="py-2 px-4 border-b">@lang('Parent Number')</th>
                            <th class="py-2 px-4 border-b">@lang('Pupil Status')</th>
                            <th class="py-2 px-4 border-b">@lang('Additional Information')</th>
                        </thead>
                        <tbody>
                        <!-- Loop through students here -->
                        @foreach($students as $student)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $student->firstname }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->lastname }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->private_number }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->grade }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->sector }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->parent_mail }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->parent_number }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->pupil_status }}</td>
                                <td class="py-2 px-4 border-b">{{ $student->additional_information }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('student.edit', $student->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2" style="background: none; border: none; padding: 0; cursor: pointer;">Delete</button>
                                    </form>                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
