<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Pembobotan Kriteria Penilaian</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Penentuan tingkat kepentingan relatif antar kriteria secara terukur.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(!$period)
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-700 px-4 py-3 rounded-2xl text-sm font-medium">
                Belum ada periode pendaftaran beasiswa yang aktif.
            </div>
        @elseif($criterias->count() < 2)
            <div class="bg-amber-500/10 border border-amber-500/30 text-amber-700 px-4 py-3 rounded-2xl text-sm font-medium">
                Pembobotan membutuhkan minimal 2 kriteria.
            </div>
        @else

            <!-- Alert Banner Consistency -->
            @if(isset($calculation))
                @if($calculation['isConsistent'])
                    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 p-5 rounded-3xl shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center font-bold shrink-0">✓</div>
                        <div>
                            <h4 class="font-extrabold text-base">Konsistensi Penilaian Sangat Baik</h4>
                            <p class="text-xs text-emerald-700 mt-0.5">
                                Penilaian perbandingan kriteria telah memenuhi syarat konsistensi terukur. Bobot kriteria berhasil disimpan ke sistem!
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-rose-500/10 border border-rose-500/30 text-rose-800 p-5 rounded-3xl shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-rose-500 text-white flex items-center justify-center font-bold shrink-0">✕</div>
                        <div>
                            <h4 class="font-extrabold text-base">Penilaian Kurang Konsisten</h4>
                            <p class="text-xs text-rose-700 mt-0.5">
                                Harap menyesuaikan kembali nilai perbandingan antar kriteria agar penilaian lebih seimbang dan konsisten.
                            </p>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Scale Reference Card -->
            <div class="bg-indigo-900 text-white rounded-3xl p-6 shadow-xl border border-indigo-800">
                <h4 class="font-extrabold text-sm uppercase tracking-wider text-indigo-200 mb-2">💡 Panduan Skala Tingkat Kepentingan (1 - 9)</h4>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-[11px] font-medium text-indigo-100">
                    <div class="bg-indigo-800/60 p-2 rounded-xl border border-indigo-700/50"><span class="font-bold font-mono text-white">1</span> = Sama Penting</div>
                    <div class="bg-indigo-800/60 p-2 rounded-xl border border-indigo-700/50"><span class="font-bold font-mono text-white">3</span> = Sedikit Lebih Penting</div>
                    <div class="bg-indigo-800/60 p-2 rounded-xl border border-indigo-700/50"><span class="font-bold font-mono text-white">5</span> = Lebih Penting</div>
                    <div class="bg-indigo-800/60 p-2 rounded-xl border border-indigo-700/50"><span class="font-bold font-mono text-white">7</span> = Sangat Penting</div>
                    <div class="bg-indigo-800/60 p-2 rounded-xl border border-indigo-700/50"><span class="font-bold font-mono text-white">9</span> = Mutlak Lebih Penting</div>
                </div>
            </div>

            <!-- Form Matriks Perbandingan -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                <h3 class="font-extrabold text-lg text-slate-800 mb-4">Matriks Perbandingan Berpasangan</h3>

                <form action="{{ route('admin.ahp.calculate') }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200/60 text-xs">
                            <thead class="bg-slate-900 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold border-r border-slate-800">Kriteria</th>
                                    @foreach($criterias as $c)
                                        <th class="px-4 py-3 text-center font-bold">{{ $c->nama_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($criterias as $ci)
                                    <tr>
                                        <td class="px-4 py-3 font-bold bg-slate-50 border-r border-slate-200 text-slate-800">
                                            {{ $ci->nama_kriteria }}
                                        </td>
                                        @foreach($criterias as $cj)
                                            <td class="px-3 py-3 text-center border-r border-slate-100">
                                                @if($ci->id == $cj->id)
                                                    <input type="text" readonly value="1" class="w-16 text-center bg-slate-100 rounded-xl border-slate-200 font-bold text-slate-400 py-1 text-xs">
                                                @else
                                                    @php $val = $existingMatrix[$ci->id][$cj->id] ?? 1; @endphp
                                                    <input type="number" step="any" min="0.0001" max="9" name="matrix[{{ $ci->id }}][{{ $cj->id }}]" value="{{ $val }}" class="w-20 text-center rounded-xl border-slate-200 font-bold text-indigo-700 focus:border-indigo-500 focus:ring-indigo-500 py-1 text-xs">
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold px-6 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition">
                            Hitung & Simpan Bobot Kriteria
                        </button>
                    </div>
                </form>
            </div>

            <!-- Output Bobot -->
            @if($ahpResults->count() > 0)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                    <h3 class="font-extrabold text-lg text-slate-800 mb-4">Hasil Pembobotan Tingkat Kepentingan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        @foreach($criterias as $c)
                            @php $res = $ahpResults[$c->id] ?? null; @endphp
                            <div class="p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100 flex flex-col justify-between">
                                <span class="text-[10px] font-extrabold uppercase text-indigo-600">Kriteria Penilaian</span>
                                <h4 class="font-bold text-slate-800 text-xs mt-1">{{ $c->nama_kriteria }}</h4>
                                <div class="mt-3 pt-2 border-t border-indigo-100/60 flex justify-between items-baseline">
                                    <span class="text-xs text-slate-400">Persentase:</span>
                                    <span class="font-extrabold font-mono text-indigo-700 text-sm">
                                        {{ number_format(($res ? $res->bobot_eigen : 0) * 100, 1) }}%
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif

    </div>
</x-app-layout>
