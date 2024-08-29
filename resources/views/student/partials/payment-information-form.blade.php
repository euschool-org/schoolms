<h2 class="text-lg font-semibold mb-4">@lang('Payment Information')</h2>

@if(isset($student->payments) && $student->payments->count())
    <table class="min-w-full bg-white">
        <thead>
        <tr>
            <th class="border px-4 py-2 text-left">#</th>
            <th class="border px-4 py-2 text-left">@lang('Payment Date')</th>
            <th class="border px-4 py-2 text-left">@lang('Payer Name')</th>
            <th class="border px-4 py-2 text-left">@lang('Payment Amount')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($student->payments as $payment)
            <tr>
                <td class="border px-4 py-2">{{ $payment->id }}</td>
                <td class="border px-4 py-2">{{ $payment->payment_date }}</td>
                <td class="border px-4 py-2">{{ $payment->payer_name }}</td>
                <td class="border px-4 py-2">{{ $payment->payment_amount }}</td>
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
    <form action="{{ route('payment.store',$student->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="payment_date" class="block text-gray-700">@lang('Payment Date'):</label>
            <input type="date" name="payment_date" id="payment_date" class="border border-gray-300 rounded px-4 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="payment_amount" class="block text-gray-700">@lang('Payment Amount'):</label>
            <input type="number" name="payment_amount" id="payment_amount" class="border border-gray-300 rounded px-4 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="payer_name" class="block text-gray-700">@lang('Payer Name'):</label>
            <input type="text" name="payer_name" id="payer_name" class="border border-gray-300 rounded px-4 py-2 w-full" required>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            @lang('Submit Payment')
        </button>
    </form>
</div>
