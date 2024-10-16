<div class="mb-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-2">
        <!-- Header Title -->
        <div class="text-lg font-semibold">
            მოსწავლეების ცხრილი
        </div>

        <!-- Button on the right -->
        <a href="{{ route('student.create') }}" class="flex items-center space-x-1 text-blue-500 border border-blue-500 rounded px-4 py-2 hover:bg-blue-50">
            <span>👤</span> <!-- You can replace this with an actual icon -->
            <span>დამატე მოსწავლე</span>
        </a>
    </div>

    <!-- Blue underline for active section -->
    <div class="border-b-2 border-gray-200">
        <div class="border-b-2 border-blue-500 w-20"></div> <!-- Blue indicator, you can adjust the width -->
    </div>

    <!-- Filter Section -->
    <div class="mt-2 flex justify-between items-center text-sm text-gray-600">
        <!-- Filter label -->
        <div>
            <span class="font-semibold">ფილტრი</span>
            <span class="text-gray-400">({{$total_students}} შედეგი)</span>
        </div>

        <!-- Optional collapse arrow (just a placeholder for now) -->
        <button id="toggleFiltersBtn" class="text-gray-500">
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
</div>

<!-- Private info row: მოსწავლე -->

<form method="GET" action="{{ route('dashboard') }}" id="filterForm" class="hidden">
    <div>
        <span class="text-sm font-bold text-gray-600 mb-2">
            @lang("Pupil")
        </span>
    </div>
    <div class="grid grid-cols-7 gap-4 mb-4 ">
        <div>
            <input id="name" name="name" type="text" placeholder="@lang('Name')" value="{{ request('name') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="private_number" name="private_number" type="text" placeholder="@lang('Private Number')" value="{{ request('private_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>

        <x-select-dropdown :options="[1,2,3,4,5,6,7,8,9,10,11,12,'ქართული','ინგლისური']" label="აირჩიეთ კლასი" name="grade"/>
        <x-select-dropdown :options="['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'A', 'B', 'C', 'D', 'E','F','G','H','I','J']" label="აირჩიეთ ჯგუფი" name="group" />
        <x-select-dropdown :options="['ქართული', 'IB', 'ASAS', 'ბაღი']" label="აირჩიეთ სექტორი" name="sector" />

        <!-- 7. Status (Select for active (1), past (-1), future (0)) -->
        <x-select-dropdown :options="[1,2,3,4,5,6,7,8,9,10,11,12,'ქართული','ინგლისური']" label="აირჩიეთ კლასი" name="grade"/>

        <div>
            <x-select-dropdown :options="['active', 'past', 'future']" label="Pupil Status" name="pupil_status" />
        </div>
    </div>

    <div class="mt-3">
            <span class="text-sm font-bold text-gray-600 mb-2">
                @lang("Parent")
            </span>
    </div>
    <div class="grid grid-cols-7 gap-4 mb-4">
        <div>
            <input id="parent_name" name="parent_name" type="text" placeholder="@lang('Parent Name')" value="{{ request('parent_name') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="parent_email" name="parent_email" type="email" placeholder="@lang('Parent Mail')"  value="{{ request('parent_email') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="parent_number" name="parent_number" type="text" placeholder="@lang('Parent Number')"  value="{{ request('parent_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
    </div>

    <div class="mt-3">
            <span class="text-sm font-bold text-gray-600 mb-2">
                @lang("Financial Information")
            </span>
    </div>
    <div class="grid grid-cols-7 gap-4 mb-4">
        <div>
            <input id="yearly_payment_from" name="yearly_payment_from" type="text" placeholder="@lang('Yearly Payment From')" value="{{ request('yearly_payment_from') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="yearly_payment_to" name="yearly_payment_to" type="text" placeholder="@lang('Yearly Payment To')" value="{{ request('yearly_payment_to') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <x-select-dropdown :options="['EUR','GEL','USD']" label="აირჩიეთ ვალუტა" name="currency" />
        <div>
            <input id="payment_quantity" name="payment_quantity" type="number" placeholder="@lang('Payment Quantity')" value="{{ request('payment_quantity') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="custom_discount" name="custom_discount" type="number" placeholder="@lang('Custom Discount')" value="{{ request('custom_discount') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
    </div>

    <div class="mt-3">
            <span class="text-sm font-bold text-gray-600 mb-2">
                @lang("Other Details")
            </span>
    </div>    <div class="grid grid-cols-7 gap-4 mb-4">
        <div>
            <input id="payment_due" name="payment_due" type="text" placeholder="@lang('Contract End Date')" value="{{ request('payment_due') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   onfocus="(this.type='date')" onblur="if(this.value===''){this.type='text'}">
        </div>
        <div>
            <input id="parent_account" name="parent_account" type="text" placeholder="@lang('Parent Account')" value="{{ request('parent_account') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div>
            <input id="income_account" name="income_account" type="text" placeholder="@lang('Income Account')" value="{{ request('income_account') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div class="col-span-4">
            <input id="additional_information" name="additional_information" type="text" placeholder="@lang('Additional Information')" value="{{ request('additional_information') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
    </div>

    <div class="flex justify-between items-center mt-8">
        <button type="button" class="text-blue-500 hover:text-blue-700 ml-2" onclick="showModal('select','column',0)">
            <i class="fas fa-cog"></i> @lang('Select Columns')
        </button>

        <!-- Right buttons -->
        <div class="flex space-x-4 items-center">
            <!-- Reset Button -->
            <a href="{{ route('dashboard') }}" class="flex items-center bg-gray-100 text-gray-500 font-semibold py-2 px-4 rounded-md hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                გაასუფთავე
            </a>

            <!-- Filter Button -->
            <button type="submit" class="flex items-center bg-blue-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-5.414 5.414a1 1 0 0 0-.293.707v4.172a1 1 0 0 1-.293.707l-2 2A1 1 0 0 1 11 21v-8.172a1 1 0 0 0-.293-.707L5.293 6.707A1 1 0 0 1 5 6V4z" />
                </svg>
                გაფილტრე
            </button>
        </div>
    </div>
</form>
