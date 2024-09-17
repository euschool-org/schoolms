<form action="{{ isset($student) ? route('student.update', $student->id) : route('student.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    @if(isset($student))
        @method('PUT')
    @endif

    <div class="col-span-1">
        <label for="firstname" class="block text-sm font-medium text-gray-700">@lang('Firstname')</label>
        <input type="text" id="firstname" name="firstname" value="{{ old('firstname', $student->firstname ?? '') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('firstname')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="lastname" class="block text-sm font-medium text-gray-700">@lang('Lastname')</label>
        <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $student->lastname ?? '') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('lastname')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="private_number" class="block text-sm font-medium text-gray-700">@lang('Private Number')</label>
        <input type="text" id="private_number" name="private_number" value="{{ old('private_number', $student->private_number ?? '') }}" required minlength="11" maxlength="11" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('private_number')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="grade" class="block text-sm font-medium text-gray-700">@lang('Grade')</label>
        <input type="number" id="grade" name="grade" value="{{ old('grade', $student->grade ?? '') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('grade')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="group" class="block text-sm font-medium text-gray-700">@lang('Group')</label>
        <select id="group" name="group" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="" disabled {{ old('group', $student->group ?? '') == '' ? 'selected' : '' }}>@lang('Select Group')</option>
            <option value="ა" {{ old('group', $student->group ?? '') == 'ა' ? 'selected' : '' }}>ა</option>
            <option value="ბ" {{ old('group', $student->group ?? '') == 'ბ' ? 'selected' : '' }}>ბ</option>
            <option value="გ" {{ old('group', $student->group ?? '') == 'გ' ? 'selected' : '' }}>გ</option>
            <option value="დ" {{ old('group', $student->group ?? '') == 'დ' ? 'selected' : '' }}>დ</option>
            <option value="A" {{ old('group', $student->group ?? '') == 'a' ? 'selected' : '' }}>A</option>
            <option value="B" {{ old('group', $student->group ?? '') == 'b' ? 'selected' : '' }}>B</option>
            <option value="C" {{ old('group', $student->group ?? '') == 'c' ? 'selected' : '' }}>C</option>
            <option value="D" {{ old('group', $student->group ?? '') == 'd' ? 'selected' : '' }}>D</option>
        </select>
        @error('group')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="sector" class="block text-sm font-medium text-gray-700">@lang('Sector')</label>
        <input type="number" id="sector" name="sector" value="{{ old('sector', $student->sector ?? '') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @error('sector')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="pupil_status" class="block text-sm font-medium text-gray-700">@lang('Pupil Status')</label>
        <select id="pupil_status" name="pupil_status" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="" disabled {{ old('pupil_status', $student->pupil_status ?? '') == '' ? 'selected' : '' }}>@lang('Select Status')</option>
            <option value="1" {{ old('pupil_status', $student->pupil_status ?? '') == '1' ? 'selected' : '' }}>@lang('Active')</option>
            <option value="0" {{ old('pupil_status', $student->pupil_status ?? '') == '0' ? 'selected' : '' }}>@lang('Future')</option>
            <option value="-1" {{ old('pupil_status', $student->pupil_status ?? '') == '-1' ? 'selected' : '' }}>@lang('Past')</option>
        </select>
        @error('pupil_status')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2">
        <label for="additional_information" class="block text-sm font-medium text-gray-700">@lang('Additional Information')</label>
        <textarea id="additional_information" name="additional_information" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('additional_information', $student->additional_information ?? '') }}</textarea>
        @error('additional_information')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-span-2 flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">{{ isset($student) ? 'Update' : 'Submit' }}</button>
    </div>
</form>
