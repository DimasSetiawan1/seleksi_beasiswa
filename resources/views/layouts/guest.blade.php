<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SPK Beasiswa') }} - SMK Tinta Emas Indonesia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-100 bg-slate-950 min-h-full flex flex-col justify-center relative overflow-x-hidden selection:bg-indigo-500 selection:text-white">

        <!-- Glowing Ambient Background Effects -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -right-40 w-96 h-96 bg-cyan-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center py-12 px-4 sm:px-6">
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <img src="{{ asset('logo.png') }}" alt="Logo SMK Tinta Emas Indonesia" class="h-16 w-auto object-contain drop-shadow-xl group-hover:scale-105 transition duration-300">
                    <div>
                        <span class="font-black text-xl tracking-tight text-white block">SELEKSI BEASISWA</span>
                        <span class="text-xs text-indigo-400 font-semibold uppercase tracking-widest">SMK Tinta Emas Indonesia</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-slate-900/80 backdrop-blur-xl border border-slate-800 shadow-2xl p-8 rounded-3xl overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
