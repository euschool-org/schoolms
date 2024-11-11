<div id="modal-export-file-0" class="fixed z-20 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-lg w-[500px] relative">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4">
                <h2 class="text-lg font-medium">ჩამოტვირთე Excel ფაილი</h2>
                <button type="button" onclick="hideModal('export','file',0)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-4 grid grid-cols-2 gap-4">
                <!-- Student Export -->
                <a href="{{ route('student.export') . (request()->all() ? '?' . http_build_query(request()->all()) : '') }}"
                   class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="mb-2">
                        <svg class="w-8 h-8 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19h18m-9-3v-9m0 9l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-600">სტუდენტები</span>
                </a>
                <!-- Payment Export -->
                <a href="{{ route('payment.export') . (request()->all() ? '?' . http_build_query(request()->all()) : '') }}"
                   class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="mb-2">
                        <svg class="w-8 h-8 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19h18m-9-3v-9m0 9l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-600">გადახდები</span>
                </a>


            </div>
        </div>
    </div>
</div>
