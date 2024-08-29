<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-8">{{ __(isset($student) ? 'Edit Student' : 'Add Student') }}</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap">
            <div class="w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('student.partials.main-student-information-form')
            </div>

            @if(isset($student))
                <div class="w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('student.partials.additional-student-information-form')
                </div>

                <div class="w-full p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.payment-information-form')
                </div>

                <div class="w-full p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.attachment-information-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
