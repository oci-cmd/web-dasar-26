# Repositori Resmi Praktikum Pemrograman Web Dasar
### STMIK IKMI Cirebon — Semester Ganjil 2026/2027
**Domain Target Produksi**: `webdasar26.designme.my.id`

Repositori ini memuat seluruh kode sumber (*source code*) praktikum **Pemrograman Web Dasar (PHP 8+, MySQL, PDO Prepared Statements, Modern CSS & Vanilla JavaScript)** yang mencakup 51 modul live-coding terstruktur dan 2 Mini Project berskala enterprise dengan pola arsitektur **Model-View-Controller (MVC) Native**.

---

## 🚀 Fitur Utama Repositori

1. **Dashboard Portal Interaktif (`index.php`)**:
   - Navigasi modern berbasis tema terang/gelap (*Dark/Light Mode*).
   - Filter modul cepat per Program Studi (**Komputerisasi Akuntansi / KA** dan **Sistem Informasi / SI**).
   - Filter pertemuan (P9 hingga P15) serta fitur pencarian instan (*live search*).
   - Tautan langsung ke live runner sandbox (`viewer.php`) dan unduhan arsip ZIP proyek.

2. **51 Modul Live-Coding Terstruktur**:
   - **Prodi Komputerisasi Akuntansi (KA)**: 25 Modul praktikum fokus pada perbankan, kas masuk/keluar, buku besar, PSAK, dan forensik akuntansi digital.
   - **Prodi Sistem Informasi (SI)**: 26 Modul praktikum fokus pada arsitektur enterprise, inventory multi-gudang, B2B order, SPK SAW, dan keamanan OWASP Top 10.

3. **2 Mini Project Enterprise MVC & OOP**:
   - **Mini Project SI (`si/projek-mini/`)**: Sistem ERP Multi-Gudang, Pengadaan Supplier B2B, Sistem Pendukung Keputusan (SPK SAW), dan Log Audit Keamanan Siber.
   - **Mini Project KA (`ka/projek-mini/`)**: Sistem Informasi Akuntansi (SIA), Chart of Accounts (COA), Jurnal Kas Masuk & Keluar, serta Mutasi Rekening Bank.

4. **Pondasi Keamanan Tingkat Tinggi (OWASP Web Security)**:
   - **PDO Strict Mode**: Prepared Statements murni tanpa emulasi query (`PDO::ATTR_EMULATE_PREPARES => false`) untuk menutup celah SQL Injection.
   - **Anti-XSS**: Sanitasi output otomatis dengan `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`.
   - **Password Security**: Enkripsi searah dengan algoritma `PASSWORD_BCRYPT`.
   - **Session Hardening**: Proteksi Session Fixation dan Session Hijacking menggunakan `session_regenerate_id(true)` dan middleware `SessionGuard`.

5. **Otomatisasi Database Migrator (`setup_database.php`)**:
   - Migrator satu-klik untuk membuat basis data, skema tabel, relasi foreign key, dan data sampel (*seeders*) secara otomatis.
   - Fleksibilitas koneksi database (otomatis beralih antara konfigurasi lokal XAMPP port 3306 atau database online).

---

## 📂 Struktur Direktori Proyek

```text
webdasar26.designme.my.id/
├── assets/
│   ├── css/
│   │   └── style.css            # Desain UI modern, responsive flexbox & grid
│   └── js/
│       └── app.js               # Dark mode switcher, live filter, & modal box
├── config/
│   ├── database.php             # Class koneksi PDO singleton & error handler
│   └── env.php                  # Konfigurasi environment (DB, APP domain, credentials)
├── docs/
│   ├── Praktikum Mini Projek - SI.pdf
│   ├── Praktikum Mini Projek - KA.pdf
│   └── Menjalankan Projek PHP di VS Code.docx
├── downloads/
│   ├── mini_project_si.zip      # Arsip siap pakai mini project SI
│   └── mini_project_ka.zip      # Arsip siap pakai mini project KA
├── ka/                          # 25 Modul Live-Coding Prodi Komputerisasi Akuntansi
│   ├── pertemuan-09/ s.d. pertemuan-15/
│   └── projek-mini/             # Arsitektur MVC Mini Project Akuntansi
├── si/                          # 26 Modul Live-Coding Prodi Sistem Informasi
│   ├── pertemuan-09/ s.d. pertemuan-15/
│   └── projek-mini/             # Arsitektur MVC Mini Project Sistem Informasi
├── index.php                    # Dashboard katalog utama modul praktikum
├── manifest.json                # Metadata katalog dan pemetaan materi modul
├── setup_database.php           # Inisialisasi basis data otomatis
└── viewer.php                   # Runner terisolasi penampil kode dan demo modul
```

---

## 🛠️ Panduan Menjalankan di Komputer Lokal

### Prasyarat Sistem
- **PHP** versi 8.0, 8.1, 8.2, atau 8.3 (dengan ekstensi `pdo_mysql` aktif).
- **MySQL / MariaDB** (melalui XAMPP, MAMP, atau MySQL Server standalone).
- Web Browser modern (Google Chrome, Microsoft Edge, Mozilla Firefox, atau Safari).

### Langkah Instalasi
1. **Clone Repositori**:
   ```bash
   git clone https://github.com/oci-cmd/web-dasar-26.git
   cd web-dasar-26
   ```

2. **Jalankan Layanan Database (MySQL)**:
   - Pastikan service MySQL pada XAMPP/MAMP dalam kondisi berjalan (*Running* di port 3306).

3. **Inisialisasi Database Otomatis**:
   - Jalankan script migrator langsung dari terminal:
     ```bash
     php setup_database.php
     ```
   - Atau buka file `setup_database.php` melalui browser setelah web server aktif.

4. **Jalankan Built-in PHP Server**:
   ```bash
   php -S localhost:8000
   ```

5. **Akses Dashboard Melalui Browser**:
   - Buka browser dan kunjungi: **`http://localhost:8000`**

---

## 🔐 Kredensial Login Demo (Mini Project)

| Program Studi | Role / Level | Username | Password |
| :--- | :--- | :--- | :--- |
| **Sistem Informasi (SI)** | Super Admin | `admin` | `admin123` |
| **Sistem Informasi (SI)** | Operator Gudang | `gudang` | `gudang123` |
| **Komputerisasi Akuntansi (KA)** | Akuntan Utama | `akuntan` | `akuntan123` |
| **Komputerisasi Akuntansi (KA)** | Kasir Operasional | `kasir` | `kasir123` |

---

## 👥 Pengampu & Institusi
- **Mata Kuliah**: Pemrograman Web Dasar
- **Institusi**: STMIK IKMI Cirebon
- **Tahun Akademik**: 2026/2027 (Semester Ganjil)
- **Lisensi**: Hak Cipta dilindungi untuk keperluan pembelajaran akademik STMIK IKMI Cirebon.
