<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Seleksi Beasiswa - SMK Tinta Emas Indonesia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white min-h-full flex flex-col">

        <!-- Glowing Ambient Background Effects -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-40 w-96 h-96 bg-cyan-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 flex flex-col min-h-screen">

            <!-- Navbar Halaman Depan -->
            <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-xl sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="Logo SMK Tinta Emas Indonesia" class="h-11 w-auto object-contain">
                        <div>
                            <span class="font-extrabold text-lg tracking-tight text-white block">SELEKSI BEASISWA</span>
                            <span class="text-[10px] text-indigo-400 font-semibold uppercase tracking-wider">SMK Tinta Emas Indonesia</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-xs px-5 py-2.5 rounded-2xl transition shadow-lg shadow-indigo-600/30">
                                    Buka Dashboard &rarr;
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-semibold text-xs px-4 py-2 rounded-xl transition">
                                    Masuk Akun
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-extrabold text-xs px-5 py-2.5 rounded-2xl transition shadow-lg shadow-indigo-600/30">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <section class="py-20 lg:py-28 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center flex flex-col items-center justify-center">
                <div class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-8 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Keputusan Seleksi Beasiswa Terpadu
                </div>

                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight max-w-4xl leading-tight">
                    Seleksi Penerima Beasiswa Secara <span class="bg-gradient-to-r from-indigo-400 via-cyan-400 to-emerald-400 bg-clip-text text-transparent">Objektif & Transparan</span>
                </h1>

                <p class="mt-6 text-base sm:text-lg text-slate-400 max-w-2xl font-normal leading-relaxed">
                    Aplikasi web resmi Bagian Kesiswaan SMK Tinta Emas Indonesia untuk menyeleksi penerima beasiswa secara rasional, terukur, dan terstruktur.
                </p>

                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500 hover:from-indigo-500 hover:to-cyan-400 text-white font-extrabold text-sm px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/40 transition hover:-translate-y-0.5">
                            Masuk Ke Dashboard &rarr;
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500 hover:from-indigo-500 hover:to-cyan-400 text-white font-extrabold text-sm px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/40 transition hover:-translate-y-0.5">
                            Daftar Beasiswa Online
                        </a>
                        <a href="{{ route('login') }}" class="bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-800 font-extrabold text-sm px-8 py-4 rounded-2xl transition">
                            Masuk Pengguna
                        </a>
                    @endauth
                </div>

                <!-- Stats Highlight -->
                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 w-full max-w-4xl border-t border-slate-800/80 pt-10">
                    <div>
                        <div class="text-3xl font-black text-white font-mono">100%</div>
                        <div class="text-xs text-slate-400 font-medium mt-1">Transparan & Terukur</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-cyan-400 font-mono">Konsisten</div>
                        <div class="text-xs text-slate-400 font-medium mt-1">Penilaian Seimbang</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-emerald-400 font-mono">Otomatis</div>
                        <div class="text-xs text-slate-400 font-medium mt-1">Perangkingan Terpadu</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-indigo-400 font-mono">PDF SK</div>
                        <div class="text-xs text-slate-400 font-medium mt-1">Pengesahan Otomatis</div>
                    </div>
                </div>
            </section>

            <!-- Feature Highlights Grid -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Keunggulan Sistem Evaluasi Beasiswa</h2>
                    <p class="text-xs text-slate-400 mt-2">Menggantikan proses evaluasi manual yang rentan inkonsistensi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-900/60 p-8 rounded-3xl border border-slate-800 backdrop-blur-md hover:border-indigo-500/50 transition duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold mb-6">
                            ⚖️
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Pembobotan Kriteria Utama</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Analisis perbandingan antar kriteria memastikan setiap parameter penilaian diberikan pembobotan rasional dan seimbang.
                        </p>
                    </div>

                    <div class="bg-slate-900/60 p-8 rounded-3xl border border-slate-800 backdrop-blur-md hover:border-cyan-500/50 transition duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold mb-6">
                            📊
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Evaluasi Perangkingan Akhir</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Kalkulasi otomatis menghitung skor akumulasi nilai dengan menyeimbangkan seluruh kriteria untuk menentukan siswa penerima yang paling layak.
                        </p>
                    </div>

                    <div class="bg-slate-900/60 p-8 rounded-3xl border border-slate-800 backdrop-blur-md hover:border-emerald-500/50 transition duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold mb-6">
                            📑
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Dokumen SK Penetapan PDF</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Setelah disetujui oleh Kepala Sekolah, sistem secara otomatis meng-generate Surat Keputusan (SK) Penetapan resmi dalam format PDF yang siap diunduh.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Workflow Section -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full border-t border-slate-800/80">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Alur Pendaftaran & Seleksi</h2>
                    <p class="text-xs text-slate-400 mt-2">Langkah mudah mengikuti pendaftaran beasiswa secara online.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800 text-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold text-sm flex items-center justify-center mx-auto mb-4">1</div>
                        <h4 class="font-bold text-sm text-white mb-1">Registrasi Akun</h4>
                        <p class="text-xs text-slate-400">Siswa mendaftar akun menggunakan email dan kata sandi.</p>
                    </div>
                    <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800 text-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold text-sm flex items-center justify-center mx-auto mb-4">2</div>
                        <h4 class="font-bold text-sm text-white mb-1">Isi Data & Upload Berkas</h4>
                        <p class="text-xs text-slate-400">Lengkapi NIK, Kelas, serta unggah KK, Rapor, dan Slip Gaji.</p>
                    </div>
                    <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800 text-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold text-sm flex items-center justify-center mx-auto mb-4">3</div>
                        <h4 class="font-bold text-sm text-white mb-1">Verifikasi & Penilaian</h4>
                        <p class="text-xs text-slate-400">Admin memverifikasi berkas dan menginput sub-kriteria.</p>
                    </div>
                    <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800 text-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-extrabold text-sm flex items-center justify-center mx-auto mb-4">4</div>
                        <h4 class="font-bold text-sm text-white mb-1">Pengumuman & SK</h4>
                        <p class="text-xs text-slate-400">Kepsek menyetujui usulan dan pengumuman diterbitkan.</p>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="mt-auto border-t border-slate-800/80 py-8 bg-slate-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="Logo SMK Tinta Emas Indonesia" class="h-6 w-auto object-contain">
                        <span class="font-extrabold text-slate-300">SMK TINTA EMAS INDONESIA</span>
                        <span>&bull; Sistem Seleksi Beasiswa Terpadu</span>
                    </div>
                    <div>
                        &copy; {{ date('Y') }} Bagian Kesiswaan. All rights reserved.
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>
