<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">Form Pendaftaran & Penilaian Siswa</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Lengkapi data pribadi, pilih kondisi kriteria penilaian, dan unggah berkas digital.</p>
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
                        Status Pendaftaran:
                        @if(!$applicant) Belum Mendaftar
                        @elseif($applicant->status_berkas === 'submitted') Dikirim Ke Panitia
                        @elseif($applicant->status_berkas === 'verifikasi') Terverifikasi
                        @elseif($applicant->status_berkas === 'draft') Draf
                        @else Ditolak @endif
                    </span>
                </div>
            </div>

            <!-- Form Terpadu (Data Diri + Penilaian Kriteria) -->
            <form action="{{ route('ortu.pendaftaran.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Data Diri Siswa -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">1</div>
                        <h3 class="font-extrabold text-base text-slate-800">Data Pribadi Putra/Putri Siswa</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIK: lock jika sudah ada data -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                            @if($applicant && $applicant->nik)
                                {{-- NIK sudah terisi, tampilkan read-only --}}
                                <div class="w-full rounded-xl border border-slate-200 bg-slate-50 text-xs font-mono font-semibold text-slate-600 px-3 py-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    {{ $applicant->nik }}
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">NIK tidak dapat diubah setelah disimpan.</p>
                                <input type="hidden" name="nik" value="{{ $applicant->nik }}">
                            @else
                                <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" minlength="16" pattern="[0-9]{16}" inputmode="numeric"
                                    placeholder="Masukkan 16 digit NIK"
                                    class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">NIK tidak dapat diubah setelah disimpan pertama kali.</p>
                            @endif
                            @error('nik')
                                <p class="text-[11px] text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $applicant->nama_lengkap ?? '') }}" required
                                placeholder="Hanya huruf dan spasi" pattern="[A-Za-z\s]+"
                                class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Nama hanya boleh berisi huruf dan spasi, tanpa angka atau simbol.</p>
                            @error('nama_lengkap')
                                <p class="text-[11px] text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Penilaian Kriteria Siswa (Digabung di form input siswa!) -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">2</div>
                        <div>
                            <h3 class="font-extrabold text-base text-slate-800">Kondisi & Kriteria Penilaian Siswa</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pilih kondisi yang sesuai dengan putra/putri Bapak/Ibu untuk diproses dalam seleksi.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($criterias as $c)
                            @php
                                $scoreVal = $existingScores[$c->id]->nilai_kriteria ?? null;
                            @endphp
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                        {{ $c->nama_kriteria }}
                                    </label>
                                    <span class="text-[10px] font-semibold text-slate-500">
                                        {{ $c->deskripsi }}
                                    </span>
                                </div>

                                <select name="scores[{{ $c->id }}]" required class="w-full rounded-xl border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2 bg-white">
                                    <option value="" disabled @selected(is_null($scoreVal))>-- Pilih Kondisi {{ $c->nama_kriteria }} --</option>
                                    @foreach($c->subCriterias as $sub)
                                        <option value="{{ $sub->nilai }}" @selected($scoreVal == $sub->nilai)>
                                            {{ $sub->nama_subkriteria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-extrabold px-6 py-3 rounded-2xl text-xs shadow-lg shadow-indigo-500/20 transition">
                            Simpan Data & Penilaian Siswa
                        </button>
                    </div>
                </div>

            </form>

            <!-- Section 3: Upload Dokumen Persyaratan Digital -->
            @if($applicant)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">3</div>
                        <h3 class="font-extrabold text-base text-slate-800">Unggah Dokumen Persyaratan Digital</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $requiredDocs = [
                                'sktm' => 'Surat Keterangan Tidak Mampu (SKTM)',
                                'transkip_nilai' => 'Transkip Nilai / Rapor',
                                'slip_gaji' => 'Slip Gaji / Surat Penghasilan Ortu'
                            ];
                            $uploadedDocs = $applicant->documents->keyBy('jenis_dokumen');
                        @endphp

                        @foreach($requiredDocs as $key => $label)
                            @php $uploaded = isset($uploadedDocs[$key]); @endphp
                            <div class="p-5 rounded-2xl border {{ $uploaded ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200/60 bg-slate-50/50' }} flex flex-col justify-between gap-4">
                                <div>
                                    <h4 class="font-extrabold text-xs text-slate-800">{{ $label }}</h4>
                                    <p class="text-[11px] text-slate-400 mt-1">Format: PDF/JPG/PNG (Max 5MB)</p>

                                    @if($uploaded)
                                        <div class="mt-3 inline-flex items-center gap-1.5 text-[10px] font-extrabold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-lg border border-emerald-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Sudah Diunggah
                                        </div>
                                    @else
                                        <div class="mt-3 inline-flex items-center gap-1.5 text-[10px] font-extrabold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            Belum Diunggah
                                        </div>
                                    @endif
                                </div>

                                <form action="{{ route('ortu.pendaftaran.upload') }}" method="POST" enctype="multipart/form-data" id="form-{{ $key }}">
                                    @csrf
                                    <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                    <input type="hidden" name="jenis_dokumen" value="{{ $key }}">
                                    {{-- Hidden file input --}}
                                    <input type="file" name="file_dokumen" id="file-{{ $key }}" required accept=".pdf,.jpg,.jpeg,.png"
                                        class="hidden"
                                        onchange="handleFileSelect('{{ $key }}')">
                                    {{-- Single styled button --}}
                                    <button type="button"
                                        onclick="document.getElementById('file-{{ $key }}').click()"
                                        id="btn-{{ $key }}"
                                        class="w-full flex items-center justify-center gap-2 {{ $uploaded ? 'bg-white border-2 border-indigo-100 text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200' : 'bg-indigo-600 hover:bg-indigo-700 text-white' }} font-extrabold py-2.5 rounded-xl text-xs shadow-sm transition">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        <span id="btn-label-{{ $key }}">{{ $uploaded ? 'Ganti Dokumen' : 'Pilih & Upload File' }}</span>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <script>
                        function handleFileSelect(key) {
                            const input = document.getElementById('file-' + key);
                            const btn = document.getElementById('btn-' + key);
                            const label = document.getElementById('btn-label-' + key);
                            if (input.files && input.files[0]) {
                                const name = input.files[0].name;
                                const shortName = name.length > 25 ? name.substring(0, 22) + '...' : name;
                                label.textContent = '✓ ' + shortName + ' — Mengunggah...';
                                btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700', 'bg-slate-600', 'hover:bg-slate-700');
                                btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                                // Auto-submit setelah file dipilih
                                setTimeout(() => {
                                    document.getElementById('form-' + key).submit();
                                }, 300);
                            }
                        }
                    </script>
                </div>
            @endif

        @endif

    </div>
</x-app-layout>
