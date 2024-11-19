<div class="text-sm font-bold text-gray-600 mb-2">
        <span >
            @lang("Annual Fee Information")
        </span>
</div>
@if(isset($student->annual_fees) && $student->annual_fees->count())
    <form method="POST" action="{{ route('fee.update', $student->id) }}">
        @csrf
        @method('PUT')

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="border px-4 py-2 text-left">#</th>
                <th class="border px-4 py-2 text-left">@lang('Year')</th>
                <th class="border px-4 py-2 text-left">@lang('Fee')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($student->annual_fees as $fee)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $fee->display_year }}</td>
                    <td class="border px-4 py-2">
                        <input type="hidden" name="fees[{{ $fee->id }}][id]" value="{{ $fee->id }}">
                        <input type="number" name="fees[{{ $fee->id }}][fee]"
                               value="{{ $fee->fee }}"
                               class="w-full px-2 py-1"
                               style="appearance: none; -moz-appearance: textfield; -webkit-appearance: none; border: none; outline: none;">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-4 col-span-5">
            <!-- Cancel/Reset button with X icon -->
            <button type="reset" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Submit button with V icon -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </button>
        </div>
    </form>
@else
    <p>@lang('Fill Contract Dates')</p>
@endif


