<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Perangkingan Hasil Seleksi</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Penentuan urutan kelayakan pendaftar beasiswa berdasarkan evaluasi kriteria terpadu.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header Action Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="font-extrabold text-lg text-slate-800">Evaluasi Perangkingan Otomatis</h3>
                <p class="text-xs text-slate-500 mt-0.5">Sistem mengkalkulasi bobot tingkat kepentingan dan nilai pilihan sub-kriteria kandidat secara adil.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <form action="{{ route('admin.moora.calculate') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold px-5 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Hitung Perangkingan Seleksi
                    </button>
                </form>

                @if(count($mooraResults) > 0)
                    <form action="{{ route('admin.moora.send') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2.5 rounded-2xl text-xs shadow-lg shadow-emerald-600/30 transition flex items-center gap-2"
                            @if($proposal && $proposal->status === 'submitted') disabled @endif>
                            @if($proposal && $proposal->status === 'submitted')
                                ✓ Usulan Terkirim
                            @else
                                Kirim Usulan ke Kepsek &rarr;
                            @endif
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Table Perangkingan -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-extrabold text-lg text-slate-800">Tabel Peringkat Kandidat Penerima Beasiswa</h3>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-full border border-indigo-100">
                    Hasil Perangkingan Seleksi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/60 text-xs">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Pendaftar</th>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Detail</th>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($mooraResults as $res)
                            <tr class="hover:bg-slate-50/80 transition duration-150 @if($res->rank <= 5) bg-emerald-50/20 @endif">
                                <td class="px-6 py-4 text-center font-black text-base font-mono">
                                    @if($res->rank == 1)
                                        <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-xl shadow-xs border border-amber-200 inline-block">🥇 #1</span>
                                    @elseif($res->rank == 2)
                                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-xl border border-slate-200 inline-block">🥈 #2</span>
                                    @elseif($res->rank == 3)
                                        <span class="bg-amber-700/10 text-amber-900 px-3 py-1 rounded-xl border border-amber-700/20 inline-block">🥉 #3</span>
                                    @else
                                        <span class="text-slate-500">#{{ $res->rank }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $res->applicant->nama_lengkap }}
                                    <div class="font-mono text-[11px] text-slate-400 font-normal">NIK: {{ $res->applicant->nik }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.moora.show', $res->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition">
                                        Lihat Alasan
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($res->rank <= 5)
                                        <span class="bg-emerald-500/10 text-emerald-700 border border-emerald-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                                            ✔ Direkomendasikan Lolos
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-500 text-[10px] font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                                            Cadangan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data perangkingan. Tekan tombol "Hitung Perangkingan Seleksi" di atas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
