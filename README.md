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

| Nama Kolom | Tipe Data    | Panjang (Maksimal) | Keterangan / Validasi                        |
| ---------- | ------------ | ------------------ | -------------------------------------------- |
| `id`       | `bigint(20)` | -                  | _Primary Key_, Auto Increment                |
| `name`     | `varchar`    | 255 karakter       | Nama lengkap pengguna (huruf saja)           |
| `email`    | `varchar`    | 255 karakter       | Alamat email (Unique)                        |
| `role`     | `enum`       | -                  | Hak akses: `'admin'`, `'kepsek'`, `'ortu'`   |
| `password` | `varchar`    | 255 karakter       | Kata sandi (Terenkripsi, minimal 8 karakter) |

### 2. Tabel `applicants` (Data Pendaftar Beasiswa)

| Nama Kolom      | Tipe Data    | Panjang (Maksimal) | Keterangan / Validasi                                             |
| --------------- | ------------ | ------------------ | ----------------------------------------------------------------- |
| `id`            | `bigint(20)` | -                  | _Primary Key_, Auto Increment                                     |
| `user_id`       | `bigint(20)` | -                  | _Foreign Key_ ke tabel `users`                                    |
| `period_id`     | `bigint(20)` | -                  | _Foreign Key_ ke tabel `periods` (Periode Seleksi)                |
| `nik`           | `varchar`    | 16 karakter        | Nomor Induk Kependudukan (Wajib 16 digit, _Unique_)               |
| `nama_lengkap`  | `varchar`    | 255 karakter       | Nama lengkap siswa                                                |
| `status_berkas` | `enum`       | -                  | Status pendaftaran: `'draft'`, `'submitted'`, `'verifikasi'`, dll |

### 3. Tabel `applicant_documents` (Berkas Persyaratan)

| Nama Kolom          | Tipe Data    | Panjang (Maksimal) | Keterangan / Validasi                     |
| ------------------- | ------------ | ------------------ | ----------------------------------------- |
| `id`                | `bigint(20)` | -                  | _Primary Key_, Auto Increment             |
| `applicant_id`      | `bigint(20)` | -                  | _Foreign Key_ ke tabel `applicants`       |
| `jenis_dokumen`     | `varchar`    | 255 karakter       | (SKTM / Transkrip Nilai / Slip Gaji)      |
| `path_file`         | `varchar`    | 255 karakter       | Lokasi direktori tempat file disimpan     |
| `status_verifikasi` | `boolean`    | 1 digit (0/1)      | Menandakan dokumen disetujui atau ditolak |

## Lampiran Kode Sistem Seleksi Beasiswa

Berikut adalah bagian-bagian kode (source code) yang paling penting dalam sistem pendukung keputusan seleksi beasiswa ini. Kode-kode ini mencakup implementasi algoritma Analytical Hierarchy Process (AHP) untuk pembobotan kriteria dan metode Multi-Objective Optimization on the Basis of Ratio Analysis (MOORA) untuk perangkingan kandidat.

### Lampiran 1: Implementasi Algoritma AHP (Analytical Hierarchy Process)

Kode berikut merupakan bagian dari `AHPService.php` yang menangani proses perhitungan matriks perbandingan berpasangan, normalisasi, pencarian nilai _Eigen Vector_ (bobot kriteria), dan pengujian rasio konsistensi (Consistency Ratio / CR).

```php
<?php

namespace App\Services;

class AHPService
{
    /**
     * Tabel Random Index (RI) sesuai standar Saaty.
     */
    protected array $riTable = [
        1 => 0.00, 2 => 0.00, 3 => 0.58, 4 => 0.90, 5 => 1.12,
        6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49,
        11 => 1.51, 12 => 1.48, 13 => 1.56, 14 => 1.57, 15 => 1.59,
    ];

    /**
     * Melakukan kalkulasi AHP.
     *
     * @param array $matrix Matriks n x n, key adalah ID kriteria.
     * @return array
     */
    public function calculate(array $matrix): array
    {
        $n = count($matrix);
        if ($n === 0) return [];

        // 1. Menghitung total tiap kolom
        $colTotals = [];
        $criteriaIds = array_keys($matrix);
        foreach ($criteriaIds as $j) {
            $colTotals[$j] = 0;
            foreach ($criteriaIds as $i) {
                $colTotals[$j] += $matrix[$i][$j];
            }
        }

        // 2. Normalisasi matriks dan hitung Eigen Vector (Bobot)
        $normalizedMatrix = [];
        $eigenVectors = [];
        foreach ($criteriaIds as $i) {
            $rowSum = 0;
            foreach ($criteriaIds as $j) {
                $val = $colTotals[$j] > 0 ? $matrix[$i][$j] / $colTotals[$j] : 0;
                $normalizedMatrix[$i][$j] = $val;
                $rowSum += $val;
            }
            $eigenVectors[$i] = $rowSum / $n;
        }

        // 3. Menghitung Lambda Max
        $lambdaMax = 0;
        foreach ($criteriaIds as $i) {
            $lambdaMax += $colTotals[$i] * $eigenVectors[$i];
        }

        // 4. Menghitung Consistency Index (CI)
        $ci = ($n > 1) ? ($lambdaMax - $n) / ($n - 1) : 0;

        // 5. Menghitung Consistency Ratio (CR)
        $ri = $this->riTable[$n] ?? 1.59;
        $cr = ($ri > 0) ? $ci / $ri : 0;

        return [
            'matrix'           => $matrix,
            'normalizedMatrix' => $normalizedMatrix,
            'eigenVectors'     => $eigenVectors,
            'lambdaMax'        => $lambdaMax,
            'ci'               => $ci,
            'ri'               => $ri,
            'cr'               => $cr,
            'isConsistent'     => $cr <= 0.1,
        ];
    }
}
```

