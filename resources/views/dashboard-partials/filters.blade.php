<form method="GET" action="{{ route('dashboard') }}">
    <div class="grid grid-cols-4 gap-4 mb-6">
        <!-- Firstname Filter -->
        <div class="col-span-1">
            <label for="firstname" class="block text-sm font-medium text-gray-700">
                @lang('Firstname')
            </label>
            <input type="text" name="firstname" id="firstname" value="{{ request('firstname') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Lastname Filter -->
        <div class="col-span-1">
            <label for="lastname" class="block text-sm font-medium text-gray-700">
                @lang('Lastname')
            </label>
            <input type="text" name="lastname" id="lastname" value="{{ request('lastname') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Private Number Filter -->
        <div class="col-span-1">
            <label for="private_number" class="block text-sm font-medium text-gray-700">
                @lang('Private Number')
            </label>
            <input type="text" name="private_number" id="private_number" value="{{ request('private_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Grade Filter -->
        <div class="col-span-1">
            <label for="grade" class="block text-sm font-medium text-gray-700">
                @lang('Grade')
            </label>
            <input type="number" name="grade" id="grade" value="{{ request('grade') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Group Filter -->
        <div class="col-span-1">
            <label for="group" class="block text-sm font-medium text-gray-700">
                @lang('Group')
            </label>
            <select name="group" id="group" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
                <option value="">{{ __('Select Group') }}</option>
                <option value="ა" {{ request('group') == 'ა' ? 'selected' : '' }}>ა</option>
                <option value="ბ" {{ request('group') == 'ბ' ? 'selected' : '' }}>ბ</option>
                <option value="გ" {{ request('group') == 'გ' ? 'selected' : '' }}>გ</option>
                <option value="დ" {{ request('group') == 'დ' ? 'selected' : '' }}>დ</option>
                <option value="A" {{ request('group') == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ request('group') == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ request('group') == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ request('group') == 'D' ? 'selected' : '' }}>D</option>
            </select>
        </div>

        <!-- Sector Filter -->
        <div class="col-span-1">
            <label for="sector" class="block text-sm font-medium text-gray-700">
                @lang('Sector')
            </label>
            <input type="text" name="sector" id="sector" value="{{ request('sector') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Parent Mail Filter -->
        <div class="col-span-1">
            <label for="parent_mail" class="block text-sm font-medium text-gray-700">
                @lang('Parent Mail')
            </label>
            <input type="text" name="parent_mail" id="parent_mail" value="{{ request('parent_mail') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Parent Number Filter -->
        <div class="col-span-1">
            <label for="parent_number" class="block text-sm font-medium text-gray-700">
                @lang('Parent Number')
            </label>
            <input type="text" name="parent_number" id="parent_number" value="{{ request('parent_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Pupil Status Label Filter -->
        <div class="col-span-1">
            <label for="pupil_status" class="block text-sm font-medium text-gray-700">
                @lang('Pupil Status')
            </label>
            <select name="pupil_status" id="pupil_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
                <option value="">{{ __('Select Status') }}</option>
                <option value="1" {{ request('pupil_status') == '1' ? 'selected' : '' }}>@lang('active')</option>
                <option value="-1" {{ request('pupil_status') == '-1' ? 'selected' : '' }}>@lang('past')</option>
                <option value="0" {{ request('pupil_status') == '0' ? 'selected' : '' }}>@lang('future')</option>
            </select>
        </div>


        <!-- Additional Information Filter -->
        <div class="col-span-1">
            <label for="additional_information" class="block text-sm font-medium text-gray-700">
                @lang('Additional Information')
            </label>
            <input type="text" name="additional_information" id="additional_information" value="{{ request('additional_information') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Contract End Date Filter -->
        <div class="col-span-1">
            <label for="contract_end_date" class="block text-sm font-medium text-gray-700">
                @lang('Contract End Date')
            </label>
            <select name="contract_end_date" id="contract_end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
                <option value="">{{ __('Select Year') }}</option>
                @for($year = date('Y'); $year <= date('Y') + 20; $year++)
                    <option value="{{ $year }}" {{ request('contract_end_date') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        <!-- Yearly Payment Filter -->
        <div class="col-span-1">
            <label for="yearly_payment" class="block text-sm font-medium text-gray-700">
                @lang('Yearly Payment')
            </label>
            <input type="text" name="yearly_payment" id="yearly_payment" value="{{ request('yearly_payment') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Currency Filter -->
        <div class="col-span-1">
            <label for="currency" class="block text-sm font-medium text-gray-700">
                @lang('Currency')
            </label>
            <select name="currency" id="currency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
                <option value="">{{ __('Select Currency') }}</option>
                <option value="EUR" {{ request('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                <option value="GEL" {{ request('currency') == 'GEL' ? 'selected' : '' }}>GEL</option>
            </select>
        </div>


        <!-- Parent Account Filter -->
        <div class="col-span-1">
            <label for="parent_account" class="block text-sm font-medium text-gray-700">
                @lang('Parent Account')
            </label>
            <input type="text" name="parent_account" id="parent_account" value="{{ request('parent_account') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Income Account Filter -->
        <div class="col-span-1">
            <label for="income_account" class="block text-sm font-medium text-gray-700">
                @lang('Income Account')
            </label>
            <input type="text" name="income_account" id="income_account" value="{{ request('income_account') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Payment Quantity Filter -->
        <div class="col-span-1">
            <label for="payment_quantity" class="block text-sm font-medium text-gray-700">
                @lang('Payment Quantity')
            </label>
            <input type="text" name="payment_quantity" id="payment_quantity" value="{{ request('payment_quantity') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>

        <!-- Custom Discount Filter -->
        <div class="col-span-1">
            <label for="custom_discount" class="block text-sm font-medium text-gray-700">
                @lang('Custom Discount')
            </label>
            <input type="text" name="custom_discount" id="custom_discount" value="{{ request('custom_discount') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-2 px-4">
        </div>
    </div>

    <!-- Submit and Reset Buttons -->
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 text-sm rounded">
            @lang('Filter')
        </button>

        <a href="{{ route('dashboard') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 text-sm rounded">
            @lang('Reset')
        </a>
    </div>
</form>
