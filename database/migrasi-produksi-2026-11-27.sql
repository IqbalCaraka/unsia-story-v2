-- =====================================================================
-- Migrasi produksi unsia.my.id — 27 November 2026
--
-- Untuk dijalankan lewat phpMyAdmin di cPanel, karena server produksi
-- tidak punya akses Terminal untuk menjalankan `php artisan migrate`.
--
-- CARA PAKAI
--   1. BACKUP DULU. cPanel > phpMyAdmin > pilih database > tab Export
--      > Go. Simpan berkasnya. Jangan lewati langkah ini.
--   2. phpMyAdmin > pilih database > tab SQL
--   3. Tempel SELURUH isi berkas ini, lalu klik Go.
--   4. Setelah berhasil, bersihkan cache Laravel (lihat catatan di akhir).
--
-- Setiap pernyataan memakai IF NOT EXISTS atau pengecekan, jadi aman
-- dijalankan ulang kalau sebagian sudah terlanjur dibuat.
-- =====================================================================


-- ---------------------------------------------------------------------
-- 1. Role "downline" pada tabel users
-- ---------------------------------------------------------------------
ALTER TABLE `users`
  MODIFY `role` ENUM('superadmin','admin','mahasiswa','downline')
  NOT NULL DEFAULT 'mahasiswa';


-- ---------------------------------------------------------------------
-- 2. Tabel downlines
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `downlines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `id_downline` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_downline` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','tidak_aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `downlines_user_id_unique` (`user_id`),
  UNIQUE KEY `downlines_id_downline_unique` (`id_downline`),
  UNIQUE KEY `downlines_kode_downline_unique` (`kode_downline`),
  CONSTRAINT `downlines_user_id_foreign` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 3. Tabel downline_social_media
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `downline_social_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `downline_id` bigint unsigned NOT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `downline_social_media_downline_id_platform_akun_unique`
    (`downline_id`,`platform`,`akun`),
  CONSTRAINT `downline_social_media_downline_id_foreign` FOREIGN KEY (`downline_id`)
    REFERENCES `downlines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 4. Tabel log_cashback
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `log_cashback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengajuan_cashback_id` bigint unsigned NOT NULL,
  `aksi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oleh_user_id` bigint unsigned DEFAULT NULL,
  `status_lama` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_baru` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_cashback_oleh_user_id_foreign` (`oleh_user_id`),
  KEY `log_cashback_pengajuan_cashback_id_created_at_index`
    (`pengajuan_cashback_id`,`created_at`),
  CONSTRAINT `log_cashback_oleh_user_id_foreign` FOREIGN KEY (`oleh_user_id`)
    REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `log_cashback_pengajuan_cashback_id_foreign` FOREIGN KEY (`pengajuan_cashback_id`)
    REFERENCES `pengajuan_cashback` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 5. Status "dibatalkan" pada pengajuan cashback
-- ---------------------------------------------------------------------
ALTER TABLE `pengajuan_cashback`
  MODIFY `status` ENUM('menunggu','diverifikasi','dibayar','ditolak','dibatalkan')
  NOT NULL DEFAULT 'menunggu';


-- ---------------------------------------------------------------------
-- 6. Kolom gelombang dan terakhir_login_pada pada users
--
--    MySQL tidak mengenal "ADD COLUMN IF NOT EXISTS", jadi dipakai
--    pengecekan ke information_schema supaya aman dijalankan ulang.
-- ---------------------------------------------------------------------
SET @ada := (SELECT COUNT(*) FROM information_schema.columns
             WHERE table_schema = DATABASE()
               AND table_name = 'users' AND column_name = 'gelombang');
SET @sql := IF(@ada = 0,
  'ALTER TABLE `users` ADD `gelombang` tinyint unsigned NULL AFTER `tahun_ajar_id`',
  'SELECT ''kolom gelombang sudah ada''');
PREPARE j FROM @sql; EXECUTE j; DEALLOCATE PREPARE j;

SET @ada := (SELECT COUNT(*) FROM information_schema.columns
             WHERE table_schema = DATABASE()
               AND table_name = 'users' AND column_name = 'terakhir_login_pada');
SET @sql := IF(@ada = 0,
  'ALTER TABLE `users` ADD `terakhir_login_pada` timestamp NULL AFTER `remember_token`',
  'SELECT ''kolom terakhir_login_pada sudah ada''');
PREPARE j FROM @sql; EXECUTE j; DEALLOCATE PREPARE j;


-- ---------------------------------------------------------------------
-- 7. Tandai keenam migrasi sebagai sudah dijalankan
--
--    WAJIB. Tanpa ini, `php artisan migrate` berikutnya akan mencoba
--    membuat tabel yang sudah ada dan berhenti dengan error.
-- ---------------------------------------------------------------------
SET @batch := (SELECT IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT baru.m, baru.b FROM (
            SELECT '2026_11_13_000001_add_downline_role_and_create_downlines_table' AS m, @batch AS b
  UNION ALL SELECT '2026_11_13_000002_create_downline_social_media_table', @batch
  UNION ALL SELECT '2026_11_26_000001_create_log_cashback_table', @batch
  UNION ALL SELECT '2026_11_26_000002_add_dibatalkan_status_to_pengajuan_cashback', @batch
  UNION ALL SELECT '2026_11_26_000003_add_gelombang_to_users_table', @batch
  UNION ALL SELECT '2026_11_27_000001_add_terakhir_login_to_users_table', @batch
) AS baru
WHERE NOT EXISTS (
  SELECT 1 FROM `migrations` AS m2 WHERE m2.`migration` = baru.m
);


-- ---------------------------------------------------------------------
-- 8. Pemeriksaan hasil — semuanya harus bernilai 1
-- ---------------------------------------------------------------------
SELECT 'tabel downlines' AS diperiksa, COUNT(*) AS hasil FROM information_schema.tables
  WHERE table_schema = DATABASE() AND table_name = 'downlines'
UNION ALL SELECT 'tabel downline_social_media', COUNT(*) FROM information_schema.tables
  WHERE table_schema = DATABASE() AND table_name = 'downline_social_media'
UNION ALL SELECT 'tabel log_cashback', COUNT(*) FROM information_schema.tables
  WHERE table_schema = DATABASE() AND table_name = 'log_cashback'
UNION ALL SELECT 'kolom users.gelombang', COUNT(*) FROM information_schema.columns
  WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'gelombang'
UNION ALL SELECT 'kolom users.terakhir_login_pada', COUNT(*) FROM information_schema.columns
  WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'terakhir_login_pada'
UNION ALL SELECT 'role downline tersedia', COUNT(*) FROM information_schema.columns
  WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'role'
    AND column_type LIKE '%downline%'
UNION ALL SELECT 'status dibatalkan tersedia', COUNT(*) FROM information_schema.columns
  WHERE table_schema = DATABASE() AND table_name = 'pengajuan_cashback' AND column_name = 'status'
    AND column_type LIKE '%dibatalkan%';


-- =====================================================================
-- SETELAH SQL INI BERHASIL
--
-- Bersihkan cache Laravel, kalau tidak perubahan config dan tampilan
-- tidak akan terlihat. Lewat cPanel File Manager, hapus isi:
--
--   bootstrap/cache/config.php       (kalau ada)
--   bootstrap/cache/routes-v7.php    (kalau ada)
--   storage/framework/views/*.php    (semua berkas di dalamnya)
--
-- Berkas-berkas itu dibuat ulang otomatis saat situs diakses.
-- =====================================================================
