# Deploy ke cPanel

`.cpanel.yml` menaruh kode di `~/laravel/unsia-story-v2` dan isi `public/` ke
`~/public_html`, supaya `.env` dan `config/` tidak bisa dibuka lewat browser.

## Syarat hosting

PHP **8.3+**, ekstensi: `ctype dom fileinfo filter gd hash iconv json libxml
mbstring openssl pcre session simplexml tokenizer xml xmlreader xmlwriter zip zlib`
(`zip` + `xml*` + `gd` dipakai impor Excel).

---

# Jalur A — hosting punya Terminal

```bash
cd ~/laravel/unsia-story-v2
composer install --no-dev --optimize-autoloader
cp .env.example .env     # isi APP_URL + DB_*, APP_DEBUG=false
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=ProdiSeeder
php artisan db:seed --class=MataKuliahSeeder
chmod -R 775 storage bootstrap/cache
```

Kalau PHP default bukan 8.3, pakai path lengkap:
`/opt/cpanel/ea-php83/root/usr/bin/php artisan ...`

### Migrasi data dari situs v1

Buat database kedua di cPanel, impor dump v1 ke sana, lalu tambahkan di `.env`:

```ini
DB_V1_DATABASE=<nama_db_v1>
DB_V1_USERNAME=<user>
DB_V1_PASSWORD=<password>
```

```bash
php artisan migrasi:v1 --uji   # lihat dulu berapa baris yang akan pindah
php artisan migrasi:v1
```

Perintah ini melewati baris yang id-nya sudah ada, jadi aman dijalankan ulang.
Setelah selesai, baris `DB_V1_*` boleh dihapus dari `.env`.

---

# Jalur B — tanpa Terminal (File Manager + phpMyAdmin)

Semua langkah berikut tidak memerlukan command line sama sekali.

### 1. Database

**MySQL Databases** → buat database + user → **All Privileges**.

**phpMyAdmin** → pilih database itu → tab **Import** → pilih berkas
`unsia-story-v2-SIAP-IMPOR.sql` → **Go**.

Berkas itu sudah berisi seluruh struktur tabel v2 **beserta data situs lama**
yang sudah dipetakan ke skema baru, jadi `php artisan migrate` tidak perlu
dijalankan.

### 2. vendor/

Unggah `vendor-produksi.zip` ke `/home/<user>/laravel/unsia-story-v2/`
lewat File Manager, lalu klik **Extract**. Hasilnya folder `vendor/`.

### 3. .env

Buat berkas `.env` di `/home/<user>/laravel/unsia-story-v2/` lewat File Manager
(aktifkan **Show Hidden Files**), isi dari `.env.production` yang sudah
disiapkan. `APP_KEY` di dalamnya sudah terisi, tidak perlu `key:generate`.

Yang wajib diganti: `APP_URL`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

### 4. Izin folder

File Manager → pilih `storage` → **Permissions** → `775`, centang
**Recurse into subdirectories**. Ulangi untuk `bootstrap/cache`.

---

## Deploy berikutnya

`git push` → cPanel → Git Version Control → Manage → Update from Remote →
Deploy HEAD Commit.

Deploy **tidak** menimpa `.env`, `vendor/`, maupun `storage/`. Kalau ada
migrasi database baru, jalankan manual (Jalur A) atau impor SQL-nya (Jalur B).

## Setelah situs hidup

- Login admin memakai akun lama yang ikut termigrasi:
  email `unsiastoryadmin@unsia-lama.local`, password sama dengan password
  `admin-login.php` di situs v1. **Segera ganti email dan passwordnya**
  lewat menu Profil Saya.
- Tambahkan Tahun Ajar di panel admin, dan isi nominal cashback-nya
  kalau fitur itu mau dipakai.
- Submit `https://<domain>/sitemap.xml` ke Google Search Console.

## Catatan

- `.env` tidak pernah ikut Git.
- Tidak perlu `npm run build`.
- `storage/app/private/` berisi berkas pemohon bantuan dan bukti cashback.
  Jangan pernah dipindahkan ke dalam `public_html`.
- Redirect 301 dari URL v1 diatur di `public/.htaccess`, bagian
  "Redirect warisan situs v1".
