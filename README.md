# Sistem Pendukung Keputusan (SPK) Seleksi Beasiswa

**SMK Tinta Emas**

Aplikasi Sistem Pendukung Keputusan (SPK) berbasis web untuk seleksi penerimaan beasiswa prestasi dan ekonomi di SMK Tinta Emas. Sistem ini dibangun menggunakan framework Laravel dan mengimplementasikan metode **AHP (Analytical Hierarchy Process)** untuk pembobotan kriteria dan **MOORA (Multi-Objective Optimization on the basis of Ratio Analysis)** untuk perankingan kandidat.

## 🚀 Fitur Utama

Sistem ini memiliki 3 hak akses pengguna (Role), yaitu:

### 1. Admin (Panitia Beasiswa)

- **Dashboard**: Ringkasan data pendaftar, kriteria, dan periode aktif.
- **Manajemen Kriteria & Sub-kriteria**: Mengelola kriteria penilaian (Benefit/Cost) beserta sub-kriterianya.
- **Perhitungan AHP**: Melakukan perhitungan bobot kriteria menggunakan metode AHP.
- **Perhitungan MOORA**: Memproses nilai pendaftar untuk menghasilkan ranking kandidat penerima beasiswa.
- **Verifikasi Kandidat**: Memverifikasi berkas pendaftar dan memberikan penilaian awal.
- **Laporan**: Mengekspor hasil seleksi beasiswa dalam format PDF maupun Excel.

### 2. Kepala Sekolah (Kepsek)

- **Dashboard**: Memantau progress seleksi beasiswa.
- **Persetujuan Usulan**: Menyetujui (Approve) atau menolak (Reject) usulan kandidat penerima beasiswa yang diajukan oleh panitia.

### 3. Orang Tua / Wali (Ortu / Pendaftar)

- **Dashboard**: Melihat status pendaftaran dan pengumuman.
- **Pendaftaran**: Mengisi formulir pendaftaran beasiswa dan mengunggah berkas persyaratan.

## 🛠 Teknologi yang Digunakan

- **Framework**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL / SQLite
- **Styling**: Tailwind CSS / Bootstrap
- **PDF Export**: barryvdh/laravel-dompdf
- **Excel Export**: maatwebsite/excel

## ⚙️ Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lokal:

1. **Clone repository ini**

    ```bash
    git clone <url-repo-anda>
    cd seleksi_beasiswa
    ```

2. **Install dependensi Composer**

    ```bash
    composer install
    ```

3. **Install dependensi NPM** (Jika ada)

    ```bash
    npm install
    npm run build
    ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`, lalu atur konfigurasi database (bisa menggunakan sqlite atau mysql).

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Jalankan Migrasi & Seeder Database**

    ```bash
    php artisan migrate --seed
    ```

6. **Jalankan Local Server**
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses di `http://localhost:8000`.

## 🔐 Akun Default (Testing)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat menggunakan akun berikut untuk login ke dalam sistem:

| Role                 | Email               | Password   |
| -------------------- | ------------------- | ---------- |
| **Admin / Panitia**  | `admin@admin.com`   | `password` |
| **Kepala Sekolah**   | `kepsek@kepsek.com` | `password` |
| **Orang Tua / Wali** | `ortu@ortu.com`     | `password` |

## 📊 Kriteria Penilaian Default

Secara default (bawaan seeder), sistem menggunakan kriteria penilaian berikut:

1. **Nilai Rata-rata Rapor** (Benefit) - Bobot 35%
2. **Penghasilan Orang Tua** (Cost) - Bobot 25%
3. **Jumlah Tanggungan Orang Tua** (Benefit) - Bobot 15%
4. **Prestasi Akademik / Non-Akademik** (Benefit) - Bobot 15%
5. **Surat Keterangan Tidak Mampu (SKTM)** (Benefit) - Bobot 10%

## 📝 Dokumentasi Syarat & Ketentuan Pendaftaran (Orang Tua / Wali)

Berikut adalah dokumentasi terkait pengisian form dan berkas yang perlu disiapkan saat pendaftaran beasiswa, beserta aturan validasinya:

