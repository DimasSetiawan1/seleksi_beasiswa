<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Dashboard Siswa</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Portal pendaftaran beasiswa SMK Tinta Emas Indonesia.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Banner Siswa -->
        <div class="bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden border border-indigo-900/50">
            <div class="relative z-10 max-w-2xl">
                <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest mb-3 inline-block">
                    Pendaftar Beasiswa
                </span>
                <h3 class="text-2xl font-black tracking-tight text-white mb-2">Selamat Datang, {{ Auth::user()->name }}</h3>
                <p class="text-xs text-indigo-100/80 leading-relaxed mb-6">
                    Silakan isi data pribadi dan unggah dokumen persyaratan (KK, Rapor, Slip Gaji) untuk mengikuti proses seleksi beasiswa.
                </p>

                <div>
                    <a href="{{ route('siswa.pendaftaran.index') }}" class="bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-extrabold text-xs px-6 py-3 rounded-2xl transition shadow-lg shadow-indigo-500/30 inline-flex items-center gap-2">
                        Buka Form Pendaftaran Saya &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
