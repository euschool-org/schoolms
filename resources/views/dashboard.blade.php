<x-app-layout>
    <div class="py-12">
        @if (session('success'))
                @include('dashboard-partials.success_modal')
        @endif
        @include('dashboard-partials.column-selector')
        @include('dashboard-partials.import_modal')
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 mb-4">
                <div>
                    @include('dashboard-partials.filters')
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 pt-4 text-gray-900">
                        @include('dashboard-partials.students-table')
                </div>
                <div class="flex justify-between items-center mt-4">
                    <!-- Excel Download Button -->
                    <div class="flex space-x-2">
                        <!-- Download Excel Button -->
                        <a href="{{ route('student.export') }}" class="flex items-center space-x-1 text-gray-600 bg-gray-100 border rounded-lg px-3 py-1 ml-2 hover:bg-gray-200 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-8m0 8l-3-3m3 3l3-3M9 3h6v4h-6V3z" />
                            </svg>
                            <span>ჩამოტვირთე Excel</span>
                        </a>
                        <!-- Upload Excel Button -->
                        <button type="button" class="flex items-center space-x-1 text-gray-600 bg-gray-100 border rounded-lg px-3 py-1 hover:bg-gray-200 text-sm" onclick="showModal('import','file',0)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0-8l3 3m-3-3l-3 3M9 3h6v4H9V3z" />
                            </svg>
                            <span>ატვირთე Excel</span>
                        </button>
                    </div>

                    <!-- Pagination Links -->
                    <div>
                        {{ $students->appends(request()->except('page'))->appends(['per_page' => request('per_page')])->onEachSide(1)->links() }}
                    </div>
                    <!-- Pagination Control Section -->
                    <div class="flex items-center justify-center space-x-2 px-4 py-2 ml-4" style="background-color: inherit;">
                        <!-- Label -->
                        <span class="text-sm font-medium">@lang('Show')</span>
                        <!-- Form with Select Dropdown -->
                        <form action="{{ route('dashboard') }}" method="GET" class="inline-flex items-center">
                            <div class="relative">
                                <select name="per_page" id="per_page" class="appearance-none px-4 py-1 text-sm rounded-md focus:outline-none focus:ring focus:ring-blue-500 pr-8 bg-gray-100" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <!-- Label after Dropdown -->
                            <span class="ml-2 text-sm">@lang('Entries')</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
