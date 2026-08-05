<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Manajemen Kandidat & Verifikasi</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Daftar siswa pendaftar seleksi beasiswa periode aktif.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="font-extrabold text-lg text-slate-800">Daftar Pendaftar Beasiswa</h3>
                    <p class="text-xs text-slate-500">Periksa kelengkapan berkas dan lakukan penilaian kriteria.</p>
                </div>
                <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Total: {{ count($applicants) }} Pendaftar
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/60 text-xs">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Pendaftar</th>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Status Berkas</th>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Input Sub-Kriteria</th>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($applicants as $app)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-700 text-white font-extrabold text-xs flex items-center justify-center shadow-md shadow-indigo-500/20">
                                            {{ strtoupper(substr($app->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-sm">{{ $app->nama_lengkap }}</div>
                                            <div class="font-mono text-[11px] text-slate-400">NIK: {{ $app->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border inline-block
                                        @if($app->status_berkas === 'draft') bg-amber-500/10 text-amber-700 border-amber-500/30
                                        @elseif($app->status_berkas === 'submitted') bg-blue-500/10 text-blue-700 border-blue-500/30
                                        @elseif($app->status_berkas === 'verifikasi') bg-emerald-500/10 text-emerald-700 border-emerald-500/30
                                        @else bg-rose-500/10 text-rose-700 border-rose-500/30 @endif">
                                        {{ ucfirst($app->status_berkas) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($app->scores->count() > 0)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Sudah Dinilai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-lg">
                                            ⚠ Belum Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.kandidat.show', $app->id) }}" class="inline-flex items-center gap-1 bg-slate-900 hover:bg-slate-800 text-white font-bold px-3.5 py-1.5 rounded-xl text-xs shadow-md transition">
                                        Detail & Nilai &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada kandidat yang mendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
