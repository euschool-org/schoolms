<form action="{{ route('student.update', $student->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
    @csrf
    @method('PUT')

    <div class="col-span-1">
        <label for="contract_end_date" class="block text-sm font-medium text-gray-700">@lang('Contract End Date')</label>
        <select id="contract_end_date" name="contract_end_date" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="">@lang('Select Year')</option>
            @for ($year = now()->year; $year <= now()->year + 20; $year++)
                <option value="{{ $year }}" {{ old('contract_end_date', $student->contract_end_date ?? '') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
        @error('contract_end_date')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="monthly_payment" class="block text-sm font-medium text-gray-700">@lang('Monthly Payment')</label>
        <input type="text" id="monthly_payment" name="monthly_payment" value="{{ old('monthly_payment', $student->monthly_payment ?? '') }}"  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('monthly_payment')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="yearly_payment" class="block text-sm font-medium text-gray-700">@lang('Yearly Payment')</label>
        <input type="text" id="yearly_payment" name="yearly_payment" value="{{ old('yearly_payment', $student->monthly_payment*10 ?? '') }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <div class="col-span-1">
        <label for="currency" class="block text-sm font-medium text-gray-700">@lang('Currency')</label>
        <select id="currency" name="currency" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="EUR" {{ old('currency', $student->currency ?? '') == 'EUR' ? 'selected' : '' }}>@lang('EUR')</option>
            <option value="USD" {{ old('currency', $student->currency ?? '') == 'USD' ? 'selected' : '' }}>@lang('USD')</option>
            <option value="GEL" {{ old('currency', $student->currency ?? '') == 'GEL' ? 'selected' : '' }}>@lang('GEL')</option>
        </select>
        @error('currency')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="parent_account" class="block text-sm font-medium text-gray-700">@lang('Parent Account')</label>
        <input type="text" id="parent_account" name="parent_account" value="{{ old('parent_account', $student->parent_account ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('parent_account')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="income_account" class="block text-sm font-medium text-gray-700">@lang('Income Account')</label>
        <input type="text" id="income_account" name="income_account" value="{{ old('income_account', $student->income_account ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('income_account')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="payment_quantity" class="block text-sm font-medium text-gray-700">@lang('Payment Quantity')</label>
        <input type="text" id="payment_quantity" name="payment_quantity" value="{{ old('payment_quantity', $student->payment_quantity ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('payment_quantity')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="discount" class="block text-sm font-medium text-gray-700">@lang('Discount')</label>
        <input type="text" id="discount" name="discount" value="{{ old('discount', $student->discount ?? '') }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('discount')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="custom_discount" class="block text-sm font-medium text-gray-700">@lang('Custom Discount')</label>
        <input type="text" id="custom_discount" name="custom_discount" value="{{ old('custom_discount', $student->custom_discount ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('custom_discount')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="balance" class="block text-sm font-medium text-gray-700">@lang('Balance')</label>
        <input type="text" id="balance" name="balance" value="{{ old('balance', $student->balance ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('balance')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="parent_mail" class="block text-sm font-medium text-gray-700">@lang('Parent Mail')</label>
        <input type="email" id="parent_mail" name="parent_mail" value="{{ old('parent_mail', $student->parent_mail ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('parent_mail')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="parent_number" class="block text-sm font-medium text-gray-700">@lang('Parent Number')</label>
        <input type="text" id="parent_number" name="parent_number" value="{{ old('parent_number', $student->parent_number ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('parent_number')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="email_notifications" class="block text-sm font-medium text-gray-700">@lang('Email Notifications')</label>
        <input type="checkbox" id="email_notifications" name="email_notifications" {{ old('email_notifications', $student->email_notifications ?? false) ? 'checked' : '' }} class="mt-1 block">
        @error('email_notifications')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="mobile_notifications" class="block text-sm font-medium text-gray-700">@lang('Mobile Notifications')</label>
        <input type="checkbox" id="mobile_notifications" name="mobile_notifications" {{ old('mobile_notifications', $student->mobile_notifications ?? false) ? 'checked' : '' }} class="mt-1 block">
        @error('mobile_notifications')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2 flex justify-end">
        <button type="submit" class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600">Update</button>
    </div>
</form>
