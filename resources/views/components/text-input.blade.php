@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-700/80 bg-slate-900/90 text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-xs py-2.5 px-3.5 text-xs transition']) }}>
