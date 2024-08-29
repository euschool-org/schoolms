<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Dashboard')
        </h2>
    </x-slot>
    <div class="py-12">
        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    @include('dashboard-partials.column-selector')
                    <div class="flex justify-end">
                        <a href="{{ route('student.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                            @lang('Add New Student')
                        </a>
                    </div>
                    <!-- Students Table -->
                    @include('dashboard-partials.students-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
