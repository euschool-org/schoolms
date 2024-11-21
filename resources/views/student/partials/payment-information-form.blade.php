<h2 class="text-lg font-semibold mb-4">@lang('Payment Information')</h2>

@if(isset($student->payments) && $student->payments->count())
    <table class="min-w-full bg-white">
        <thead>
        <tr>
            <th class="border px-4 py-2 text-left">#</th>
            <th class="border px-4 py-2 text-left">@lang('Payment Date')</th>
            <th class="border px-4 py-2 text-left">@lang('Payer Name')</th>
            <th class="border px-4 py-2 text-left">@lang('Payment Amount')</th>
            <th class="border px-4 py-2 text-left">@lang('Currency Rate')</th>
            <th class="border px-4 py-2 text-left">@lang('Nominal Amount')</th>
            <th class="border px-4 py-2 text-left">@lang('Type')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($student->payments as $payment)
            <tr>
                <td class="border px-4 py-2">{{ $payment->id }}</td>
                <td class="border px-4 py-2">{{ $payment->payment_date }}</td>
                <td class="border px-4 py-2">{{ $payment->payer_name }}</td>
                <td class="border px-4 py-2">{{ $payment->payment_amount }}</td>
                <td class="border px-4 py-2">{{ $payment->currency_rate }}</td>
                <td class="border px-4 py-2">{{ $payment->nominal_amount }}</td>
                <td class="border px-4 py-2">{{ $payment->payment_type ? __('Payment') : __('Discount') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>@lang('No payments found')</p>
@endif
<div class="mt-4">
    <button
        id="addPaymentBtn"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    >
        @lang('Add New Payment')
    </button>
</div>

<!-- Payment Form (Initially Hidden) -->
<div id="paymentForm" class="mt-4 hidden">
    <form action="{{ route('payment.store',$student->id) }}" method="POST" class="flex flex-wrap items-center">
        @csrf
        <div class="mb-4 mr-4 flex items-center">
            <input id="payment_date" name="payment_date" type="text" placeholder="@lang('Payment Date')"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   onfocus="(this.type='date')" onblur="if(this.value===''){this.type='text'}" required>
        </div>
        <div class="mb-4 mr-4 flex items-center">
            <input type="number" name="payment_amount" id="payment_amount" placeholder="@lang('Payment Amount')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
        </div>
        <div class="mb-4 mr-4 flex items-center">
            <input type="text" name="payer_name" id="payer_name" placeholder="@lang('Payer Name')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
        </div>

        <div class="mb-4 mr-4 flex items-center">
            <button type="submit" class="px-4 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </button>
        </div>
    </form>
</div>
