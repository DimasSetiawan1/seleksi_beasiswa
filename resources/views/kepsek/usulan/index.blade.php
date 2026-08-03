<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Persetujuan Hasil Seleksi Beasiswa</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Peninjauan hasil perangkingan penerima beasiswa dan pengesahan SK Penetapan.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(!$proposal || $proposal->status === 'draft')
            <div class="bg-amber-500/10 border border-amber-500/30 text-amber-800 p-6 rounded-3xl text-sm font-medium flex items-center gap-3">
                <svg class="w-6 h-6 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Panitia Kesiswaan / Admin belum mengirimkan daftar usulan penerima beasiswa periode ini.</span>
            </div>
        @else

            <!-- Approval Action Panel Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-extrabold text-lg text-slate-800">Status Usulan Pendaftaran</h3>
                    <p class="text-xs text-slate-500 mt-1">Periode: <span class="font-semibold text-slate-700">{{ $period->nama_periode }}</span></p>

                    <div class="mt-4">
                        <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider border inline-block
                            @if($proposal->status === 'submitted') bg-amber-500/10 text-amber-800 border-amber-500/30
                            @elseif($proposal->status === 'approved') bg-emerald-500/10 text-emerald-800 border-emerald-500/30
                            @else bg-rose-500/10 text-rose-800 border-rose-500/30 @endif">
                            ● Status Usulan:
                            @if($proposal->status === 'submitted') Dikirim Ke Kepsek
                            @elseif($proposal->status === 'approved') Disetujui
                            @else Ditolak / Perlu Revisi @endif
                        </span>
                    </div>

                    @if($proposal->catatan_kepsek)
                        <div class="mt-4 bg-slate-50 p-4 rounded-2xl text-xs text-slate-600 border border-slate-200/60">
                            <span class="font-bold text-slate-800">Catatan Kepsek:</span> {{ $proposal->catatan_kepsek }}
                        </div>
                    @endif
                </div>

                @if($proposal->status === 'submitted')
                    <div class="space-y-4 bg-slate-50/80 p-5 rounded-2xl border border-slate-200/60">
                        <h4 class="font-extrabold text-sm text-slate-800">Keputusan Kepala Sekolah</h4>

                        <!-- Form Approve -->
                        <form action="{{ route('kepsek.usulan.approve', $proposal->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 px-4 rounded-xl text-xs shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Setujui Usulan & Generate SK PDF
                            </button>
                        </form>

                        <!-- Form Reject -->
                        <form action="{{ route('kepsek.usulan.reject', $proposal->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <input type="text" name="catatan_kepsek" placeholder="Alasan pengembalian usulan (min 10 karakter)..." required class="w-full text-xs rounded-xl border-slate-200 py-2 focus:border-rose-500 focus:ring-rose-500">
                            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-extrabold py-2 px-4 rounded-xl text-xs shadow-md transition">
                                ✕ Kembalikan / Tolak Usulan
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Table Usulan -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-extrabold text-lg text-slate-800">Daftar Perangkingan Hasil Seleksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/60 text-xs">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-4 text-center font-bold text-slate-600 uppercase tracking-wider">Peringkat</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-600 uppercase tracking-wider">Skor Akhir Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($mooraResults as $res)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 text-center font-black font-mono">#{{ $res->rank }}</td>
                                    <td class="px-6 py-4 font-mono text-slate-500">{{ $res->applicant->nik }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $res->applicant->nama_lengkap }}</td>
                                    <td class="px-6 py-4 text-slate-600 font-semibold">{{ $res->applicant->kelas }}</td>
                                    <td class="px-6 py-4 font-mono font-extrabold text-indigo-700 text-sm">{{ number_format($res->nilai_optimasi_yi, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>
