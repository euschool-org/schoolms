<div class="text-sm font-bold text-gray-600 mb-2">
    <span>
        @lang("Annual Fee Information")
    </span>
</div>

@if(isset($student->monthly_fees) && $student->monthly_fees->count())
    <form method="POST" action="{{ route('fee.update') }}">
        @csrf
        @method('PUT')

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="border px-4 py-2 text-left">#</th>
                <th class="border px-4 py-2 text-left">@lang('School Year')</th>
                <th class="border px-4 py-2 text-left">@lang('Total Fee')</th>
                <th class="border px-4 py-2 text-left">@lang('Actions')</th>
            </tr>
            </thead>
            <tbody>
            @php
                $groupedFees = $student->monthly_fees->groupBy('school_year');
            @endphp

            @foreach($groupedFees as $schoolYear => $fees)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $schoolYear }}</td>
                    <td class="border px-4 py-2">
                        {{ $fees->sum('fee') }} {{ $student->currency->symbol ?? '' }}
                    </td>
                    <td class="border px-4 py-2">
                        <button type="button" class="text-blue-500 hover:underline"
                                onclick="document.getElementById('fees-{{ $loop->iteration }}').classList.toggle('hidden')">
                            @lang('View/Edit')
                        </button>
                    </td>
                </tr>
                <tr id="fees-{{ $loop->iteration }}" class="hidden">
                    <td colspan="4" class="border px-4 py-2">
                        <table class="min-w-full bg-gray-100">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2 text-left">#</th>
                                <th class="border px-4 py-2 text-left">@lang('Month')</th>
                                <th class="border px-4 py-2 text-left">@lang('Fee')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fees as $monthlyFee)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $monthlyFee->month->format('F Y') }}</td>
                                    <td class="border px-4 py-2">
                                        <input type="hidden" name="fees[{{ $monthlyFee->id }}][id]" value="{{ $monthlyFee->id }}">
                                        <input type="number" name="fees[{{ $monthlyFee->id }}][fee]"
                                               value="{{ $monthlyFee->fee }}"
                                               class="w-full px-2 py-1 border rounded">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <!-- Cancel/Reset button -->
            <button type="reset" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Submit button -->
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
