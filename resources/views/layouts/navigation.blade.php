<nav x-data="{ open: false }" class="bg-slate-900 text-white border-b border-slate-800 shadow-lg sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4 xl:gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <img src="{{ asset('logo.png') }}" alt="Logo SMK Tinta Emas Indonesia" class="h-9 sm:h-10 w-auto object-contain group-hover:scale-105 transition duration-300">
                        <div>
                            <span class="font-extrabold text-sm sm:text-base tracking-tight text-white block">SELEKSI BEASISWA</span>
                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium tracking-wider uppercase block">SMK Tinta Emas Indonesia</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop/Laptop XL) -->
                <div class="hidden xl:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('dashboard') || request()->routeIs('*.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.kriteria.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.kriteria.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Kriteria & Sub
                        </a>
                        <a href="{{ route('admin.ahp.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.ahp.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Bobot Kriteria
                        </a>
                        <a href="{{ route('admin.kandidat.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.kandidat.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Data Pendaftar
                        </a>
                        <a href="{{ route('admin.moora.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.moora.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Hasil Perangkingan
                        </a>
                        <a href="{{ route('admin.laporan.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan & Cetak
                        </a>
                    @elseif(Auth::user()->role === 'kepsek')
                        <a href="{{ route('kepsek.usulan.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('kepsek.usulan.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Persetujuan Seleksi
                        </a>
                    @elseif(Auth::user()->role === 'ortu')
                        <a href="{{ route('ortu.pendaftaran.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold transition duration-200 flex items-center gap-1.5 {{ request()->routeIs('ortu.pendaftaran.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Form Pendaftaran Siswa
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Desktop/Laptop XL) -->
            <div class="hidden xl:flex xl:items-center xl:ms-6 gap-3">
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider shadow-inner border shrink-0
                    @if(Auth::user()->role === 'admin') bg-indigo-500/20 text-indigo-300 border-indigo-500/40
                    @elseif(Auth::user()->role === 'kepsek') bg-amber-500/20 text-amber-300 border-amber-500/40
                    @else bg-emerald-500/20 text-emerald-300 border-emerald-500/40 @endif">
                    ✦ @if(Auth::user()->role === 'admin') Panitia Beasiswa @elseif(Auth::user()->role === 'kepsek') Kepala Sekolah @else Orang Tua / Wali @endif
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-slate-700 text-xs font-semibold rounded-xl text-slate-200 bg-slate-800 hover:bg-slate-700 hover:text-white focus:outline-none transition">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="fill-current h-4 w-4 ms-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs">
                            {{ __('Profil Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-xs text-red-600 font-semibold">
                                {{ __('Keluar (Logout)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button (Mobile & Tablet/Laptop < 1280px) -->
            <div class="-me-2 flex items-center xl:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile & Tablet Drawer) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden xl:hidden bg-slate-900 border-t border-slate-800 px-4 py-4 space-y-2">
        <div class="pb-2 border-b border-slate-800 flex justify-between items-center text-xs">
            <div class="font-bold text-slate-200">{{ Auth::user()->name }}</div>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                @if(Auth::user()->role === 'admin') Panitia Beasiswa @elseif(Auth::user()->role === 'kepsek') Kepala Sekolah @else Orang Tua / Wali @endif
            </span>
        </div>

        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-200">
            Dashboard
        </x-responsive-nav-link>

        @if(Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.kriteria.index')" :active="request()->routeIs('admin.kriteria.*')" class="text-slate-200">Kriteria & Sub-Kriteria</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.ahp.index')" :active="request()->routeIs('admin.ahp.*')" class="text-slate-200">Bobot Kriteria</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.kandidat.index')" :active="request()->routeIs('admin.kandidat.*')" class="text-slate-200">Data Pendaftar</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.moora.index')" :active="request()->routeIs('admin.moora.*')" class="text-slate-200">Hasil Perangkingan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')" class="text-slate-200">Laporan & Cetak PDF</x-responsive-nav-link>
        @elseif(Auth::user()->role === 'kepsek')
            <x-responsive-nav-link :href="route('kepsek.usulan.index')" :active="request()->routeIs('kepsek.usulan.*')" class="text-slate-200">Persetujuan Hasil Seleksi</x-responsive-nav-link>
        @elseif(Auth::user()->role === 'ortu')
            <x-responsive-nav-link :href="route('ortu.pendaftaran.index')" :active="request()->routeIs('ortu.pendaftaran.*')" class="text-slate-200">Form Pendaftaran Siswa</x-responsive-nav-link>
        @endif

        <div class="pt-2 border-t border-slate-800">
            <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300">Profil Akun</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 font-semibold">
                    Keluar (Logout)
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
