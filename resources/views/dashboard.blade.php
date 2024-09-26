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
                <div class="p-4 text-gray-900">
                    <div class="overflow-x-auto">
                        @include('dashboard-partials.students-table')
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <div>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="per_page">@lang('Show')</label>
                            <select name="per_page" id="per_page" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            @lang('entries')
                        </form>
                    </div>
                    <div>
                        {{ $students->appends(['per_page' => request('per_page')])->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
