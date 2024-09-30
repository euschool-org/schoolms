<!-- Modal Structure -->
<div id="modal-select-column-0" class="fixed z-20 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg max-w-2xl mx-auto relative">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-4">
                <h2 class="text-xl font-semibold mb-0">@lang('შეცვალე ცხრილი')</h2>
                <!-- Close Button (X) -->
                <button type="button" onclick="hideModal('select','column',0)" class="text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Select Form -->
            <form id="columnSelectForm" method="POST" action="{{ route('profile.column-preference') }}">
                @csrf
                @method('PATCH')

                <!-- Split columns into two sections -->
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <!-- Checked Columns (Left) -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2">@lang('ყველა ინორმაცია')</h3>
                        @foreach($allColumns as $column)
                            @if(in_array($column, $selectedColumns))
                                <label class="block">
                                    <input type="checkbox" name="columns[]" value="{{$column}}" checked>
                                    {{__(ucwords(str_replace('_',' ',$column)))}}
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <!-- Unchecked Columns (Right) -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2">@lang('ინფორმაცია ცხრილში')</h3>
                        @foreach($allColumns as $column)
                            @if(!in_array($column, $selectedColumns))
                                <label class="block">
                                    <input type="checkbox" name="columns[]" value="{{$column}}">
                                    {{__(ucwords(str_replace('_',' ',$column)))}}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @lang('შენახვა')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
