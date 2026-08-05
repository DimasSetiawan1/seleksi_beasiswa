<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Laporan & Cetak Hasil Seleksi</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Unduh berkas Surat Keputusan PDF dan data perangkingan spreadsheet Excel.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border border-slate-800">
            <div>
                <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Dokumen Resmi</span>
                <h3 class="text-xl font-bold">Cetak & Ekspor Laporan</h3>
                <p class="text-xs text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Dokumen PDF menyertakan format Surat Keputusan Penetapan resmi yang disahkan oleh Kepala Sekolah SMK Tinta Emas Indonesia.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.laporan.pdf') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold px-5 py-3 rounded-2xl text-xs shadow-lg shadow-rose-600/30 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Unduh SK PDF 📄
                </a>
                <a href="{{ route('admin.laporan.excel') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-3 rounded-2xl text-xs shadow-lg shadow-emerald-600/30 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel (.xlsx) 📊
                </a>
            </div>
        </div>

        <!-- Table Summary -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-extrabold text-lg text-slate-800">Daftar Ringkasan Perangkingan Beasiswa</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/60 text-xs">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Skor Akhir Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($mooraResults as $res)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 text-center font-black font-mono">#{{ $res->rank }}</td>
                                <td class="px-6 py-4 font-mono text-slate-500">{{ $res->applicant->nik }}</td>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $res->applicant->nama_lengkap }}</td>
                                <td class="px-6 py-4 font-mono font-extrabold text-indigo-700">{{ number_format($res->nilai_optimasi_yi, 4) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data laporan yang dapat ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
