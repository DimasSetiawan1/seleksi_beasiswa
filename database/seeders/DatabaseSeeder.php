<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Period;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Applicant;
use App\Models\ApplicantScore;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();
        Period::query()->delete();
        Criteria::query()->delete();
        SubCriteria::query()->delete();
        Applicant::query()->delete();

        // 1. Users matching roles: admin (Panitia Beasiswa), kepsek (Kepala Sekolah), ortu (Orang Tua / Wali)
        $admin = User::factory()->create([
            'name' => 'Panitia Beasiswa Kesiswaan',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $kepsek = User::factory()->create([
            'name' => 'Hj. Dra. Endang S. M.Pd',
            'email' => 'kepsek@kepsek.com',
            'password' => bcrypt('password'),
            'role' => 'kepsek'
        ]);

        $ortu = User::factory()->create([
            'name' => 'Bapak Rahmat (Orang Tua)',
            'email' => 'ortu@ortu.com',
            'password' => bcrypt('password'),
            'role' => 'ortu'
        ]);

        // 2. Active Period
        $period = Period::create([
            'nama_periode' => 'Seleksi Beasiswa Prestasi & Ekonomi SMK Tinta Emas 2026',
            'tahun_ajaran' => '2026/2027',
            'tgl_buka' => '2026-08-01',
            'tgl_tutup' => '2026-08-31',
            'status' => 1
        ]);

        // 3. System Default Criteria & SubCriteria
        $c1 = Criteria::create([
            'nama_kriteria' => 'Nilai Rata-rata Rapor',
            'tipe' => 'benefit',
            'deskripsi' => 'Nilai akumulasi rapor semester terakhir',
            'skala_min' => 1,
            'skala_max' => 5,
            'bobot' => 0.35
        ]);

        SubCriteria::create(['criteria_id' => $c1->id, 'nama_subkriteria' => 'Nilai Rapor < 70', 'nilai' => 1]);
        SubCriteria::create(['criteria_id' => $c1->id, 'nama_subkriteria' => 'Nilai Rapor 70 - 75', 'nilai' => 2]);
        SubCriteria::create(['criteria_id' => $c1->id, 'nama_subkriteria' => 'Nilai Rapor 76 - 80', 'nilai' => 3]);
        SubCriteria::create(['criteria_id' => $c1->id, 'nama_subkriteria' => 'Nilai Rapor 81 - 88', 'nilai' => 4]);
        SubCriteria::create(['criteria_id' => $c1->id, 'nama_subkriteria' => 'Nilai Rapor 89 - 100', 'nilai' => 5]);

        $c2 = Criteria::create([
            'nama_kriteria' => 'Penghasilan Orang Tua',
            'tipe' => 'cost',
            'deskripsi' => 'Total penghasilan gabungan orang tua per bulan',
            'skala_min' => 1,
            'skala_max' => 5,
            'bobot' => 0.25
        ]);

        SubCriteria::create(['criteria_id' => $c2->id, 'nama_subkriteria' => '> Rp 5.000.000 / bulan', 'nilai' => 1]);
        SubCriteria::create(['criteria_id' => $c2->id, 'nama_subkriteria' => 'Rp 3.500.000 - Rp 5.000.000 / bulan', 'nilai' => 2]);
        SubCriteria::create(['criteria_id' => $c2->id, 'nama_subkriteria' => 'Rp 2.000.000 - Rp 3.500.000 / bulan', 'nilai' => 3]);
        SubCriteria::create(['criteria_id' => $c2->id, 'nama_subkriteria' => 'Rp 1.000.000 - Rp 2.000.000 / bulan', 'nilai' => 4]);
        SubCriteria::create(['criteria_id' => $c2->id, 'nama_subkriteria' => '< Rp 1.000.000 / bulan', 'nilai' => 5]);

        $c3 = Criteria::create([
            'nama_kriteria' => 'Jumlah Tanggungan Orang Tua',
            'tipe' => 'benefit',
            'deskripsi' => 'Jumlah anak/tanggungan yang masih sekolah/kuliah',
            'skala_min' => 1,
            'skala_max' => 5,
            'bobot' => 0.15
        ]);

        SubCriteria::create(['criteria_id' => $c3->id, 'nama_subkriteria' => '1 Anak Tanggungan', 'nilai' => 1]);
        SubCriteria::create(['criteria_id' => $c3->id, 'nama_subkriteria' => '2 Anak Tanggungan', 'nilai' => 2]);
        SubCriteria::create(['criteria_id' => $c3->id, 'nama_subkriteria' => '3 Anak Tanggungan', 'nilai' => 3]);
        SubCriteria::create(['criteria_id' => $c3->id, 'nama_subkriteria' => '4 Anak Tanggungan', 'nilai' => 4]);
        SubCriteria::create(['criteria_id' => $c3->id, 'nama_subkriteria' => '>= 5 Anak Tanggungan', 'nilai' => 5]);

        $c4 = Criteria::create([
            'nama_kriteria' => 'Prestasi Akademik / Non-Akademik',
            'tipe' => 'benefit',
            'deskripsi' => 'Tingkat kejuaraan atau sertifikat keahlian yang dimiliki',
            'skala_min' => 1,
            'skala_max' => 5,
            'bobot' => 0.15
        ]);

        SubCriteria::create(['criteria_id' => $c4->id, 'nama_subkriteria' => 'Tidak Ada Prestasi', 'nilai' => 1]);
        SubCriteria::create(['criteria_id' => $c4->id, 'nama_subkriteria' => 'Juara Tingkat Sekolah', 'nilai' => 2]);
        SubCriteria::create(['criteria_id' => $c4->id, 'nama_subkriteria' => 'Juara Tingkat Kota/Kabupaten', 'nilai' => 3]);
        SubCriteria::create(['criteria_id' => $c4->id, 'nama_subkriteria' => 'Juara Tingkat Provinsi', 'nilai' => 4]);
        SubCriteria::create(['criteria_id' => $c4->id, 'nama_subkriteria' => 'Juara Tingkat Nasional/Internasional', 'nilai' => 5]);

        $c5 = Criteria::create([
            'nama_kriteria' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'tipe' => 'benefit',
            'deskripsi' => 'Kepemilikan SKTM yang diterbitkan oleh pejabat berwenang',
            'skala_min' => 1,
            'skala_max' => 5,
            'bobot' => 0.10
        ]);

        SubCriteria::create(['criteria_id' => $c5->id, 'nama_subkriteria' => 'Tidak Memiliki SKTM', 'nilai' => 1]);
        SubCriteria::create(['criteria_id' => $c5->id, 'nama_subkriteria' => 'Memiliki SKTM', 'nilai' => 5]);

        // 4. Sample Applicants Data
        $applicant1 = Applicant::create([
            'user_id' => $ortu->id,
            'period_id' => $period->id,
            'nik' => '3275012304050001',
            'nama_lengkap' => 'Ahmad Fauzi',
            'status_berkas' => 'verifikasi'
        ]);

        ApplicantScore::create(['applicant_id' => $applicant1->id, 'criteria_id' => $c1->id, 'nilai_kriteria' => 5]);
        ApplicantScore::create(['applicant_id' => $applicant1->id, 'criteria_id' => $c2->id, 'nilai_kriteria' => 4]);
        ApplicantScore::create(['applicant_id' => $applicant1->id, 'criteria_id' => $c3->id, 'nilai_kriteria' => 3]);
        ApplicantScore::create(['applicant_id' => $applicant1->id, 'criteria_id' => $c4->id, 'nilai_kriteria' => 4]);
        ApplicantScore::create(['applicant_id' => $applicant1->id, 'criteria_id' => $c5->id, 'nilai_kriteria' => 5]);

        // Sample Candidate 2
        $ortu2 = User::factory()->create([
            'name' => 'Ibu Halimah (Orang Tua)',
            'email' => 'ortu2@ortu.com',
            'password' => bcrypt('password'),
            'role' => 'ortu'
        ]);
        $applicant2 = Applicant::create([
            'user_id' => $ortu2->id,
            'period_id' => $period->id,
            'nik' => '3275012304050002',
            'nama_lengkap' => 'Siti Nurhaliza',
            'status_berkas' => 'verifikasi'
        ]);

        ApplicantScore::create(['applicant_id' => $applicant2->id, 'criteria_id' => $c1->id, 'nilai_kriteria' => 4]);
        ApplicantScore::create(['applicant_id' => $applicant2->id, 'criteria_id' => $c2->id, 'nilai_kriteria' => 5]);
        ApplicantScore::create(['applicant_id' => $applicant2->id, 'criteria_id' => $c3->id, 'nilai_kriteria' => 4]);
        ApplicantScore::create(['applicant_id' => $applicant2->id, 'criteria_id' => $c4->id, 'nilai_kriteria' => 2]);
        ApplicantScore::create(['applicant_id' => $applicant2->id, 'criteria_id' => $c5->id, 'nilai_kriteria' => 4]);
    }
}
