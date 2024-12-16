<div x-data="{ inputValue: '{{ $value }}' }" class="relative">
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder=" "
        x-model="inputValue"
        x-on:input="inputValue = $event.target.value"
        value="{{ $value }}"
        class="peer w-full border border-gray-300 rounded-lg px-3 pb-1 pt-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition"
    >
    <label
        for="{{ $name }}"
        x-bind:class="{'text-sm scale-75 -translate-y-0.5': inputValue.length > 0}"
        class="absolute text-gray-500 left-3 bottom-5 text-xs transform origin-[0] transition-all duration-200
               peer-placeholder-shown:text-base peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-3
               peer-focus:text-sm peer-focus:scale-75 peer-focus:-translate-y-0.5
               {{ $value ? 'text-sm scale-75 -translate-y-1' : '' }}"
    >
        @lang($label)
    </label>
</div>
@error($name)
<span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
