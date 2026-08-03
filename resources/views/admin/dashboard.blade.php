<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Dashboard Admin Kesiswaan</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola data pendaftar, kriteria penilaian, dan jalankan perangkingan penerima beasiswa.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Pendaftar</span>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 font-mono tracking-tight">
                    {{ \App\Models\Applicant::count() }}
                </div>
                <p class="text-xs text-slate-500 mt-2">Siswa terdaftar periode ini</p>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Kriteria Penilaian</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 font-mono tracking-tight">
                    {{ \App\Models\Criteria::count() }}
                </div>
                <p class="text-xs text-emerald-600 font-semibold mt-2">✓ Sub-kriteria terpasang</p>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Status Konsistensi</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-xl font-extrabold text-slate-900">
                    @php $ahpRes = \App\Models\AhpResult::first(); @endphp
                    @if($ahpRes && $ahpRes->is_consistent)
                        <span class="text-emerald-600 flex items-center gap-1">Sangat Konsisten</span>
                    @else
                        <span class="text-amber-600">Perlu Pembobotan</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-2">Penilaian kriteria terukur</p>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Status Usulan Kepsek</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    </div>
                </div>
                <div class="text-xl font-extrabold text-slate-900">
                    @php $prop = \App\Models\Proposal::first(); @endphp
                    <span class="uppercase tracking-wider text-xs px-3 py-1 rounded-full font-bold
                        @if($prop && $prop->status === 'approved') bg-emerald-100 text-emerald-800
                        @elseif($prop && $prop->status === 'submitted') bg-amber-100 text-amber-800
                        @else bg-slate-100 text-slate-600 @endif">
                        @if($prop && $prop->status === 'approved') Disetujui
                        @elseif($prop && $prop->status === 'submitted') Dikirim
                        @else Belum Dikirim @endif
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-2">Persetujuan akhir penerima</p>
            </div>
        </div>

        <!-- Quick Access Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden border border-slate-800">
            <div class="relative z-10 max-w-2xl">
                <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-widest mb-3 inline-block">
                    Alur Seleksi Terpadu
                </span>
                <h3 class="text-2xl font-black tracking-tight text-white mb-2">Sistem Informasi Seleksi Beasiswa</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6">
                    Sistem mengolah bobot tingkat kepentingan kriteria dan pilihan sub-kriteria siswa untuk menghasilkan urutan peringkat siswa penerima beasiswa secara adil dan objektif.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.kriteria.index') }}" class="bg-white text-slate-900 font-extrabold text-xs px-5 py-3 rounded-2xl hover:bg-slate-100 transition shadow-lg">
                        1. Kriteria & Sub
                    </a>
                    <a href="{{ route('admin.ahp.index') }}" class="bg-indigo-600 text-white font-extrabold text-xs px-5 py-3 rounded-2xl hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/30">
                        2. Bobot Kriteria
                    </a>
                    <a href="{{ route('admin.kandidat.index') }}" class="bg-slate-800 text-slate-200 border border-slate-700 font-extrabold text-xs px-5 py-3 rounded-2xl hover:bg-slate-700 transition">
                        3. Penilaian Siswa
                    </a>
                    <a href="{{ route('admin.moora.index') }}" class="bg-emerald-600 text-white font-extrabold text-xs px-5 py-3 rounded-2xl hover:bg-emerald-500 transition shadow-lg shadow-emerald-600/30">
                        4. Hasil Perangkingan &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
