# MINI SKRIPSI

## Judul

**"Rancang Bangun Sistem Informasi Reservasi Lapangan Olahraga Berbasis Web Menggunakan Framework Laravel"**

> Subjudul alternatif (pilih salah satu sesuai arahan dosen):
> - *"Studi Kasus: Pengelolaan Jadwal dan Pembayaran pada Venue Olahraga Multi-Cabang"*
> - *"dengan Fitur Manajemen Booking Real-Time dan Laporan Pendapatan"*

---

## Identitas Dokumen

| Item | Keterangan |
|---|---|
| Program Studi | Teknik Informatika / Sistem Informasi |
| Jenjang | D3 / S1 (sesuaikan) |
| Tahun Akademik | 2025/2026 |
| Nama Aplikasi | SportBook |

---

## 1. Latar Belakang

Pengelolaan lapangan olahraga seperti futsal, badminton, basket, dan mini soccer di Indonesia mayoritas masih dilakukan secara manual melalui WhatsApp, telepon, atau catatan buku harian. Cara ini memiliki sejumlah kelemahan yang signifikan, antara lain:

- **Double booking** — dua pelanggan memesan slot yang sama tanpa sistem pencegahan otomatis
- **Tidak ada transparansi jadwal** — pelanggan tidak bisa mengecek ketersediaan secara mandiri
- **Rekap keuangan sulit** — admin harus membuat laporan pendapatan secara manual
- **Bukti transaksi tidak terdokumentasi** — rentan sengketa antara pelanggan dan pengelola

Berdasarkan permasalahan tersebut, dibangunlah **SportBook**, sebuah sistem informasi reservasi lapangan olahraga berbasis web yang mengotomatisasi proses pemesanan, pembayaran, dan pelaporan secara digital dan real-time.

---

## 2. Rumusan Masalah

1. Bagaimana merancang sistem reservasi lapangan olahraga yang mampu mencegah terjadinya *double booking*?
2. Bagaimana mengimplementasikan fitur pengecekan ketersediaan slot secara *real-time* berbasis web?
3. Bagaimana membangun sistem manajemen pembayaran manual dengan alur verifikasi oleh admin?
4. Bagaimana menghasilkan laporan pendapatan yang dapat diekspor dalam format CSV dan PDF?

---

## 3. Tujuan Penelitian

1. Merancang dan membangun sistem reservasi lapangan olahraga berbasis web menggunakan Laravel 12.
2. Mengimplementasikan mekanisme pencegahan *double booking* menggunakan validasi di level aplikasi dan database.
3. Menyediakan fitur slot ketersediaan real-time yang dapat diakses oleh pelanggan tanpa perlu menghubungi admin.
4. Menghadirkan dashboard admin dengan laporan pendapatan yang dapat diekspor ke CSV dan PDF.

---

## 4. Manfaat Penelitian

**Bagi Pengelola Lapangan:**
- Mengurangi kesalahan administrasi dan *double booking*
- Mempermudah rekap pendapatan harian/bulanan
- Memiliki bukti transaksi pembayaran yang terdokumentasi

**Bagi Pelanggan:**
- Bisa mengecek dan memesan lapangan kapan saja tanpa telepon
- Mendapatkan konfirmasi booking yang jelas dan tercatat

**Bagi Akademik:**
- Referensi implementasi *full-stack* Laravel dengan pola arsitektur MVC
- Contoh penerapan REST API menggunakan Laravel Sanctum

---

## 5. Batasan Penelitian

- Sistem dibangun untuk satu venue (single-venue) pada versi ini
- Pembayaran menggunakan metode manual (transfer bank + upload bukti)
- Notifikasi email bersifat opsional, tidak menjadi fitur inti pengujian
- Tidak mencakup aplikasi mobile native; antarmuka bersifat *web responsive*
- Pengujian dilakukan di lingkungan lokal (localhost) dengan database SQLite/MySQL

---

## 6. Tech Stack

### Backend
| Teknologi | Versi | Fungsi |
|---|---|---|
| **PHP** | 8.2+ | Bahasa pemrograman utama |
| **Laravel** | 12.x | Framework backend (MVC, routing, ORM, middleware) |
| **Laravel Sanctum** | 4.x | Autentikasi token untuk REST API |
| **Eloquent ORM** | (bawaan Laravel) | Interaksi database dengan pola Active Record |
| **Laravel Queue** | (bawaan Laravel) | Proses asinkron (notifikasi, laporan) |

