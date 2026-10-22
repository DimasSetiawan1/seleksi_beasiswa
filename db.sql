-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for seleksi_beasiswa
CREATE DATABASE IF NOT EXISTS `seleksi_beasiswa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `seleksi_beasiswa`;

-- Dumping structure for table seleksi_beasiswa.ahp_matrices
CREATE TABLE IF NOT EXISTS `ahp_matrices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `period_id` bigint unsigned NOT NULL,
  `criteria_i_id` bigint unsigned NOT NULL,
  `criteria_j_id` bigint unsigned NOT NULL,
  `nilai_perbandingan` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ahp_matrices_period_id_foreign` (`period_id`),
  KEY `ahp_matrices_criteria_i_id_foreign` (`criteria_i_id`),
  KEY `ahp_matrices_criteria_j_id_foreign` (`criteria_j_id`),
  CONSTRAINT `ahp_matrices_criteria_i_id_foreign` FOREIGN KEY (`criteria_i_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ahp_matrices_criteria_j_id_foreign` FOREIGN KEY (`criteria_j_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ahp_matrices_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.ahp_matrices: ~0 rows (approximately)
DELETE FROM `ahp_matrices`;

-- Dumping structure for table seleksi_beasiswa.ahp_results
CREATE TABLE IF NOT EXISTS `ahp_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `period_id` bigint unsigned NOT NULL,
  `criteria_id` bigint unsigned NOT NULL,
  `bobot_eigen` float NOT NULL,
  `cr` float DEFAULT NULL,
  `is_consistent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ahp_results_period_id_foreign` (`period_id`),
  KEY `ahp_results_criteria_id_foreign` (`criteria_id`),
  CONSTRAINT `ahp_results_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ahp_results_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.ahp_results: ~0 rows (approximately)
DELETE FROM `ahp_results`;

-- Dumping structure for table seleksi_beasiswa.applicants
CREATE TABLE IF NOT EXISTS `applicants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `period_id` bigint unsigned NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `status_berkas` enum('draft','submitted','verifikasi','diterima','ditolak') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicants_nik_unique` (`nik`),
  KEY `applicants_user_id_foreign` (`user_id`),
  KEY `applicants_period_id_foreign` (`period_id`),
  CONSTRAINT `applicants_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.applicants: ~2 rows (approximately)
DELETE FROM `applicants`;
INSERT INTO `applicants` (`id`, `user_id`, `period_id`, `nik`, `nama_lengkap`, `status_berkas`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, '3275012304050001', 'Ahmad Fauzi', 'draft', '2026-08-05 09:07:41', '2026-08-06 14:03:31'),
	(2, 4, 1, '3275012304050002', 'Siti Nurhaliza', 'verifikasi', '2026-08-05 09:07:41', '2026-08-05 09:07:41');

-- Dumping structure for table seleksi_beasiswa.applicant_documents
CREATE TABLE IF NOT EXISTS `applicant_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint unsigned NOT NULL,
  `jenis_dokumen` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `status_verifikasi` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_documents_applicant_id_foreign` (`applicant_id`),
  CONSTRAINT `applicant_documents_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.applicant_documents: ~2 rows (approximately)
