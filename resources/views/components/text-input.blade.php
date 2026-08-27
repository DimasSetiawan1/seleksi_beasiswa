@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-700/80 bg-slate-900/90 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs py-3 px-4 text-sm transition']) }}>
