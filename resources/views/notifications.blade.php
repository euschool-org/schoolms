<x-app-layout>
    <div class="max-w-[70rem] mx-auto py-10 sm:px-6 lg:px-8">
        @if (session('success'))
                @include('dashboard-partials.success_modal')
        @endif
        <div class="flex flex-wrap">
            <div class="w-full p-4 bg-white shadow rounded-xl mt-4">
                <!-- Monitoring Category Section -->
                <h3 class="text-gray-600 font-semibold mb-4">მონიშნე კატეგორია</h3>

                <!-- Buttons with Checkbox Functionality -->
                <div x-data="{ selected: [] }" class="grid grid-cols-3 gap-4">
                    <!-- Button 1 -->
                    <x-checkbox-blue-button item="prev_year" label="Previous Year Debt"/>

                    <!-- Button 2 -->
                    <x-checkbox-blue-button item="semester_1" label="First Semester Debt"/>

                    <!-- Button 3 -->
                    <x-checkbox-blue-button item="semester_2" label="Second Semester Debt"/>

                    <!-- Button 4 -->
                    <x-checkbox-blue-button item="monthly_reminder" label="Monthly Reminder"/>

                    <!-- Button 5 -->
                    <x-checkbox-blue-button item="custom_schedule" label="Custom Schedule"/>

                </div>
            </div>

            <div class="w-full p-6 bg-white shadow sm:rounded-xl mt-4">
                <h3 class="text-gray-600 font-semibold mb-2">დამატე გასაგზავნი ტექსტი</h3>

                <!-- Input Field -->
                <div class="mb-4">
                    <x-text-input-label name="subject" label="Subject" value="" />
                </div>

                <!-- Textarea Field -->
                <div>
                    <textarea
                        id="body"
                        name="body"
                        rows="4"
                        class="w-full px-3 py-3 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="შეიყვანე ტექსტი..."></textarea>
                </div>
            </div>

            <div class="w-full p-6 bg-white shadow sm:rounded-xl mt-4">
                <h3 class="text-gray-600 font-semibold mb-2">შეტყობინების ტიპი</h3>
                <div class="flex items-center space-x-4">
                    <x-checkbox-switch name="email-notification" label="Email Notification"/>
                    <x-checkbox-switch name="sms-notification" label="SMS Notification"/>
                    <x-checkbox-switch name="attach-invoice" label="Attach Invoice"/>
                </div>
            </div>

            <div class="w-full mt-4 flex justify-center">
                <button class="pl-8 pr-6 py-3 bg-blue-500 text-white text-m font-normal rounded-xl hover:bg-blue-600 transition duration-300 flex items-center">
                    <span>გაგზავნა</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ml-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                </button>

            </div>

        </div>
    </div>
</x-app-layout>
