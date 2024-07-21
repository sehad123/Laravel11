@props(['active' => false])

@php
    $classes = $active 
                ? 'block bg-gray-900 text-white' 
                : 'block text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => "$classes rounded-md px-3 py-2 text-base font-medium"]) }} aria-current="{{ $active ? 'page' : 'false' }}">
    {{ $slot }}
</a>
