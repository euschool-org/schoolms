<x-app-layout>
    <div class="py-12">
        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
        @include('dashboard-partials.column-selector')
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
                    <!-- Pagination Control Section -->
                    <div class="flex items-center justify-center space-x-2 px-4 py-2 ml-4" style="background-color: inherit;">
                        <!-- Label -->
                        <span class="text-sm font-medium">@lang('ერთი გვერდზე')</span>
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
                            <span class="ml-2 text-sm">@lang('შედეგი')</span>
                        </form>
                    </div>
                    <!-- Pagination Links -->
                    <div>
                        {{ $students->appends(['per_page' => request('per_page')])->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
