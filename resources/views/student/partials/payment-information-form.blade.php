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
            <th class="border px-4 py-2 text-left">@lang('Percentage')</th>
            <th class="border px-4 py-2 text-left">@lang('Type')</th>
            <th class="border px-4 py-2 text-left">@lang('Description')</th>
            <th class="border px-4 py-2 text-left">@lang('Actions')</th>
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
                <td class="border px-4 py-2">{{ $payment->percentage }}%</td>
                <td class="border px-4 py-2">{{ $payment->payment_type_label}}</td>
                <td class="border px-4 py-2">{{ $payment->description}}</td>
                <td class="border px-4 py-2">
                    <div class="flex justify-center space-x-4">
                        <button class="text-red-500 hover:text-red-700 ml-2" onclick="showModal('delete', 'payment', {{ $payment->id }})">
                            <i class="fas fa-trash"></i>
                        </button>

                        <div id="modal-delete-payment-{{ $payment->id }}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                            <!-- Modal content -->
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
                                    <h2 class="text-xl font-semibold mb-4">@lang('Are you sure you want to delete this payment?')</h2>
                                    <p class="text-gray-600">@lang('This action cannot be undone')</p>
                                    <div class="mt-6 flex justify-end space-x-4">
                                        <button onclick="hideModal('delete', 'payment', {{ $payment->id }})" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">@lang('Cancel')</button>
                                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">@lang('Delete')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <input type="text" name="payment_amount" id="payment_amount" placeholder="@lang('Payment Amount')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
        </div>
        <div class="mb-4 mr-4 flex items-center">
            <input type="text" name="payer_name" id="payer_name" placeholder="@lang('Payer Name')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div class="mb-4 mr-4 flex items-center">
            <input type="text" name="description" id="description" placeholder="@lang('Description')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div class="mb-4 mr-4 flex items-center">
            <select name="payment_type" id="payment_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                <option value="0"> გადახდა </option>
                <option value="1"> 5% ფასდაკლება </option>
                <option value="2"> 10% ფასდაკლება </option>
                <option value="3"> ინდივიდუალური ფასდაკლება </option>
            </select>
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
