# Product Requirements Document (PRD)
## Aplikasi Reservasi Lapangan Olahraga Berbasis Web

| Item | Detail |
|---|---|
| Nama Produk | SportBook / Reservasi Lapangan Olahraga |
| Versi Dokumen | 1.0 |
| Tanggal | 10 Juli 2026 |
| Tech Stack | Laravel 12, Bootstrap 5, Laravel Sanctum, MySQL |
| Status | Draft |

---

## 1. Latar Belakang

Banyak pengelola lapangan olahraga (futsal, badminton, basket, mini soccer, tenis, dll.) masih menggunakan sistem pemesanan manual via WhatsApp/telepon/catatan buku. Hal ini menyebabkan:
- Bentrok jadwal (double booking)
- Sulit melacak riwayat transaksi dan pendapatan
- Tidak ada bukti pembayaran/konfirmasi otomatis
- Pelanggan kesulitan mengecek ketersediaan slot secara real-time

Aplikasi ini dibuat untuk mendigitalisasi proses reservasi lapangan olahraga agar lebih efisien, transparan, dan mudah diakses baik oleh pelanggan maupun pengelola.

---

## 2. Tujuan Produk

1. Memungkinkan pelanggan melihat ketersediaan lapangan secara real-time dan melakukan booking online.
2. Mengurangi risiko bentrok jadwal (double booking).
3. Mempermudah admin/pengelola mengelola lapangan, jadwal, harga, dan laporan transaksi.
4. Menyediakan sistem pembayaran & konfirmasi booking yang terdokumentasi.
5. Menyediakan API (via Sanctum) agar sistem dapat diakses dari web maupun mobile app di masa depan.

---

## 3. Target Pengguna

| Role | Deskripsi |
|---|---|
| **Pelanggan (Customer)** | Umum, ingin booking lapangan olahraga |
| **Admin Lapangan (Owner/Operator)** | Mengelola data lapangan, jadwal, harga, verifikasi pembayaran |
| **Super Admin** | Mengelola seluruh sistem, multi-venue, laporan global, manajemen user |

---

## 4. Ruang Lingkup (Scope)

### In-Scope (Versi 1.0)
- Registrasi & login (customer & admin), autentikasi berbasis token (Sanctum) untuk API
- Manajemen data venue & lapangan (jenis olahraga, foto, fasilitas, harga per jam)
- Kalender ketersediaan & jadwal booking (slot per jam)
- Proses booking oleh customer (pilih lapangan, tanggal, jam)
- Upload/konfirmasi bukti pembayaran (manual transfer) atau integrasi payment gateway (opsional, fase 2)
- Notifikasi status booking (pending, confirmed, cancelled, completed)
- Riwayat booking pelanggan
- Dashboard admin: kelola lapangan, kelola booking, laporan pendapatan
- Manajemen role & permission (customer, admin, super admin)

### Out-of-Scope (Versi 1.0)
- Aplikasi mobile native (hanya web responsive, API sudah disiapkan untuk future mobile app)
- Sistem membership/loyalty point
- Live chat customer service
- Integrasi payment gateway otomatis (dijadwalkan fase 2, misalnya Midtrans/Xendit)

---

## 5. User Stories & Fitur Utama

### 5.1 Modul Customer
| ID | User Story |
|---|---|
| US-01 | Sebagai customer, saya ingin mendaftar & login agar bisa melakukan booking |
| US-02 | Sebagai customer, saya ingin melihat daftar lapangan beserta harga dan fasilitas |
| US-03 | Sebagai customer, saya ingin melihat jadwal ketersediaan lapangan per tanggal/jam |
| US-04 | Sebagai customer, saya ingin memesan slot lapangan yang masih kosong |
| US-05 | Sebagai customer, saya ingin mengunggah bukti pembayaran setelah booking |
| US-06 | Sebagai customer, saya ingin melihat riwayat & status booking saya |
| US-07 | Sebagai customer, saya ingin membatalkan booking (sesuai kebijakan pembatalan) |
| US-08 | Sebagai customer, saya ingin menerima notifikasi (email) saat status booking berubah |