### Frontend
| Teknologi | Versi | Fungsi |
|---|---|---|
| **Blade** | (bawaan Laravel) | Template engine server-side rendering |
| **Bootstrap** | 5.3 | Framework CSS responsif |
| **Bootstrap Icons** | 1.11 | Ikon antarmuka |
| **Vanilla JavaScript** | ES6+ | Interaktivitas (slot grid, preview harga, AJAX) |

### Database
| Teknologi | Keterangan |
|---|---|
| **MySQL** | 8.0+ — database produksi |
| **SQLite** | Untuk pengembangan lokal / testing |

### Tools & Pendukung
| Teknologi | Fungsi |
|---|---|
| **Composer** | Dependency manager PHP |
| **NPM / Vite** | Build tool frontend (CSS/JS bundling) |
| **Git** | Version control |
| **Artisan CLI** | Generator kode, migrasi, seeder Laravel |
| **Postman** | Pengujian REST API |

---

## 7. Arsitektur Sistem

```
┌─────────────────────────────────────────────────────┐
│                    CLIENT BROWSER                   │
│         (Blade Views + Bootstrap 5 + JS)            │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP Request
┌──────────────────────▼──────────────────────────────┐
│                  LARAVEL 12 (MVC)                   │
│  ┌─────────────┐  ┌──────────────┐  ┌────────────┐  │
│  │  Routes     │→ │ Controllers  │→ │   Views    │  │
│  │ web.php     │  │ Web + Admin  │  │  (Blade)   │  │
│  │ api.php     │  │ API Layer    │  └────────────┘  │
│  └─────────────┘  └──────┬───────┘                  │
│                          │                          │
│  ┌───────────────────────▼──────────────────────┐   │
│  │              Models (Eloquent ORM)           │   │
│  │  User · Venue · Field · Booking · Payment   │   │
│  └───────────────────────┬──────────────────────┘   │
│                          │                          │
│  ┌───────────────────────▼──────────────────────┐   │
│  │           Middleware & Auth                  │   │
│  │     AdminMiddleware · CustomerMiddleware     │   │
│  │     Laravel Sanctum (API Token Auth)         │   │
│  └──────────────────────────────────────────────┘   │
└──────────────────────┬──────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────┐
│                   DATABASE                          │
│          MySQL 8 / SQLite (development)             │
└─────────────────────────────────────────────────────┘
```

---

## 8. Desain Database (ERD Ringkas)

### Tabel Utama

```
users
├── id (PK)
├── name
├── email (unique)
├── phone
├── role          → enum: customer | admin | super_admin
├── password      → bcrypt hashed
└── timestamps

venues
├── id (PK)
├── owner_id      → FK users.id
├── name
├── address
├── city
└── description

fields
├── id (PK)
├── venue_id      → FK venues.id
├── name
├── sport_type    → Futsal | Badminton | Basket | Mini Soccer | dll
├── price_per_hour
├── description
├── photo
├── is_active
└── timestamps

field_schedules
├── id (PK)
├── field_id      → FK fields.id
├── day_of_week   → monday | tuesday | ... | sunday
├── open_time     → HH:MM:SS (format 24 jam, misal 08:00:00)
└── close_time    → HH:MM:SS (format 24 jam, misal 22:00:00)

bookings
├── id (PK)
├── user_id       → FK users.id
├── field_id      → FK fields.id
├── booking_date  → DATE
├── start_time    → TIME (format 24 jam)
├── end_time      → TIME (format 24 jam)
├── status        → pending | confirmed | rejected | cancelled | completed
├── total_price
└── timestamps

payments
├── id (PK)
├── booking_id    → FK bookings.id
├── payment_proof → path file bukti transfer
├── amount
├── payment_method
├── status        → pending | verified | rejected
├── verified_by   → FK users.id (admin)
├── verified_at
└── timestamps
```

### Relasi
- `User` 1 → N `Booking`
- `Venue` 1 → N `Field`
- `Field` 1 → N `FieldSchedule`
- `Field` 1 → N `Booking`
- `Booking` 1 → 1 `Payment`

---

## 9. Fitur Aplikasi

