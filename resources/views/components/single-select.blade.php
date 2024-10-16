<div class="relative">
    <label for="grade-select" class="absolute text-gray-500 left-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none">
        @lang($label):
    </label>
    <select id="{{$name}}" name="{{$name}}" class="block w-full {{$padding ? "pl-32" : 'pl-24'}} pr-10 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="" disabled  selected >@lang($label)</option>
        @foreach($options as $option)
            <option value="{{$option}}" {{ ($option == $value) ? 'selected' : '' }}> {{$option}} </option>
        @endforeach
    </select>
</div>
