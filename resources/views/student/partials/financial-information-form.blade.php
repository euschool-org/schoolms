<div class="bg-white sm:rounded-lg mt-4">
    <div>
        <span class="text-sm font-bold text-gray-600 mb-2">
            @lang("Financial Information")
        </span>
    </div>
    <form action="{{ route('student.update', $student->id) }}" method="POST" class="grid grid-cols-5 gap-6">
        @csrf
        @method('PUT')

        <div class="col-span-1">
            <input type="text" id="yearly_payment" name="yearly_payment" placeholder="@lang('Yearly Payment')" value="{{ old('yearly_payment', $student->yearly_payment ?? '') }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('monthly_payment')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="monthly_payment" name="monthly_payment" placeholder="@lang('Monthly Payment')" value="{{ old('monthly_payment', $student->monthly_payment ?? '') }}"  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('monthly_payment')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1 mt-1">
            <x-select-dropdown :options="['EUR', 'GEL', 'USD']" label="Currency" name="currency" value="{{$student->currency}}" />
            @error('currency')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="parent_account" name="parent_account" placeholder="@lang('Parent Account')" value="{{ old('parent_account', $student->parent_account ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('parent_account')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="income_account" name="income_account" placeholder="@lang('Income Account')" value="{{ old('income_account', $student->income_account ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('income_account')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1 mt-1">
            <x-select-dropdown :options="['monthly', 'yearly', 'quarterly']" label="Payment Type" name="payment_type" value="{{$student->currency}}" />
            @error('payment_quantity')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="custom_discount" name="custom_discount" placeholder="@lang('Custom Discount')" value="{{ old('custom_discount', $student->custom_discount ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('custom_discount')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="balance" name="balance" placeholder="@lang('Balance')" value="{{ old('balance', $student->balance ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('balance')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


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
</div>
