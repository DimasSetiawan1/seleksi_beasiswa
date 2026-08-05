@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-2.5 w-full ps-4 pe-4 py-2.5 border-l-2 border-indigo-500 text-start text-sm font-bold text-indigo-300 bg-indigo-500/10 rounded-r-xl focus:outline-none transition duration-150 ease-in-out'
            : 'flex items-center gap-2.5 w-full ps-4 pe-4 py-2.5 border-l-2 border-transparent text-start text-sm font-semibold text-slate-300 hover:text-white hover:bg-slate-800 hover:border-indigo-500/50 rounded-r-xl focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