### Lampiran 2: Implementasi Algoritma MOORA

Kode berikut merupakan bagian dari `MOORAService.php` yang mengolah nilai masing-masing kandidat berdasarkan kriteria yang telah diberi bobot oleh AHP. Proses ini mencakup normalisasi matriks keputusan, optimasi (_Benefit_ dan _Cost_), hingga menghasilkan peringkat (_ranking_).

```php
<?php

namespace App\Services;

class MOORAService
{
    /**
     * Melakukan kalkulasi MOORA.
     *
     * @param array $candidates Array data nilai kandidat.
     * @param array $criteria Bobot & tipe kriteria (benefit/cost).
     * @return array
     */
    public function calculate(array $candidates, array $criteria): array
    {
        if (empty($candidates) || empty($criteria)) return [];

        // 1. Menghitung pembagi normalisasi (akar jumlah kuadrat)
        $divisors = [];
        foreach ($criteria as $cId => $cData) {
            $sumSquares = 0;
            foreach ($candidates as $appId => $scores) {
                $val = $scores[$cId] ?? 0;
                $sumSquares += pow($val, 2);
            }
            $divisors[$cId] = sqrt($sumSquares);
        }

        // 2 & 3. Normalisasi, Normalisasi Terbobot, dan Optimasi (Yi)
        $results = [];
        foreach ($candidates as $appId => $scores) {
            $sumBenefit = 0;
            $sumCost = 0;

            foreach ($criteria as $cId => $cData) {
                $val = $scores[$cId] ?? 0;

                // Normalisasi & Terbobot
                $normVal = $divisors[$cId] > 0 ? $val / $divisors[$cId] : 0;
                $weightedVal = $normVal * $cData['weight'];

                // Pengelompokan Benefit atau Cost
                if ($cData['type'] === 'benefit') {
                    $sumBenefit += $weightedVal;
                } else {
                    $sumCost += $weightedVal;
                }
            }

            // Nilai optimasi akhir (Yi)
            $yi = $sumBenefit - $sumCost;

            $results[$appId] = [
                'applicant_id' => $appId,
                'sum_benefit'  => $sumBenefit,
                'sum_cost'     => $sumCost,
                'yi'           => $yi,
            ];
        }

        // 4. Perangkingan (Sorting descending by Yi)
        usort($results, function ($a, $b) {
            return $b['yi'] <=> $a['yi'];
        });

        // Pemberian nilai rank
        $rank = 1;
        foreach ($results as $k => $v) {
            $results[$k]['rank'] = $rank++;
        }

        return $results;
    }
}
```

### Lampiran 3: Controller Eksekusi MOORA (Integrasi Data)

Kode berikut adalah `MOORAController.php` yang berfungsi untuk mengambil data dari _database_, memformat data ke bentuk matriks yang diperlukan, memanggil _service_ MOORA, lalu menyimpan hasil perangkingan kembali ke _database_.

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Criteria;
use App\Models\MooraResult;
use App\Services\MOORAService;
use Illuminate\Http\Request;

class MOORAController extends Controller
{
    protected MOORAService $mooraService;

    public function __construct(MOORAService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    public function calculate(Request $request)
    {
        $period = Period::where('status', 1)->first();
        $criterias = Criteria::all()->keyBy('id');

        // Persiapan data bobot dan tipe kriteria
        $criteriaData = [];
        foreach ($criterias as $c) {
            $criteriaData[$c->id] = [
                'weight' => floatval($c->bobot),
                'type' => $c->tipe
            ];
        }

        // Persiapan matriks nilai kandidat
        $applicants = Applicant::with('scores')->where('period_id', $period->id)->get();
        $candidatesData = [];
        foreach ($applicants as $app) {
            if ($app->scores->count() > 0) {
                foreach ($app->scores as $s) {
                    $candidatesData[$app->id][$s->criteria_id] = $s->nilai_kriteria;
                }
            }
        }

        // Kalkulasi menggunakan Service
        $results = $this->mooraService->calculate($candidatesData, $criteriaData);

        // Menyimpan hasil perangkingan ke database
        MooraResult::where('period_id', $period->id)->delete();
        foreach ($results as $res) {
            MooraResult::create([
                'period_id' => $period->id,
                'applicant_id' => $res['applicant_id'],
                'nilai_optimasi_yi' => $res['yi'],
                'rank' => $res['rank']
            ]);
        }

        return redirect()->back()->with('success', 'Kalkulasi MOORA berhasil dijalankan!');
    }
}
```
