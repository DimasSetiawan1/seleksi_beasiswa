<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Dashboard Kepala Sekolah</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Peninjauan dan pengesahan hasil seleksi beasiswa SMK Tinta Emas Indonesia.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-amber-900 via-amber-950 to-slate-900 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden border border-amber-900/50">
            <div class="relative z-10 max-w-2xl">
                <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest mb-3 inline-block">
                    Pimpinan Sekolah
                </span>
                <h3 class="text-2xl font-black tracking-tight text-white mb-2">Selamat Datang, {{ Auth::user()->name }}</h3>
                <p class="text-xs text-amber-100/80 leading-relaxed mb-6">
                    Anda memiliki wewenang untuk meninjau hasil perangkingan penerima beasiswa yang telah disusun oleh Panitia Kesiswaan dan menandatangani SK Penetapan secara digital.
                </p>

                <div>
                    <a href="{{ route('kepsek.usulan.index') }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs px-6 py-3 rounded-2xl transition shadow-lg shadow-amber-500/30 inline-flex items-center gap-2">
                        Tinjau Usulan Penerima Beasiswa &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
