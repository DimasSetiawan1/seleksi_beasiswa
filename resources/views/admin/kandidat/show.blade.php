<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kandidat.index') }}" class="p-2 rounded-xl bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50 transition shadow-2xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Detail & Penilaian Pendaftar</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Verifikasi kelengkapan berkas dan pilih opsi penilaian sub-kriteria.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Col 1: Profil & Status -->
            <div class="space-y-6">
                <!-- User Profile Card -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-800 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            {{ strtoupper(substr($applicant->nama_lengkap, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-extrabold text-lg text-slate-800">{{ $applicant->nama_lengkap }}</h3>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-500">NIK Siswa</span>
                            <span class="font-bold font-mono text-slate-700">{{ $applicant->nik }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-500">Email Akun</span>
                            <span class="font-medium text-slate-700">{{ $applicant->user->email }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-500">Status Berkas</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider
                                @if($applicant->status_berkas === 'draft') bg-amber-500/10 text-amber-700 border border-amber-500/30
                                @elseif($applicant->status_berkas === 'submitted') bg-blue-500/10 text-blue-700 border border-blue-500/30
                                @elseif($applicant->status_berkas === 'verifikasi') bg-emerald-500/10 text-emerald-700 border border-emerald-500/30
                                @else bg-rose-500/10 text-rose-700 border border-rose-500/30 @endif">
                                @if($applicant->status_berkas === 'submitted') Menunggu Verifikasi
                                @elseif($applicant->status_berkas === 'verifikasi') Terverifikasi
                                @elseif($applicant->status_berkas === 'draft') Draf
                                @else Ditolak @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Update Status Card -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                    <h4 class="font-bold text-slate-800 text-sm mb-3">Update Status Verifikasi Berkas</h4>
                    <form action="{{ route('admin.kandidat.verify', $applicant->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <select name="status_berkas" class="w-full rounded-2xl border-slate-200 text-xs font-semibold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                            <option value="submitted" @selected($applicant->status_berkas === 'submitted')>Menunggu Verifikasi (Dikirim)</option>
                            <option value="verifikasi" @selected($applicant->status_berkas === 'verifikasi')>Lengkap / Terverifikasi</option>
                            <option value="ditolak" @selected($applicant->status_berkas === 'ditolak')>Ditolak / Tidak Lengkap</option>
                        </select>
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 rounded-2xl text-xs shadow-md transition">
                            Simpan Status Berkas
                        </button>
                    </form>
                </div>
            </div>

            <!-- Col 2 & 3: Form Input Sub-Kriteria & Documents -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Form Penilaian Berdasarkan Sub-Kriteria Sistem -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-slate-800">Penilaian Sub-Kriteria Siswa</h3>
                            <p class="text-xs text-slate-500">Pilih opsi sub-kriteria yang paling sesuai dengan kondisi pendaftar ini.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.kandidat.score', $applicant->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @foreach($criterias as $c)
                            @php
                                $scoreVal = $existingScores[$c->id]->nilai_kriteria ?? null;
                            @endphp
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                        <span class="bg-indigo-600 text-white font-mono text-[10px] px-2 py-0.5 rounded-md">C{{ $c->id }}</span>
                                        {{ $c->nama_kriteria }}
                                    </label>
                                    <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full border
                                        @if($c->tipe === 'benefit') bg-emerald-50 text-emerald-700 border-emerald-200 @else bg-amber-50 text-amber-700 border-amber-200 @endif">
                                        @if($c->tipe === 'benefit') Kriteria Pendukung @else Kriteria Pengurang @endif
                                    </span>
                                </div>

                                <!-- Sub-Criteria Dropdown Select -->
                                <select name="scores[{{ $c->id }}]" required class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2 bg-white">
                                    <option value="" disabled @selected(is_null($scoreVal))>-- Pilih Opsi Sub-Kriteria --</option>
                                    @foreach($c->subCriterias as $sub)
                                        <option value="{{ $sub->nilai }}" @selected($scoreVal == $sub->nilai)>
                                            {{ $sub->nama_subkriteria }} (Skor Nilai: {{ $sub->nilai }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-extrabold px-6 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-500/20 transition duration-200">
                                Simpan Penilaian Sub-Kriteria
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Uploaded Documents Preview -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                    <h3 class="font-extrabold text-base text-slate-800 mb-4">Berkas Persyaratan Diunggah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($applicant->documents as $doc)
                            <div class="p-4 rounded-2xl border border-slate-200/60 bg-slate-50/50 flex flex-col justify-between">
                                <div>
                                    <span class="text-[10px] font-extrabold uppercase text-indigo-700 tracking-wider bg-indigo-50 px-2 py-0.5 rounded">
                                        {{ str_replace('_', ' ', $doc->jenis_dokumen) }}
                                    </span>
                                    <p class="text-[11px] text-slate-400 mt-2">Diunggah: {{ $doc->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="block text-center bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-2 rounded-xl transition">
                                        Buka File 📄
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-6 text-slate-400 text-xs italic bg-slate-50 rounded-2xl">
                                Belum ada berkas dokumen yang diunggah oleh pendaftar ini.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
