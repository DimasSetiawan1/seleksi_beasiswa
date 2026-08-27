<x-guest-layout>

    {{-- ══════════════════════════════════════════════
         HEADER: Title
    ══════════════════════════════════════════════ --}}
    <div class="text-center mb-7 pt-2">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-white tracking-tight">Portal Kepala Sekolah</h2>
        <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Gunakan kredensial khusus Anda untuk masuk ke sistem.</p>
    </div>

    {{-- ══════════════════════════════════════════════
         DEMO ACCOUNTS QUICK FILL
    ══════════════════════════════════════════════ --}}
    <div class="mb-5 rounded-2xl border border-dashed border-amber-500/30 bg-amber-950/20 px-4 py-3">
        <p class="text-[10px] font-bold uppercase tracking-widest text-amber-400/80 text-center mb-2.5">
            💡 Akun Pengujian — 1 Klik Auto Fill
        </p>
        <button
            type="button"
            onclick="fillLogin('kepsek@kepsek.com', 'password')"
            class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl
                   bg-amber-600/20 hover:bg-amber-600/30
                   border border-amber-500/30 hover:border-amber-500/50
                   text-amber-300 hover:text-amber-200
                   text-xs font-bold transition-all duration-200">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Autofill Akun Kepala Sekolah
        </button>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Error Banner --}}
    @if ($errors->any())
        <div class="mb-4 flex items-start gap-2.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-xs text-rose-400">
            <svg class="mt-0.5 h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <div class="space-y-0.5 font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════
         LOGIN FORM
    ══════════════════════════════════════════════ --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <div class="mt-2 flex items-stretch rounded-xl border {{ $errors->has('email') ? 'border-rose-500' : 'border-slate-700/80' }} bg-slate-900/90 overflow-hidden focus-within:border-amber-500 focus-within:ring-1 focus-within:ring-amber-500 transition">
                <span class="flex items-center px-3.5 text-slate-500 shrink-0 border-r border-slate-700/60">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="kepsek@kepsek.com"
                    class="flex-1 bg-transparent text-white text-sm placeholder-slate-500 px-4 py-3 outline-none border-none focus:ring-0" />
            </div>
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <div class="mt-2 flex items-stretch rounded-xl border {{ $errors->has('password') ? 'border-rose-500' : 'border-slate-700/80' }} bg-slate-900/90 overflow-hidden focus-within:border-amber-500 focus-within:ring-1 focus-within:ring-amber-500 transition">
                <span class="flex items-center px-3.5 text-slate-500 shrink-0 border-r border-slate-700/60">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="flex-1 bg-transparent text-white text-sm placeholder-slate-500 px-4 py-3 outline-none border-none focus:ring-0" />
            </div>
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between pt-2 pb-1">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-slate-700 bg-slate-900 text-amber-500 focus:ring-amber-500 focus:ring-offset-slate-900">
                <span class="text-xs font-medium text-slate-400">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-xs font-semibold text-amber-400 transition hover:text-amber-300">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 hover:to-amber-400 text-white font-bold text-sm tracking-wide rounded-xl shadow-lg shadow-amber-600/30 transition duration-200 cursor-pointer">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk Portal Kepsek
            </button>
        </div>

        <div class="text-center pt-4 mt-6 border-t border-slate-800/80">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login Orang Tua / Pendaftar
            </a>
        </div>
    </form>

    <script>
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>

