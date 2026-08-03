<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Form Pendaftaran Beasiswa</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Lengkapi data pribadi dan unggah dokumen persyaratan digital.</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(!$period)
            <div class="bg-amber-500/10 border border-amber-500/30 text-amber-800 p-6 rounded-3xl text-sm font-medium flex items-center gap-3">
                <svg class="w-6 h-6 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Saat ini tidak ada periode pendaftaran beasiswa yang sedang dibuka.</span>
            </div>
        @else

            <!-- Status Header Banner -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-[10px] font-extrabold font-mono text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-lg">Periode Aktif</span>
                    <h3 class="font-extrabold text-lg text-slate-800 mt-1">{{ $period->nama_periode }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tahun Ajaran: {{ $period->tahun_ajaran }} &bull; Batas Akhir: {{ $period->tgl_tutup }}</p>
                </div>
                <div>
                    <span class="px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider border inline-block
                        @if(!$applicant) bg-slate-100 text-slate-600 border-slate-200
                        @elseif($applicant->status_berkas === 'draft') bg-amber-500/10 text-amber-700 border-amber-500/30
                        @elseif($applicant->status_berkas === 'submitted') bg-blue-500/10 text-blue-700 border-blue-500/30
                        @elseif($applicant->status_berkas === 'verifikasi') bg-emerald-500/10 text-emerald-700 border-emerald-500/30
                        @else bg-rose-500/10 text-rose-700 border-rose-500/30 @endif">
                        Status Pendaftaran: {{ $applicant->status_berkas ?? 'Belum Mendaftar' }}
                    </span>
                </div>
            </div>

            <!-- Step 1: Form Data Pribadi -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">1</div>
                    <h3 class="font-extrabold text-base text-slate-800">Data Pribadi Siswa</h3>
                </div>

                <form action="{{ route('siswa.pendaftaran.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" value="{{ old('nik', $applicant->nik ?? '') }}" required class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $applicant->nama_lengkap ?? auth()->user()->name) }}" required class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelas / Konsentrasi Keahlian</label>
                        <input type="text" name="kelas" placeholder="Contoh: XII RPL 1" value="{{ old('kelas', $applicant->kelas ?? '') }}" required class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                    </div>
                    <div class="md:col-span-2 flex justify-end pt-2">
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold px-6 py-2.5 rounded-2xl text-xs shadow-md transition">
                            Simpan Data Diri
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Upload Dokumen -->
            @if($applicant)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">2</div>
                        <h3 class="font-extrabold text-base text-slate-800">Unggah Dokumen Persyaratan Digital</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $requiredDocs = [
                                'kartu_keluarga' => 'Kartu Keluarga (KK)',
                                'rapor_terakhir' => 'Rapor Semester Terakhir',
                                'slip_gaji' => 'Slip Gaji / Surat Penghasilan Ortu'
                            ];
                            $uploadedDocs = $applicant->documents->keyBy('jenis_dokumen');
                        @endphp

                        @foreach($requiredDocs as $key => $label)
                            <div class="p-5 rounded-2xl border border-slate-200/60 bg-slate-50/50 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-extrabold text-xs text-slate-800">{{ $label }}</h4>
                                    <p class="text-[11px] text-slate-400 mt-1">Format: PDF/JPG/PNG (Max 5MB)</p>

                                    @if(isset($uploadedDocs[$key]))
                                        <div class="mt-3 inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200">
                                            ✓ Sudah Diunggah
                                        </div>
                                    @else
                                        <div class="mt-3 inline-flex items-center gap-1 text-[10px] font-extrabold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200">
                                            ⚠ Belum Diunggah
                                        </div>
                                    @endif
                                </div>

                                <form action="{{ route('siswa.pendaftaran.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                    <input type="hidden" name="jenis_dokumen" value="{{ $key }}">
                                    <input type="file" name="file_dokumen" required class="block w-full text-[11px] text-slate-500 mb-3 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 rounded-xl text-xs shadow-md transition">
                                        Upload {{ $label }}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif

    </div>
</x-app-layout>