### 5.2 Modul Admin
| ID | User Story |
|---|---|
| US-09 | Sebagai admin, saya ingin menambah/mengedit/menghapus data lapangan |
| US-10 | Sebagai admin, saya ingin mengatur jam operasional & harga per jam/lapangan |
| US-11 | Sebagai admin, saya ingin melihat semua booking masuk dan memverifikasi pembayaran |
| US-12 | Sebagai admin, saya ingin mengubah status booking (confirm/reject/cancel/complete) |
| US-13 | Sebagai admin, saya ingin melihat laporan pendapatan harian/bulanan |
| US-14 | Sebagai admin, saya ingin memblokir slot tertentu (maintenance/private event) |

### 5.3 Modul Super Admin
| ID | User Story |
|---|---|
| US-15 | Sebagai super admin, saya ingin mengelola akun admin/venue |
| US-16 | Sebagai super admin, saya ingin melihat laporan seluruh venue |

---

## 6. Alur Bisnis Utama (Booking Flow)

1. Customer login/register.
2. Customer memilih venue → memilih lapangan → memilih tanggal.
3. Sistem menampilkan slot jam yang tersedia (real-time, berdasarkan data booking existing).
4. Customer memilih slot → sistem membuat booking dengan status **pending**.
5. Customer melakukan pembayaran (transfer manual) → upload bukti pembayaran.
6. Admin memverifikasi pembayaran → status booking menjadi **confirmed** (atau **rejected** jika tidak valid).
7. Sistem mengirim notifikasi email ke customer.
8. Setelah waktu bermain selesai, status otomatis/manual menjadi **completed**.
9. Booking dapat **cancelled** oleh customer (sebelum batas waktu tertentu) atau oleh admin.

---

## 7. Kebutuhan Fungsional (Functional Requirements)

| Kode | Requirement |
|---|---|
| FR-1 | Sistem harus mendukung registrasi & login dengan autentikasi token (Sanctum) |
| FR-2 | Sistem harus mencegah double booking pada slot yang sama (validasi di level DB & aplikasi) |
| FR-3 | Sistem harus menampilkan kalender/slot ketersediaan secara real-time |
| FR-4 | Sistem harus menyimpan riwayat status booking (audit trail sederhana) |
| FR-5 | Sistem harus memiliki role-based access control (customer, admin, super admin) |
| FR-6 | Sistem harus dapat generate laporan pendapatan per periode & per lapangan |
| FR-7 | Sistem harus mengirim notifikasi email saat status booking berubah |
| FR-8 | Sistem harus menyediakan REST API (Sanctum token) untuk seluruh transaksi utama |

## 8. Kebutuhan Non-Fungsional (Non-Functional Requirements)

| Kode | Requirement |
|---|---|
| NFR-1 | Waktu respons halaman < 2 detik pada kondisi normal |
| NFR-2 | Sistem harus responsive (mobile-friendly) menggunakan Bootstrap 5 |
| NFR-3 | Password disimpan dengan hashing (bcrypt/argon2) |
| NFR-4 | Data booking harus konsisten meski diakses concurrent (gunakan DB transaction & locking) |
| NFR-5 | API menggunakan Laravel Sanctum untuk autentikasi token yang aman |
| NFR-6 | Sistem harus punya backup database berkala |
| NFR-7 | Uji coba minimal di browser Chrome, Firefox, Edge (desktop & mobile) |

---

## 9. Rancangan Arsitektur Teknis

- **Backend Framework**: Laravel 12
- **Frontend**: Blade + Bootstrap 5 (server-rendered), opsional Alpine.js untuk interaktivitas ringan
- **Autentikasi API**: Laravel Sanctum (token-based, untuk kebutuhan API/mobile di masa depan)
- **Database**: MySQL 8
- **Queue/Notifikasi**: Laravel Queue + Mail (untuk email notifikasi async)
- **Storage**: Local/S3 untuk upload bukti pembayaran & foto lapangan

### Struktur Role
- Menggunakan kolom `role` di tabel `users` atau package seperti Spatie Laravel-Permission (disarankan untuk skalabilitas)

---

## 10. Rancangan Skema Database (Ringkas)