| Kategori      | Nama Kolom / Berkas                     | Aturan Validasi & Ketentuan                                                                                                                  |
| ------------- | --------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| **Identitas** | **NIK (Nomor Induk Kependudukan)**      | Wajib 16 digit angka. Terkunci (_read-only_) permanen dan tidak dapat diubah lagi setelah disimpan.                                          |
| **Identitas** | **Nama Lengkap Siswa/Ortu**             | Hanya diperbolehkan memasukkan huruf dan spasi (Validasi _Regex_).                                                                           |
| **Dokumen**   | **Surat Keterangan Tidak Mampu (SKTM)** | Penilaian menggunakan sub-kriteria: **Memiliki** (Poin Tinggi) atau **Tidak Memiliki** (Poin Rendah). Format dokumen: PDF/JPG/PNG (Max 5MB). |
| **Dokumen**   | **Transkrip Nilai**                     | Dokumen hasil studi untuk mengevaluasi nilai akademik (menggantikan rapor semester terakhir). Format: PDF/JPG/PNG (Max 5MB).                 |
| **Dokumen**   | **Slip Gaji / Penghasilan Ortu**        | Bukti penghasilan wali murid sebagai dasar perhitungan kriteria _Cost_. Format dokumen: PDF/JPG/PNG (Max 5MB).                               |

> **Catatan Pembaruan:** Kolom _Kelas / Konsentrasi Keahlian_ dan _Kartu Keluarga (KK)_ telah dihapus dari sistem dan digantikan sesuai dengan tabel di atas agar proses seleksi lebih relevan dan difokuskan pada ekonomi & prestasi.

## 🗄️ Struktur Tabel Database (Skema)

Berikut adalah deskripsi struktur tabel utama yang digunakan untuk menyimpan data pendaftaran dan pengguna:

### 1. Tabel `users` (Data Pengguna)
| Nama Kolom | Tipe Data | Panjang (Maksimal) | Keterangan / Validasi |
| --- | --- | --- | --- |
| `id` | `bigint(20)` | - | *Primary Key*, Auto Increment |
| `name` | `varchar` | 255 karakter | Nama lengkap pengguna (huruf saja) |
| `email` | `varchar` | 255 karakter | Alamat email (Unique) |
| `role` | `enum` | - | Hak akses: `'admin'`, `'kepsek'`, `'ortu'` |
| `password` | `varchar` | 255 karakter | Kata sandi (Terenkripsi, minimal 8 karakter) |

### 2. Tabel `applicants` (Data Pendaftar Beasiswa)
| Nama Kolom | Tipe Data | Panjang (Maksimal) | Keterangan / Validasi |
| --- | --- | --- | --- |
| `id` | `bigint(20)` | - | *Primary Key*, Auto Increment |
| `user_id` | `bigint(20)` | - | *Foreign Key* ke tabel `users` |
| `period_id` | `bigint(20)` | - | *Foreign Key* ke tabel `periods` (Periode Seleksi) |
| `nik` | `varchar` | 16 karakter | Nomor Induk Kependudukan (Wajib 16 digit, *Unique*) |
| `nama_lengkap` | `varchar` | 255 karakter | Nama lengkap siswa |
| `status_berkas` | `enum` | - | Status pendaftaran: `'draft'`, `'submitted'`, `'verifikasi'`, dll |

### 3. Tabel `applicant_documents` (Berkas Persyaratan)
| Nama Kolom | Tipe Data | Panjang (Maksimal) | Keterangan / Validasi |
| --- | --- | --- | --- |
| `id` | `bigint(20)` | - | *Primary Key*, Auto Increment |
| `applicant_id`| `bigint(20)` | - | *Foreign Key* ke tabel `applicants` |
| `jenis_dokumen`| `varchar` | 255 karakter | (SKTM / Transkrip Nilai / Slip Gaji) |
| `path_file` | `varchar` | 255 karakter | Lokasi direktori tempat file disimpan |
| `status_verifikasi`| `boolean` | 1 digit (0/1)| Menandakan dokumen disetujui atau ditolak |
