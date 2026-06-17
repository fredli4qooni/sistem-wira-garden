@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex items-center px-3 py-3 text-sm font-medium rounded-xl bg-secondary text-white transition-colors mt-1 shadow-sm'
            : 'group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-colors mt-1';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
