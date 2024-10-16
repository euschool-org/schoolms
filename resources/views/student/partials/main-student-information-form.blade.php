<div class="flex justify-between items-center mb-2">
    <!-- Header Title -->
    <div class="text-lg font-semibold">
        @if($update)
            {{$student->firstname . ' ' . $student->lastname}}
        @else
            @lang('Add New Student')
        @endif
    </div>
</div>

<!-- Blue underline for active section -->
<div class="border-b-2 border-gray-200">
    <div class="border-b-2 border-blue-500 w-20"></div> <!-- Blue indicator, you can adjust the width -->
</div>
<div class="bg-white sm:rounded-lg mt-4">
    <div class="text-sm font-bold text-gray-600 mb-3">
        <span>
            @lang("Pupil")
        </span>
    </div>
    <form action="{{ $update ? route('student.update', $student->id) : route('student.store') }}" method="POST" class="grid grid-cols-5 gap-6">
        @csrf
        @if($update)
            @method('PUT')
        @endif
        <!-- First Line: Firstname, Lastname, Private Number (3 columns, 2 empty) -->
        <div class="col-span-1">
            <x-text-input-label name="firstname" label="Firstname" value="{{ $student->firstname }}" />
        </div>
        <div class="col-span-1">
            <x-text-input-label name="lastname" label="Lastname" value="{{ $student->lastname }}" />
        </div>
        <div class="col-span-1">
            <x-text-input-label name="private_number" label="Private Number" value="{{ $student->private_number }}" />
        </div>
        <!-- Leave 2 columns empty -->
        <div class="col-span-2"></div>

        <!-- Second Line: Grade, Group, Sector, Pupil Status (4 columns, 1 empty) -->
        <div class="col-span-1">
            <x-select-dropdown :options="[1,2,3,4,5,6,7,8,9,10,11,12]" label="Grade" name="grade" padding="28" value="{{$student->grade}}" />
            @error('grade')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-1">
            <x-select-dropdown :options="['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'A', 'B', 'C', 'D', 'E','F','G','H','I','J','ქართული','ინგლისური']" label="Group" name="group" padding="16" value="{{$student->group}}" />
            @error('group')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-1">
            <x-select-dropdown :options="['ქართული', 'IB', 'ASAS', 'ბაღი']" label="Sector" name="sector" value="{{$student->sector}}" />
            @error('sector')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-1">
            <div class="relative">
                <label for="grade-select" class="absolute text-gray-500 left-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none">
                    @lang('Status'):
                </label>
                <select id="pupil_status" name="pupil_status"
                        class="block w-full pl-20 pr-10 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" disabled @selected($student->pupil_status === null)>@lang('Status')</option>
                    <option value="1" @selected($student->pupil_status === 1)>@lang('Active')</option>
                    <option value="-1" @selected($student->pupil_status === -1)>@lang('Past')</option>
                    <option value="0" @selected($student->pupil_status === 0)>@lang('Future')</option>
                </select>
            </div>
            @error('pupil_status')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <!-- Leave 1 column empty -->
        <div class="col-span-1"></div>

        <!-- Third Line: Additional Information (Full Width) -->
        <div class="col-span-5">
            <label for="additional_information" class="block text-sm font-medium text-gray-700">@lang('Additional Information')</label>
            <textarea id="additional_information" name="additional_information" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('additional_information', $student->additional_information ?? '') }}</textarea>
            @error('additional_information')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button (aligned right, spans 4 columns) -->
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

