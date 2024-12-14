<div class="flex items-center">
    <label for="{{$name}}" class="text-sm font-medium text-gray-700">@lang($label)</label>
    <div class="ml-3 relative">
        <input type="checkbox" id="{{$name}}" name="{{$name}}" value="1" class="sr-only peer" />
        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
        <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform peer-checked:translate-x-full"></div>
    </div>
</div>
@error($name)
<span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
