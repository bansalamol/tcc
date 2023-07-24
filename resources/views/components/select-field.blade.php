@props(['name', 'options', 'selected' => null])

<div class="col-span-6 sm:col-span-4">
    <x-label for="{{ $name }}" :value="$slot" />

    <select id="{{ $name }}" name="{{ $name }}" class="mt-1 block w-full border-gray-300 rounded-md" {{ $attributes }}>
        <option value="">Select an option</option> 
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>

    <x-input-error for="{{ $name }}" class="mt-2" />
</div>
