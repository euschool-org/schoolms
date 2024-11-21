<x-app-layout>
    <div class="max-w-[100rem] mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session('success'))
            @include('dashboard-partials.success_modal')
        @endif
        <div class="flex flex-wrap">
            <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                @include('student.partials.main-student-information-form')
            </div>

            @if($update)
                <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.parent-information-form')
                </div>
                <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.financial-information-form')
                </div>
                <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.monthly-fee-form')
                </div>
                <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.payment-information-form')
                </div>
                <!-- Attachment Information -->
                <div class="w-full p-6 bg-white shadow sm:rounded-lg mt-4">
                    @include('student.partials.attachment-information-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
