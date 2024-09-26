<!-- Modal Structure -->
<div id="modal-select-column-0" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">@lang('Select Columns')</h2>

            <!-- Select Form -->
            <form id="columnSelectForm" method="POST" action="{{ route('profile.column-preference') }}">
                @csrf
                @method('PATCH')
                <!-- Checkboxes for column selection -->
                <div class="mb-4">
                    @foreach($allColumns as $column)
                        <label>
                            <input type="checkbox" name="columns[]" value="{{$column}}" {{ in_array($column, $selectedColumns) ? 'checked' : '' }}>
                            {{__(ucwords(str_replace('_',' ',$column)))}}
                        </label>
                        <br>
                    @endforeach

                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" onclick="hideModal('select','column',0)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">@lang('Cancel')</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
