<!-- Modal Structure -->
<div id="modal-select-column-0" class="fixed z-20 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg max-w-2xl mx-auto">
            <h2 class="text-xl font-semibold mb-4">@lang('Select Columns')</h2>

            <!-- Select Form -->
            <form id="columnSelectForm" method="POST" action="{{ route('profile.column-preference') }}">
                @csrf
                @method('PATCH')

                <!-- Split columns into two sections -->
                <div class="grid grid-cols-2 gap-6">
                    <!-- Checked Columns (Left) -->
                    <div>
                        <h3 class="text-lg font-semibold mb-2">@lang('Selected Columns')</h3>
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
                        <h3 class="text-lg font-semibold mb-2">@lang('Available Columns')</h3>
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
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="hideModal('select','column',0)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">@lang('Cancel')</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
