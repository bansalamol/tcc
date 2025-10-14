@props(['active'])

@php
 $classes = ($active ?? false)
            ? 'flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-md'
            : 'flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-md transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