### Modul Customer (Pelanggan)
| Fitur | Deskripsi |
|---|---|
| Registrasi & Login | Autentikasi berbasis session (web) dan token (API) |
| Lihat Daftar Lapangan | Dengan filter jenis olahraga, harga, ketersediaan |
| Cek Slot Real-Time | Grid slot 00:00–23:00 (format 24 jam) per tanggal |
| Buat Booking | Pilih tanggal, jam mulai, jam selesai — preview harga otomatis |
| Upload Bukti Pembayaran | Upload foto transfer untuk diverifikasi admin |
| Riwayat Booking | Lihat status semua booking milik sendiri |
| Batalkan Booking | Pembatalan oleh pelanggan sebelum dikonfirmasi |

### Modul Admin
| Fitur | Deskripsi |
|---|---|
| Dashboard | Ringkasan booking hari ini, pendapatan, aktivitas terbaru |
| Manajemen Lapangan | CRUD lapangan, atur jadwal operasional per hari |
| Manajemen Booking | Lihat semua booking, verifikasi pembayaran, ubah status |
| Laporan Pendapatan | Filter per bulan, grafik harian & per jenis olahraga |
| Export CSV | Unduh laporan dalam format `.csv` (compatible Excel) |
| Export PDF | Cetak laporan sebagai PDF melalui print browser |

### REST API (Laravel Sanctum)
| Endpoint | Method | Auth |
|---|---|---|
| `/api/register` | POST | Public |
| `/api/login` | POST | Public |
| `/api/logout` | POST | Token |
| `/api/venues` | GET | Public |
| `/api/fields/{id}/availability` | GET | Public |
| `/api/bookings` | POST | Customer |
| `/api/bookings/me` | GET | Customer |
| `/api/bookings/{id}/cancel` | PUT | Customer |
| `/api/payments/{id}/upload` | POST | Customer |
| `/api/admin/bookings` | GET | Admin |
| `/api/admin/bookings/{id}/status` | PUT | Admin |
| `/api/admin/reports` | GET | Admin |

---

## 10. Alur Kerja Sistem (Flowchart Ringkas)

```
[Pelanggan] → Login/Register
     ↓
Pilih Lapangan → Cek Slot (real-time, 24 jam)
     ↓
Pilih Slot & Isi Form → Submit Booking
     ↓
Booking dibuat → Status: PENDING
     ↓
Pelanggan Transfer & Upload Bukti Bayar
     ↓
[Admin] Terima Notifikasi → Verifikasi Pembayaran
     ↓
  [Valid?]
  ├── Ya  → Status: CONFIRMED → Notifikasi ke pelanggan
  └── Tidak → Status: REJECTED → Pelanggan diberitahu
     ↓
Waktu bermain tiba → Status: COMPLETED
```

---

## 11. Kebutuhan Sistem (System Requirements)

### Kebutuhan untuk Development (Lokal)
| Kebutuhan | Spesifikasi Minimum |
|---|---|
| OS | Windows 10 / macOS / Linux |
| PHP | 8.2 atau lebih baru |
| Composer | Versi terbaru |
| Node.js + NPM | Node 18+ / NPM 9+ |
| Database | MySQL 8.0 atau SQLite 3 |
| Web Server | PHP built-in server (`php artisan serve`) atau XAMPP/Laragon |
| RAM | 4 GB (disarankan 8 GB) |
| Storage | Minimal 500 MB untuk project + dependencies |

### Kebutuhan untuk Production (Hosting)
| Kebutuhan | Spesifikasi |
|---|---|
| PHP | 8.2+ dengan ekstensi: mbstring, openssl, pdo, tokenizer, xml, ctype, json |
| Web Server | Nginx atau Apache dengan `mod_rewrite` |
| Database | MySQL 8.0+ |
| SSL | HTTPS (wajib untuk keamanan Sanctum token) |
| Storage | Minimal 2 GB (termasuk file upload bukti pembayaran) |

---

## 12. Cara Instalasi (Development)

```bash
# 1. Clone / download project
git clone <repo-url>
cd nama-proyek

# 2. Install dependencies PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=sportbook
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi + seeder
php artisan migrate --seed

# 7. Install dependencies frontend
npm install && npm run build

# 8. Buat symlink storage
php artisan storage:link

# 9. Jalankan server
php artisan serve
```

---

## 13. Pengujian

