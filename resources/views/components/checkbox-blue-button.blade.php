<button
    @click="selected.includes('{{$item}}') ? selected = selected.filter(item => item !== '{{$item}}') : selected.push('{{$item}}')"
    :class="selected.includes('{{$item}}') ? 'bg-blue-600 text-white' : 'bg-white text-gray-500'"
    class="relative w-full py-3 px-4 border rounded-lg text-center transition flex justify-between items-center">
    <span>{{__($label)}}</span>
    <svg x-show="selected.includes('{{$item}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
         class="w-5 h-5 text-white">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
</button>
