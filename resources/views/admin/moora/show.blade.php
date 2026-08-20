<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.moora.index') }}" class="p-2 hover:bg-slate-200 rounded-full transition">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Detail Alasan Penerimaan</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Penjelasan mendetail mengenai hasil evaluasi kandidat.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200/80">
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ $mooraResult->applicant->nama_lengkap }}</h3>
                    <p class="text-slate-500 font-mono text-sm">NIK: {{ $mooraResult->applicant->nik }}</p>
                </div>

                @if($mooraResult->rank <= 5)
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl w-full max-w-md">
                        <p class="font-bold text-lg">
                            DIREKOMENDASIKAN LOLOS (Peringkat #{{ $mooraResult->rank }})
                        </p>
                        <p class="text-xs mt-1 text-emerald-600 font-medium">Pendaftar dinyatakan memenuhi syarat kualifikasi dan masuk dalam kuota utama penerima beasiswa.</p>
                    </div>
                @else
                    <div class="bg-slate-50 border border-slate-200 text-slate-700 px-6 py-4 rounded-xl w-full max-w-md">
                        <p class="font-bold text-lg">
                            CADANGAN (Peringkat #{{ $mooraResult->rank }})
                        </p>
                        <p class="text-xs mt-1 text-slate-500 font-medium">Pendaftar memenuhi kelayakan administrasi namun berada di luar kuota utama penerima beasiswa.</p>
                    </div>
                @endif
            </div>

            <hr class="my-8 border-slate-100">

            <div>
                <h4 class="font-extrabold text-lg text-slate-800 mb-4">Rincian Data Kualifikasi</h4>
                <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                    Berikut adalah rincian hasil verifikasi data pendaftar berdasarkan kriteria yang telah ditetapkan.
                </p>

                <div class="overflow-hidden border border-slate-200/80 rounded-2xl">
                    <table class="min-w-full text-sm divide-y divide-slate-100">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-slate-600 w-1/2">Kriteria</th>
                                <th class="px-6 py-4 text-right font-bold text-slate-600">Detail Kondisi / Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($mooraResult->applicant->scores as $score)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $score->criteria->nama_kriteria ?? 'Kriteria Dihapus' }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-700">
                                    {{ \App\Models\SubCriteria::where('criteria_id', $score->criteria_id)->orderByRaw("ABS(nilai - " . floatval($score->nilai_kriteria) . ")")->value('nama_subkriteria') ?? $score->nilai_kriteria }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <h5 class="font-bold text-slate-800 mb-2">Keputusan Final</h5>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Berdasarkan hasil verifikasi dan kalkulasi pembobotan seluruh kriteria, pendaftar ini ditetapkan pada peringkat ke-<strong>{{ $mooraResult->rank }}</strong> dari total keseluruhan pendaftar yang telah diverifikasi.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
