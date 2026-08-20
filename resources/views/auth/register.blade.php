<x-guest-layout>
    <!-- Header Title -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-500/10 mb-4">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-white mb-2">Mari Bergabung Bersama Kami ✨</h2>
        <p class="text-sm text-slate-400 leading-relaxed px-4">
            Langkah awal yang tepat untuk masa depan gemilang putra-putri Anda. <br class="hidden sm:block">Silakan isi formulir di bawah ini untuk membuat akun baru. 🎓
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap Orang Tua / Wali')" />
            <x-text-input
                id="name"
                class="block mt-1 w-full @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama Lengkap Bapak/Ibu (huruf saja)"
                pattern="[A-Za-z\s]+"
                maxlength="100"
                title="Nama hanya boleh berisi huruf dan spasi"
                oninput="validateName(this)"
            />
            @error('name')
                <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @else
                <p class="mt-1 text-[10px] text-slate-500">Hanya huruf dan spasi. Contoh: Bapak Ahmad Santoso</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full @error('email') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="email@domain.com"
            />
            @error('email')
                <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full @error('password') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Min. 8 karakter"
                minlength="8"
                maxlength="64"
                oninput="checkPasswordStrength(this.value)"
            />
            @error('password')
                <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
            <!-- Password Strength Indicator -->
            <div id="strengthBar" class="mt-2 hidden">
                <div class="flex gap-1 mb-1">
                    <div id="s1" class="h-1 flex-1 rounded-full bg-slate-700 transition-all duration-300"></div>
                    <div id="s2" class="h-1 flex-1 rounded-full bg-slate-700 transition-all duration-300"></div>
                    <div id="s3" class="h-1 flex-1 rounded-full bg-slate-700 transition-all duration-300"></div>
                    <div id="s4" class="h-1 flex-1 rounded-full bg-slate-700 transition-all duration-300"></div>
                </div>
                <p id="strengthText" class="text-[10px] text-slate-400"></p>
            </div>
            <!-- Password rules checklist -->
            <div class="mt-2 space-y-0.5" id="pwRules">
                <p class="text-[10px] font-semibold text-slate-400 mb-1">Syarat kata sandi:</p>
                <p id="rule-len" class="text-[10px] text-slate-500 flex items-center gap-1"><span id="ic-len">○</span> Minimal 8 karakter</p>
                <p id="rule-up"  class="text-[10px] text-slate-500 flex items-center gap-1"><span id="ic-up">○</span> Mengandung huruf besar (A-Z)</p>
                <p id="rule-lo"  class="text-[10px] text-slate-500 flex items-center gap-1"><span id="ic-lo">○</span> Mengandung huruf kecil (a-z)</p>
                <p id="rule-num" class="text-[10px] text-slate-500 flex items-center gap-1"><span id="ic-num">○</span> Mengandung angka (0-9)</p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full @error('password_confirmation') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                maxlength="64"
                oninput="checkConfirm(this.value)"
            />
            <p id="confirmMsg" class="mt-1 text-[10px] hidden"></p>
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
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

    <script>
        function validateName(el) {
            const val = el.value;
            if (/[^a-zA-Z\s]/.test(val)) {
                el.value = val.replace(/[^a-zA-Z\s]/g, '');
            }
        }

        function checkPasswordStrength(val) {
            const bar = document.getElementById('strengthBar');
            const s = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
            const text = document.getElementById('strengthText');

            const hasLen = val.length >= 8;
            const hasUp  = /[A-Z]/.test(val);
            const hasLo  = /[a-z]/.test(val);
            const hasNum = /[0-9]/.test(val);
            const hasSym = /[^a-zA-Z0-9]/.test(val);

            // Update rule icons
            setRule('ic-len', 'rule-len', hasLen);
            setRule('ic-up',  'rule-up',  hasUp);
            setRule('ic-lo',  'rule-lo',  hasLo);
            setRule('ic-num', 'rule-num', hasNum);

            if (val.length === 0) { bar.classList.add('hidden'); return; }
            bar.classList.remove('hidden');

            const score = [hasLen, hasUp, hasLo, hasNum, hasSym].filter(Boolean).length;
            const colors = ['bg-rose-500', 'bg-amber-500', 'bg-yellow-400', 'bg-emerald-500'];
            const labels = ['Sangat Lemah', 'Lemah', 'Cukup Kuat', 'Kuat', 'Sangat Kuat'];
            const fill = Math.max(1, score);

            s.forEach((el, i) => {
                el.className = 'h-1 flex-1 rounded-full transition-all duration-300 ' + (i < fill ? colors[fill - 1] : 'bg-slate-700');
            });
            text.textContent = 'Kekuatan: ' + labels[score - 1];
            text.className = 'text-[10px] ' + (score <= 2 ? 'text-rose-400' : score === 3 ? 'text-yellow-400' : 'text-emerald-400');
        }

        function setRule(iconId, rowId, pass) {
            const icon = document.getElementById(iconId);
            const row  = document.getElementById(rowId);
            if (pass) {
                icon.textContent = '✓';
                row.className = 'text-[10px] text-emerald-400 flex items-center gap-1 font-semibold';
            } else {
                icon.textContent = '○';
                row.className = 'text-[10px] text-slate-500 flex items-center gap-1';
            }
        }

        function checkConfirm(val) {
            const pw  = document.getElementById('password').value;
            const msg = document.getElementById('confirmMsg');
            msg.classList.remove('hidden');
            if (val === '') { msg.classList.add('hidden'); return; }
            if (val === pw) {
                msg.textContent = '✓ Kata sandi cocok';
                msg.className = 'mt-1 text-[10px] text-emerald-400 font-semibold';
            } else {
                msg.textContent = '✗ Kata sandi tidak cocok';
                msg.className = 'mt-1 text-[10px] text-rose-400 font-semibold';
            }
        }
    </script>
</x-guest-layout>

