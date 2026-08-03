<x-guest-layout>
    <!-- Header Title -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-extrabold text-white">Daftar Akun Baru</h2>
        <p class="text-xs text-slate-400 mt-1">Registrasi akun Orang Tua / Wali Siswa untuk pendaftaran beasiswa.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap Orang Tua / Wali')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap Bapak/Ibu" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@domain.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 Karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Kata Sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-400">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-extrabold ms-1 underline">
                Masuk Di Sini
            </a>
        </div>
    </form>
</x-guest-layout>