### Jenis Pengujian yang Dilakukan

| Jenis | Metode | Tool |
|---|---|---|
| **Fungsional** | Black-box testing — setiap fitur diuji sesuai skenario use case | Manual / Browser |
| **API** | Uji setiap endpoint dengan data valid dan tidak valid | Postman |
| **Validasi Form** | Uji input tidak valid, field kosong, format salah | Manual |
| **Concurrent Booking** | Simulasi dua user booking slot yang sama bersamaan | Manual / Postman |
| **Responsivitas** | Tampilan di desktop, tablet, mobile | Chrome DevTools |
| **Kompatibilitas Browser** | Chrome, Firefox, Edge | Manual |

### Skenario Uji Utama

| ID | Skenario | Hasil yang Diharapkan |
|---|---|---|
| TC-01 | Customer booking slot yang tersedia | Booking berhasil, status pending |
| TC-02 | Customer booking slot yang sudah dipesan | Ditolak, pesan error double booking |
| TC-03 | Upload bukti pembayaran valid | File tersimpan, status menunggu verifikasi |
| TC-04 | Admin konfirmasi pembayaran | Status booking berubah menjadi confirmed |
| TC-05 | Admin export laporan CSV | File `.csv` terunduh dengan data lengkap |
| TC-06 | Admin cetak laporan PDF | Halaman print terbuka, siap dicetak |
| TC-07 | Login dengan kredensial salah | Gagal login, pesan error ditampilkan |
| TC-08 | Customer akses halaman admin | Ditolak, redirect ke halaman pelanggan |

---

## 14. Struktur Direktori Project

```
nama-proyek/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Web/
│   │   │   │   ├── Admin/          ← Controller halaman admin
│   │   │   │   │   ├── DashboardController.php
│   │   │   │   │   ├── FieldController.php
│   │   │   │   │   ├── BookingController.php
│   │   │   │   │   └── ReportController.php  ← + export CSV & PDF
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   └── HomeController.php
│   │   │   └── (API Controllers)
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── CustomerMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Venue.php
│       ├── Field.php
│       ├── FieldSchedule.php
│       ├── Booking.php
│       └── Payment.php
├── database/
│   ├── migrations/              ← Skema database
│   └── seeders/                 ← Data awal (admin, venue, lapangan)
├── resources/
│   └── views/
│       ├── layouts/             ← Template utama (app + admin)
│       ├── home/                ← Halaman publik
│       ├── bookings/            ← Halaman booking customer
│       ├── admin/               ← Halaman admin
│       │   ├── dashboard.blade.php
│       │   ├── bookings/
│       │   ├── fields/
│       │   └── reports/
│       │       ├── index.blade.php   ← Laporan + tombol export
│       │       └── pdf.blade.php     ← Template cetak PDF
│       └── auth/                ← Login & register
├── routes/
│   ├── web.php                  ← Route halaman web
│   └── api.php                  ← Route REST API
└── public/
    └── img/                     ← Gambar olahraga
```

---

## 15. Rencana Pengembangan Lanjutan

| Fase | Fitur | Estimasi |
|---|---|---|
| **Fase 2** | Integrasi payment gateway otomatis (Midtrans / Xendit) | 2–3 minggu |
| **Fase 2** | Notifikasi email otomatis saat status booking berubah | 1 minggu |
| **Fase 3** | Dukungan multi-venue dengan Super Admin | 2 minggu |
| **Fase 3** | Aplikasi mobile (Flutter/React Native) memanfaatkan API Sanctum | 4–6 minggu |
| **Fase 3** | Sistem loyalty point & diskon member | 2 minggu |

---

## 16. Referensi

- Laravel Documentation — https://laravel.com/docs/12.x
- Laravel Sanctum — https://laravel.com/docs/sanctum
- Bootstrap 5 — https://getbootstrap.com/docs/5.3
- Bootstrap Icons — https://icons.getbootstrap.com
- PHP 8.2 Manual — https://www.php.net/manual/en
- Pressman, R. S. (2014). *Software Engineering: A Practitioner's Approach* (8th ed.). McGraw-Hill.
- Sommerville, I. (2016). *Software Engineering* (10th ed.). Pearson.

---

*Dokumen ini dibuat berdasarkan implementasi nyata sistem SportBook yang telah dibangun.*