DELETE FROM `applicant_documents`;
INSERT INTO `applicant_documents` (`id`, `applicant_id`, `jenis_dokumen`, `path_file`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
	(1, 1, 'sktm', 'documents/CYOV1kkhqjjUTRkR4JRm1fcPWwvRA28twOMQtstN.png', 0, '2026-08-05 09:13:37', '2026-08-05 09:13:37'),
	(2, 1, 'transkip_nilai', 'documents/d2Zv7J2l8XGlAlIX6TCtSvPZKqc6TyzpMBpiQGyu.png', 0, '2026-08-05 09:13:43', '2026-08-05 09:13:43'),
	(3, 1, 'slip_gaji', 'documents/UND001o5FXKhnglASV9HDNPLkVM818GhuTpL5Mnh.png', 0, '2026-08-05 09:13:49', '2026-08-05 09:13:49');

-- Dumping structure for table seleksi_beasiswa.applicant_scores
CREATE TABLE IF NOT EXISTS `applicant_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` bigint unsigned NOT NULL,
  `criteria_id` bigint unsigned NOT NULL,
  `nilai_kriteria` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_scores_applicant_id_foreign` (`applicant_id`),
  KEY `applicant_scores_criteria_id_foreign` (`criteria_id`),
  CONSTRAINT `applicant_scores_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applicant_scores_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.applicant_scores: ~10 rows (approximately)
DELETE FROM `applicant_scores`;
INSERT INTO `applicant_scores` (`id`, `applicant_id`, `criteria_id`, `nilai_kriteria`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(2, 1, 2, 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(3, 1, 3, 3, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(4, 1, 4, 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(5, 1, 5, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(6, 2, 1, 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(7, 2, 2, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(8, 2, 3, 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(9, 2, 4, 2, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(10, 2, 5, 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41');

-- Dumping structure for table seleksi_beasiswa.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.cache: ~2 rows (approximately)
DELETE FROM `cache`;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('asd@gmail.com|127.0.0.1', 'i:2;', 1785921244),
	('asd@gmail.com|127.0.0.1:timer', 'i:1785921244;', 1785921244);

-- Dumping structure for table seleksi_beasiswa.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table seleksi_beasiswa.criterias
CREATE TABLE IF NOT EXISTS `criterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) NOT NULL,
  `tipe` enum('benefit','cost') NOT NULL,
  `deskripsi` text,
  `bobot` float DEFAULT NULL,
  `skala_min` int NOT NULL DEFAULT '1',
  `skala_max` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.criterias: ~5 rows (approximately)
DELETE FROM `criterias`;
INSERT INTO `criterias` (`id`, `nama_kriteria`, `tipe`, `deskripsi`, `bobot`, `skala_min`, `skala_max`, `created_at`, `updated_at`) VALUES
	(1, 'Nilai Rata-rata Rapor', 'benefit', 'Nilai akumulasi rapor semester terakhir', 0.35, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(2, 'Penghasilan Orang Tua', 'cost', 'Total penghasilan gabungan orang tua per bulan', 0.25, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(3, 'Jumlah Tanggungan Orang Tua', 'benefit', 'Jumlah anak/tanggungan yang masih sekolah/kuliah', 0.15, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(4, 'Prestasi Akademik / Non-Akademik', 'benefit', 'Tingkat kejuaraan atau sertifikat keahlian yang dimiliki', 0.15, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(5, 'Surat Keterangan Tidak Mampu (SKTM)', 'benefit', 'Kepemilikan SKTM yang diterbitkan oleh pejabat berwenang', 0.1, 1, 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41');

-- Dumping structure for table seleksi_beasiswa.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table seleksi_beasiswa.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table seleksi_beasiswa.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table seleksi_beasiswa.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_08_03_020252_create_criterias_table', 1),
	(5, '2026_08_03_020253_create_periods_table', 1),
	(6, '2026_08_03_020254_create_ahp_matrices_table', 1),
	(7, '2026_08_03_020255_create_ahp_results_table', 1),
	(8, '2026_08_03_020300_create_applicants_table', 1),
	(9, '2026_08_03_020301_create_applicant_documents_table', 1),
	(10, '2026_08_03_020302_create_applicant_scores_table', 1),
	(11, '2026_08_03_020303_create_moora_results_table', 1),
	(12, '2026_08_03_020304_create_proposals_table', 1),
	(13, '2026_08_03_020305_create_sk_documents_table', 1),
	(14, '2026_08_03_074323_create_sub_criterias_table', 1),
	(15, '2026_08_05_152340_remove_kelas_from_applicants_table', 1);

-- Dumping structure for table seleksi_beasiswa.moora_results
CREATE TABLE IF NOT EXISTS `moora_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `period_id` bigint unsigned NOT NULL,
  `applicant_id` bigint unsigned NOT NULL,
  `nilai_optimasi_yi` float NOT NULL,
  `rank` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `moora_results_period_id_foreign` (`period_id`),
  KEY `moora_results_applicant_id_foreign` (`applicant_id`),
  CONSTRAINT `moora_results_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `moora_results_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.moora_results: ~0 rows (approximately)
DELETE FROM `moora_results`;
INSERT INTO `moora_results` (`id`, `period_id`, `applicant_id`, `nilai_optimasi_yi`, `rank`, `created_at`, `updated_at`) VALUES
	(2, 1, 2, 0.5, 1, '2026-08-20 08:24:54', '2026-08-20 08:24:54');

-- Dumping structure for table seleksi_beasiswa.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table seleksi_beasiswa.periods
CREATE TABLE IF NOT EXISTS `periods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `tgl_buka` date NOT NULL,
  `tgl_tutup` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.periods: ~0 rows (approximately)
DELETE FROM `periods`;
INSERT INTO `periods` (`id`, `nama_periode`, `tahun_ajaran`, `tgl_buka`, `tgl_tutup`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Seleksi Beasiswa Prestasi & Ekonomi SMK Tinta Emas 2026', '2026/2027', '2026-08-01', '2026-08-31', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41');

-- Dumping structure for table seleksi_beasiswa.proposals
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `period_id` bigint unsigned NOT NULL,
  `status` enum('draft','submitted','approved','rejected') NOT NULL DEFAULT 'draft',
  `catatan_kepsek` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposals_period_id_foreign` (`period_id`),
  CONSTRAINT `proposals_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.proposals: ~0 rows (approximately)
DELETE FROM `proposals`;
INSERT INTO `proposals` (`id`, `period_id`, `status`, `catatan_kepsek`, `created_at`, `updated_at`) VALUES
	(1, 1, 'draft', NULL, '2026-08-20 08:22:35', '2026-08-20 08:24:54');

-- Dumping structure for table seleksi_beasiswa.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.sessions: ~4 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('D6BgiBAjFTNrXtYevoPf92d8iQah2KAMwNT6Wmlc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDdKQUFWRzZrVkxYUGwyUDVBWGxYQzVBUFFBOGZOdGw3ZTVCNHNWbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMi9hZG1pbi9haHAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1787217437),
	('m9k6WCgU2hONhCO3kNmrfHcfy4fw4uoeBZgDctX4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUpLY1ZJUWswMFZ3S2haRTBubjNhR3ExNENWdEg0VVRtekNIemlsdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1787578117),
	('QPJcnQUhuQoRxDTtfQvZo5H2AggWR62qJT1o5Xdr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0llNzY1Q2FMTTZwZ0M0MXd1TUFLcVZ1ODBPZ2FmRFFYM3A4UHBkdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1787329032),
	('urqhkJlyNTyUxW6YptS1srf8uM3UDnkJZPwV2zUZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUNOZVZKdjdmY29zazUwRk1GU01GNzVRUXJBVFhyd3Y1ZjFwWFNHRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1787799960);

-- Dumping structure for table seleksi_beasiswa.sk_documents
CREATE TABLE IF NOT EXISTS `sk_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `period_id` bigint unsigned NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `ditandatangani_oleh` bigint unsigned DEFAULT NULL,
  `tgl_tanda_tangan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sk_documents_period_id_foreign` (`period_id`),
  KEY `sk_documents_ditandatangani_oleh_foreign` (`ditandatangani_oleh`),
  CONSTRAINT `sk_documents_ditandatangani_oleh_foreign` FOREIGN KEY (`ditandatangani_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sk_documents_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.sk_documents: ~0 rows (approximately)
DELETE FROM `sk_documents`;

-- Dumping structure for table seleksi_beasiswa.sub_criterias
CREATE TABLE IF NOT EXISTS `sub_criterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `criteria_id` bigint unsigned NOT NULL,
  `nama_subkriteria` varchar(255) NOT NULL,
  `nilai` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_criterias_criteria_id_foreign` (`criteria_id`),
  CONSTRAINT `sub_criterias_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.sub_criterias: ~22 rows (approximately)
DELETE FROM `sub_criterias`;
INSERT INTO `sub_criterias` (`id`, `criteria_id`, `nama_subkriteria`, `nilai`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Nilai Rapor < 70', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(2, 1, 'Nilai Rapor 70 - 75', 2, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(3, 1, 'Nilai Rapor 76 - 80', 3, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(4, 1, 'Nilai Rapor 81 - 88', 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(5, 1, 'Nilai Rapor 89 - 100', 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(6, 2, '> Rp 5.000.000 / bulan', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(7, 2, 'Rp 3.500.000 - Rp 5.000.000 / bulan', 2, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(8, 2, 'Rp 2.000.000 - Rp 3.500.000 / bulan', 3, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(9, 2, 'Rp 1.000.000 - Rp 2.000.000 / bulan', 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(10, 2, '< Rp 1.000.000 / bulan', 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(11, 3, '1 Anak Tanggungan', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(12, 3, '2 Anak Tanggungan', 2, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(13, 3, '3 Anak Tanggungan', 3, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(14, 3, '4 Anak Tanggungan', 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(15, 3, '>= 5 Anak Tanggungan', 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(16, 4, 'Tidak Ada Prestasi', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(17, 4, 'Juara Tingkat Sekolah', 2, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(18, 4, 'Juara Tingkat Kota/Kabupaten', 3, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(19, 4, 'Juara Tingkat Provinsi', 4, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(20, 4, 'Juara Tingkat Nasional/Internasional', 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(21, 5, 'Tidak Memiliki SKTM', 1, '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(22, 5, 'Memiliki SKTM', 5, '2026-08-05 09:07:41', '2026-08-05 09:07:41');

-- Dumping structure for table seleksi_beasiswa.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','kepsek','ortu') NOT NULL DEFAULT 'ortu',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seleksi_beasiswa.users: ~4 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Panitia Beasiswa Kesiswaan', 'admin@admin.com', 'admin', '2026-08-05 09:07:40', '$2y$12$owivyIIQ/gnlCtLe3ZaZdeydqGOb5UmxJpA9TmmJZvN04Mp8qKXXO', 'IKGJmOIvwZyw2BR6KKAex9gRdVLqq7h9afTzURqWicK4jHDyZ6klqDhToGbR', '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(2, 'Supriyantin', 'kepsek@kepsek.com', 'kepsek', '2026-08-05 09:07:41', '$2y$12$6LrYqI5pHhy534Kgc03UBeusD9X3RCYcXcvsSpmJlRLGWadQiIgvu', '6FFtbJUKx6PS6eSH3tCWMKiATEP1CYLpnpeUg9SvV7cW7XzZMbN85s7PfKlr', '2026-08-05 09:07:41', '2026-08-09 04:28:57'),
	(3, 'Bapak Rahmat (Orang Tua)', 'ortu@ortu.com', 'ortu', '2026-08-05 09:07:41', '$2y$12$I0P/e3tHOG1wyO/Qke9y7.gEro.opO2FfOT6D8aYV9za3ejRtBufq', 'zjz4AnSY2xa5NO2VB7GDeZekZCvxO0UxMgvbBq18kO3pc7BoR4WrHDXJ8vND', '2026-08-05 09:07:41', '2026-08-05 09:07:41'),
	(4, 'Ibu Halimah (Orang Tua)', 'ortu2@ortu.com', 'ortu', '2026-08-05 09:07:41', '$2y$12$qv5aECriYSwnvBiq45v0m.tytLdBggLRrjx0VgoQx8eVv9z7zVibG', 'UVgBD9Iz9e', '2026-08-05 09:07:41', '2026-08-05 09:07:41');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
