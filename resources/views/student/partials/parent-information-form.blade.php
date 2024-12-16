    <div class="text-sm font-bold text-gray-600 mb-3">
        <span>
            @lang("Parent")
        </span>
    </div>
    <form action="{{ route('student.update', $student->id) }}" method="POST" class="grid grid-cols-5 gap-6">
        @csrf
        @method('PUT')
        <div class="col-span-1">
            <x-text-input-label name="parent_name" label="Name" value="{{ $student->parent_name }}" />
        </div>

        <div class="col-span-1">
            <x-text-input-label name="parent_mail" label="Email" value="{{ $student->parent_mail }}" />
        </div>

        <div class="col-span-1">
            <x-text-input-label name="parent_number" label="Phone Number" value="{{ $student->parent_number }}" />
        </div>

        <div class="col-span-2"></div>

        <div class="col-span-1">
            <x-checkbox-switch name="email_notifications" label="Email Notification" value="{{ $student->email_notifications }}"/>
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

