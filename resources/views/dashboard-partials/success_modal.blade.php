<!-- Modal Structure -->
<div id="modal-success-message-0" class="fixed z-20 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 rounded-full">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="mt-4 text-lg font-medium text-gray-900">{{ session('success') }}</h2>
            <button type="button"  onclick="hideModal('success','message',0)" class="mt-6 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">დახურვა</button>
        </div>
    </div>
</div>
