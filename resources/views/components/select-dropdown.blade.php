<div x-data="{ open_{{ $name }}: false, {{ $name }}: [{{ implode(',', array_map(fn($value) => "'$value'", request($name, [])))
 }}] }" class="relative">
    <!-- Dropdown button -->
    <button @click.prevent="open_{{ $name }} = !open_{{ $name }}" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm py-2">
        <span x-text="{{ $name }}.length > 0 ? {{ $name }}.join(', ') : '{{ $label }}'"></span>
        <span class="float-right">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </button>

    <!-- Dropdown content -->
    <div x-show="open_{{ $name }}" @click.away="open_{{ $name }} = false" class="absolute z-50 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-64 overflow-y-auto">
        <!-- Select all -->
        <label class="block p-2">
            <input type="button" value="" name="{{ $name }}[]" @click="{{ $name }} = []" class="mr-2">
            ყველა
        </label>

        <!-- Options loop -->
        @foreach ($options as $option)
            <label class="block p-2">
                <input type="checkbox" value="{{ $option }}" name="{{ $name }}[]" x-model="{{ $name }}" class="mr-2">
                {{ $option }}
            </label>
        @endforeach
    </div>
</div>
