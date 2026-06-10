@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-multirao-roxo text-sm font-bold leading-5 text-multirao-roxo focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold leading-5 text-gray-500 hover:text-multirao-roxo hover:border-multirao-amarelo focus:outline-none focus:text-multirao-roxo transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes,'style'=>"color:#3f226b"]) }}>
    {{ $slot }}
</a>
