# Activity Manager

Aplikasi Laravel untuk mengelola data kegiatan — melihat daftar, menambah, mengubah, menghapus, dan memfilter kegiatan berdasarkan status.

## Teknologi
Laravel 13, PHP 8.3, Blade, Eloquent, SQLite (MySQL opsional)

## Struktur Arsitektur
- **Model** — representasi data & interaksi database (`Activity`)
- **Controller** — mengatur alur request/response (`ActivityController`)
- **Form Request** — validasi input; `StoreActivityRequest` dan `UpdateActivityRequest` extend `ActivityRequest` agar aturan validasi tidak ditulis dua kali
- **Service** — logika bisnis, termasuk aturan transisi status (`ActivityService`)
- **Blade** — menyajikan tampilan

## Cara Menjalankan

```bash
git clone https://github.com/ashila-AS/Proyek-3_Modul-3_2026.git
cd Proyek-3_Modul-3_2026
composer install
```

Salin `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

(Di Windows CMD: `copy .env.example .env`)

Secara default aplikasi memakai SQLite, jadi tidak perlu konfigurasi database. Jika ingin memakai MySQL, ubah di `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=activity_manager
DB_USERNAME=root
DB_PASSWORD=
```

lalu pastikan database `activity_manager` sudah dibuat di MySQL.

Lanjutkan dengan:

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Jika Laravel menanyakan pembuatan file database SQLite, pilih **yes**.

Buka: **http://127.0.0.1:8000/activities**

## Fitur Filter
Filter kegiatan lewat query string:

```text
/activities?status=Planned
/activities?status=Ongoing
/activities?status=Done
```

Nilai status tidak valid tidak menyebabkan error — seluruh kegiatan tetap ditampilkan.

## Aturan Transisi Status

```text
Planned → Planned / Ongoing
Ongoing → Ongoing / Done
Done    → Done
```

Transisi yang tidak sesuai akan ditolak oleh service.