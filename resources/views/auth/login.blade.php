<x-guest-layout>
    <!-- Header Title -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-extrabold text-white">Masuk Akun Pengguna</h2>
        <p class="text-xs text-slate-400 mt-1">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>
    </div>

    <!-- Quick Demo Accounts Switcher -->
    <div class="mb-6 bg-slate-950/60 p-3 rounded-2xl border border-slate-800">
        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2 text-center">💡 Akun Pengujian (1-Klik Auto Fill)</span>
        <div class="grid grid-cols-3 gap-2">
            <button type="button" onclick="fillLogin('admin@admin.com', 'password')" class="bg-indigo-600/20 hover:bg-indigo-600/40 border border-indigo-500/30 text-indigo-300 py-1.5 px-2 rounded-xl text-[10px] font-bold transition text-center">
                Panitia
            </button>
            <button type="button" onclick="fillLogin('kepsek@kepsek.com', 'password')" class="bg-amber-600/20 hover:bg-amber-600/40 border border-amber-500/30 text-amber-300 py-1.5 px-2 rounded-xl text-[10px] font-bold transition text-center">
                Kepsek
            </button>
            <button type="button" onclick="fillLogin('ortu@ortu.com', 'password')" class="bg-emerald-600/20 hover:bg-emerald-600/40 border border-emerald-500/30 text-emerald-300 py-1.5 px-2 rounded-xl text-[10px] font-bold transition text-center">
                Ortu / Wali
            </button>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- General Error Banner (email/password salah) -->
    @if ($errors->any())
        <div class="mb-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-2xl flex items-start gap-3 text-xs font-medium">
            <svg class="w-4 h-4 text-rose-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full {{ $errors->has('email') ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="contoh: ortu@ortu.com"
            />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full {{ $errors->has('email') ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-indigo-600 shadow-xs focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-slate-400 font-medium">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-indigo-400 hover:text-indigo-300 transition font-semibold" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Masuk Ke Akun') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-400">Belum memiliki akun?</span>
            <a href="{{ route('register') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-extrabold ms-1 underline">
                Daftar Akun Baru
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

