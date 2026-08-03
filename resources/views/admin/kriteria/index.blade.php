<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Kriteria & Sub-Kriteria Penilaian</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Parameter standar seleksi beasiswa yang dikonfigurasi oleh sistem.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Notice Banner: Pre-set by System -->
        <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-700 rounded-3xl p-6 text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-indigo-100 mb-2">
                    ⚡ Default Konfigurasi Sistem
                </div>
                <h3 class="text-xl font-bold">5 Kriteria Penilaian Utama & Sub-Kriteria Pilihan</h3>
                <p class="text-xs text-indigo-100 mt-1 max-w-2xl leading-relaxed">
                    Kriteria dan pilihan sub-kriteria di bawah ini telah dikonfigurasi otomatis sesuai dengan pedoman resmi seleksi beasiswa SMK Tinta Emas Indonesia.
                </p>
            </div>
        </div>

        <!-- Grid Kriteria & Sub-Kriteria -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($criterias as $index => $c)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                    <div>
                        <!-- Header Card -->
                        <div class="flex justify-between items-start gap-2 mb-4">
                            <div>
                                <span class="text-[11px] font-extrabold font-mono text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-lg">Kriteria {{ $index + 1 }}</span>
                                <h4 class="font-extrabold text-slate-800 text-lg mt-2">{{ $c->nama_kriteria }}</h4>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border shrink-0
                                @if($c->tipe === 'benefit') bg-emerald-500/10 text-emerald-700 border-emerald-500/30 @else bg-amber-500/10 text-amber-700 border-amber-500/30 @endif">
                                @if($c->tipe === 'benefit') Kriteria Pendukung @else Kriteria Pengurang @endif
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 mb-4 line-clamp-2 leading-relaxed">{{ $c->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                        <!-- Bobot Badge -->
                        <div class="bg-slate-50 rounded-2xl p-3 mb-4 flex justify-between items-center border border-slate-100">
                            <span class="text-xs font-semibold text-slate-500">Tingkat Kepentingan</span>
                            <span class="font-extrabold font-mono text-indigo-600 text-sm bg-white px-2.5 py-0.5 rounded-lg border border-slate-200 shadow-2xs">
                                {{ number_format(($c->bobot ?? 0) * 100, 1) }}%
                            </span>
                        </div>

                        <!-- List Sub Kriteria -->
                        <div>
                            <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                Pilihan Sub-Kriteria
                            </h5>
                            <div class="space-y-1.5">
                                @forelse($c->subCriterias as $sub)
                                    <div class="flex justify-between items-center text-xs p-2 rounded-xl bg-slate-50/80 hover:bg-slate-100/80 transition">
                                        <span class="text-slate-700 font-medium">{{ $sub->nama_subkriteria }}</span>
                                        <span class="font-bold font-mono bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-md border border-indigo-100">
                                            Skor: {{ $sub->nilai }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-xs text-slate-400 italic py-1">Belum ada sub-kriteria.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