```
users
- id, name, email, phone, password, role (customer/admin/super_admin), created_at, updated_at

venues
- id, name, address, city, description, owner_id (FK users), created_at

fields (lapangan)
- id, venue_id (FK venues), name, sport_type, price_per_hour, description, photo, is_active

field_schedules (opsional, jika ada jam operasional custom per hari)
- id, field_id (FK fields), day_of_week, open_time, close_time

bookings
- id, user_id (FK users), field_id (FK fields), booking_date, start_time, end_time,
  status (pending/confirmed/rejected/cancelled/completed), total_price, created_at

payments
- id, booking_id (FK bookings), payment_proof (file path), amount, payment_method,
  status (pending/verified/rejected), verified_by (FK users), verified_at

notifications (bisa pakai built-in Laravel notifications table)
- id, user_id, type, data, read_at
```

---

## 11. Rancangan Endpoint API Utama (Sanctum)

| Method | Endpoint | Deskripsi | Auth |
|---|---|---|---|
| POST | /api/register | Registrasi customer | Public |
| POST | /api/login | Login, mengembalikan token Sanctum | Public |
| POST | /api/logout | Logout (revoke token) | Auth |
| GET | /api/venues | List venue & lapangan | Public |
| GET | /api/fields/{id}/availability?date= | Cek slot tersedia | Public |
| POST | /api/bookings | Buat booking baru | Auth (customer) |
| GET | /api/bookings/me | Riwayat booking user | Auth (customer) |
| PUT | /api/bookings/{id}/cancel | Batalkan booking | Auth (customer) |
| POST | /api/payments/{booking_id}/upload | Upload bukti pembayaran | Auth (customer) |
| GET | /api/admin/bookings | List semua booking (admin) | Auth (admin) |
| PUT | /api/admin/bookings/{id}/status | Update status booking | Auth (admin) |
| POST | /api/admin/fields | Tambah lapangan | Auth (admin) |
| PUT | /api/admin/fields/{id} | Update lapangan | Auth (admin) |
| GET | /api/admin/reports | Laporan pendapatan | Auth (admin) |

---

## 12. Wireframe/Halaman yang Dibutuhkan

**Sisi Customer:**
- Landing page (daftar venue/lapangan)
- Halaman detail lapangan + kalender ketersediaan
- Halaman form booking
- Halaman upload bukti bayar
- Halaman riwayat booking
- Halaman login/register/profile

**Sisi Admin:**
- Dashboard (ringkasan booking hari ini, pendapatan)
- Manajemen lapangan (CRUD)
- Manajemen booking (list, filter, verifikasi pembayaran, ubah status)
- Laporan (grafik pendapatan, export excel/PDF)

**Sisi Super Admin:**
- Manajemen venue & admin
- Laporan global

---

## 13. Metrik Keberhasilan (Success Metrics)

| Metrik | Target |
|---|---|
| Pengurangan booking bentrok (double booking) | 0 kasus setelah go-live |
| Waktu proses verifikasi pembayaran admin | < 1 jam |
| Tingkat adopsi (booking online vs manual) | > 70% booking via aplikasi dalam 3 bulan |
| Uptime sistem | > 99% |

---

## 14. Rencana Rilis (Milestone)

| Fase | Fitur | Estimasi |
|---|---|---|
| Fase 1 (MVP) | Auth (Sanctum), CRUD lapangan, booking, upload bukti bayar manual, dashboard admin dasar | 4-6 minggu |
| Fase 2 | Payment gateway otomatis (Midtrans/Xendit), notifikasi email/WA, laporan lanjutan | 2-3 minggu |
| Fase 3 | Multi-venue support, super admin, export laporan, optimasi performa | 2-3 minggu |

---

## 15. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Double booking akibat race condition | Gunakan DB transaction + unique constraint pada (field_id, booking_date, start_time) |
| Bukti pembayaran palsu/tidak valid | Verifikasi manual admin sebelum status confirmed |
| Beban server saat traffic tinggi | Gunakan queue untuk proses async (email, laporan) & caching |
| Keamanan API | Gunakan Sanctum token + rate limiting + validasi input ketat |

---

## 16. Lampiran

- Dokumen ini dapat dikembangkan lebih lanjut menjadi technical design document (ERD lengkap, sequence diagram booking, dan API documentation format OpenAPI/Swagger).