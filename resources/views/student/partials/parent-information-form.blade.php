<div class="bg-white sm:rounded-lg mt-4">
    <div>
        <span class="text-sm font-bold text-gray-600 mb-2">
            @lang("Parent")
        </span>
    </div>
    <form action="{{ route('student.update', $student->id) }}" method="POST" class="grid grid-cols-5 gap-6">
        @csrf
        @method('PUT')
        <div class="col-span-1">
            <input type="text" id="parent_firstname" placeholder="@lang('Firstname')" name="parent_firstname" value="{{ old('parent_firstname', $student->parent_firstname ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('parent_firstname')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="parent_lastname" placeholder="@lang('Lastname')" name="parent_lastname" value="{{ old('parent_lastname', $student->parent_lastname ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('parent_lastname')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="email" id="parent_mail" placeholder="@lang('Email')" name="parent_mail" value="{{ old('parent_mail', $student->parent_mail ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('parent_mail')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <input type="text" id="parent_number" name="parent_number" placeholder="@lang('Phone Number')" value="{{ old('parent_number', $student->parent_number ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('parent_number')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1"></div>

        <div class="col-span-1">
            <div class="flex items-center">
                <label for="email_notifications" class="text-sm font-medium text-gray-700">@lang('Email Notification')</label>
                <div class="ml-3 relative">
                    <input type="checkbox" id="email_notifications" name="email_notifications" value="1" @checked($student->email_notifications) class="sr-only peer" />
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform peer-checked:translate-x-full"></div>
                </div>
            </div>
            @error('email_notifications')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1">
            <div class="flex items-center">
                <label for="mobile_notifications" class="text-sm font-medium text-gray-700">@lang('SMS Notification')</label>
                <div class="ml-3 relative">
                    <input type="checkbox" id="mobile_notifications" name="mobile_notifications" value="1" @checked($student->mobile_notifications) class="sr-only peer" />
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform peer-checked:translate-x-full"></div>
                </div>
            </div>
            @error('mobile_notifications')
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
