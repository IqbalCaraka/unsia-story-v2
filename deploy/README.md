# Deploy ke cPanel

`.cpanel.yml` menaruh kode di `~/laravel/unsia-story-v2` dan isi `public/` ke
`~/public_html`, supaya `.env` dan `config/` tidak bisa dibuka lewat browser.

## Sekali saja, lewat Terminal cPanel

```bash
cd ~/laravel/unsia-story-v2
composer install --no-dev --optimize-autoloader
cp .env.example .env     # lalu isi APP_URL + DB_*, set APP_DEBUG=false
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=ProdiSeeder
chmod -R 775 storage bootstrap/cache
```

Buat akun admin:

```bash
php artisan tinker
```
```php
App\Models\User::create(['nama'=>'Administrator','name'=>'Administrator',
  'email'=>'admin@domain.com','password'=>'password-kuat','role'=>'admin']);
```

## Syarat hosting

PHP **8.3+**, ekstensi: `ctype dom fileinfo filter gd hash iconv json libxml
mbstring openssl pcre session simplexml tokenizer xml xmlreader xmlwriter zip zlib`
(`zip` + `xml*` + `gd` dipakai impor Excel).

## Deploy berikutnya

`git push` → cPanel → Git Version Control → Manage → Update from Remote →
Deploy HEAD Commit. Kalau ada migrasi baru, jalankan `php artisan migrate --force`.

## Catatan

- `.env` tidak ikut Git, buat manual sekali di server.
- Tidak perlu `npm run build`.
- Kalau PHP default cPanel bukan 8.3, pakai path lengkap:
  `/opt/cpanel/ea-php83/root/usr/bin/php artisan ...`
