# Activity Manager

Aplikasi Laravel untuk mengelola data kegiatan — melihat daftar, menambah, mengubah, menghapus, dan memfilter kegiatan berdasarkan status.

## Teknologi
Laravel 13, PHP 8.3, Blade, Eloquent, MySQL

## Struktur Arsitektur
- **Model** — representasi data & interaksi database (`Activity`)
- **Controller** — mengatur alur request/response (`ActivityController`)
- **Form Request** — validasi input; `StoreActivityRequest` dan `UpdateActivityRequest` extend `ActivityRequest` agar aturan validasi tidak ditulis dua kali
- **Service** — logika bisnis, termasuk aturan transisi status (`ActivityService`)
- **Blade** — menyajikan tampilan

## Cara Menjalankan

git clone <URL_REPOSITORY>
cd activity-manager
composer install

Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database:

DB_CONNECTION=mysql
DB_DATABASE=activity_manager
DB_USERNAME=root
DB_PASSWORD=

Pastikan database `activity_manager` sudah dibuat di MySQL.

php artisan key:generate
php artisan migrate --seed
php artisan serve

Buka: **http://127.0.0.1:8000/activities**

## Fitur Filter
Filter kegiatan lewat query string:

/activities?status=Planned
/activities?status=Ongoing
/activities?status=Done

Nilai status tidak valid tidak menyebabkan error — seluruh kegiatan tetap ditampilkan.

## Aturan Transisi Status

Planned → Planned / Ongoing
Ongoing → Ongoing / Done
Done    → Done

Transisi yang tidak sesuai akan ditolak oleh service.