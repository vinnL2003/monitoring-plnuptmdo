# PLN UPT MANADO — Dashboard Kinerja & CMS Admin Laravel

Proyek web Laravel lengkap yang memuat seluruh konten dan visual dari website **PLN UPT Manado** (Dashboard Kinerja Transmisi) serta dilengkapi dengan **Panel Admin (CMS)** untuk memodifikasi konten, judul, gambar/logo, kartu metrik, progres konstruksi, dan integrasi spreadsheet Google.

---

## 🌟 Fitur Utama

### 1. Halaman Publik (Frontend)
- **Home (`/`)**: Dashboard utama yang memuat:
  1. Ringkasan Kinerja Unit (NKO) dengan filter bulanan dan popup gap point
  2. Peta GIS Leaflet interaktif dengan jalur transmisi 150kV / 70kV dan titik Gardu Induk
  3. Ringkasan Health Index Peralatan (MTU, Proteksi/Relay, Tower, dan inspeksi IL3 Power Inspect)
  4. Ringkasan Common Enemy per stream
  5. Ringkasan Program Anti Blackout (ABO)
  6. Ringkasan Progres Konstruksi & Penyaluran COD / STO
  7. Ringkasan KKU
- **Kinerja Unit (`/kinerja-transmisi`)**: Halaman detail kinerja transmisi per ULTG
- **Anggaran Unit (`/anggaran`)**: Dashboard realisasi anggaran investasi & operasi
- **AHI (`/ahi`)**: Detail Anomali Health Index peralatan
- **Common Enemy (`/common-enemy`)**: Detail program kerja penanganan gangguan
- **Program Anti Blackout (`/abo`)**: Detail program mitigasi gangguan transmisi & GI
- **Mode Tampilan**: Light Mode & Dark Mode switch yang halus
- **Branding PLN**: Desain elegan dan responsif dengan palet resmi PLN (Kuning `#FFC72C` & Biru `#00529C`)

### 2. Panel Admin CMS (`/admin`)
Panel khusus untuk mengelola konten website secara dinamis tanpa perlu mengubah baris kode:
- 📊 **Dashboard Overview**: Ringkasan status sistem, jumlah section, metrik aktif, dan pintasan cepat.
- ⚙️ **Pengaturan Website & Branding (`/admin/settings`)**:
  - Ubah judul situs (Title Tag tab browser)
  - Ubah sub-judul unit
  - Upload / ganti logo header PLN & logo hero animasi UPT Manado
  - Atur teks badge live & jam realtime hero
  - Ubah teks copyright footer
- 📑 **Kelola 7 Section (`/admin/sections`)**:
  - Aktifkan / sembunyikan section tertentu dari halaman utama (Toggle on/off)
  - Edit judul section & deskripsi pengantar
  - Atur urutan tampil
- 📈 **Kartu Statistik & Metrik (`/admin/stat-cards`)**:
  - Tambah, edit, dan hapus angka pada kartu statistik (Aset, KKU, dsb.)
  - Ubah label, angka capaian, satuan (kms, Unit, Tower, dsb.), dan footer card
- 🏗️ **Progres Konstruksi & COD (`/admin/progress`)**:
  - Tambah, edit, dan hapus indikator persentase penyelesaian fisik proyek
  - Ubah deskripsi proyek dan persentase capaian (0 - 100%)
- 🌐 **Sumber Data Google Sheets (`/admin/data-sources`)**:
  - Kelola URL endpoint CSV untuk NKO, AHI, Kondisi Tower, Aset, GI Markers, Common Enemy, dan Anti Blackout
  - Dilengkapi tombol **Test Koneksi** realtime untuk menguji respon Google Sheet
- 🧭 **Menu Navigasi Header (`/admin/navigation`)**:
  - Tambah, ubah link, atur urutan, dan sembunyikan menu pada header

---

## 🔐 Akun Login Administrator

| Parameter | Kredensial Default |
|-----------|--------------------|
| **URL Login** | `http://127.0.0.1:8000/login` |
| **Email** | `admin@pln.co.id` |
| **Password** | `admin123` |

---

## 🚀 Panduan Menjalankan Project

### 1. Masuk ke direktori project:
```bash
cd "c:\kevin\Magang\Web 1\upt-manado-laravel"
```

### 2. Migrasi Database & Seeding Data Awal:
```bash
php artisan migrate --seed
```

### 3. Jalankan Server Lokal:
```bash
php artisan serve
```
Buka browser dan akses:
- **Website Publik**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Panel Admin**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

---

## 📂 Struktur Penting Aplikasi

```
upt-manado-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── WebController.php               # Menampilkan website publik & inject data dinamis
│   │   ├── AuthController.php              # Login & logout admin
│   │   └── Admin/                          # Controller Panel Admin (CMS)
│   │       ├── DashboardController.php     # Ringkasan KPI Admin
│   │       ├── SettingController.php       # Pengaturan branding & logo
│   │       ├── SectionController.php       # Kelola 7 section
│   │       ├── StatCardController.php      # Kelola kartu metrik & aset
│   │       ├── ProgressItemController.php  # Kelola progres konstruksi & COD
│   │       ├── DataSourceController.php    # Kelola URL CSV Google Sheet
│   │       └── NavigationController.php    # Kelola menu navigasi header
│   └── Models/
│       ├── SiteSetting.php
│       ├── Section.php
│       ├── StatCard.php
│       ├── ProgressItem.php
│       ├── DataSource.php
│       └── NavigationItem.php
├── database/
│   ├── migrations/                         # Struktur tabel CMS
│   └── seeders/DatabaseSeeder.php          # Data awal (Admin user, settings, dll.)
├── resources/views/
│   ├── layouts/app.blade.php               # Master layout publik (Header, Nav, Hero, Footer)
│   ├── pages/                              # Halaman publik (Home, Kinerja, Anggaran, AHI, dll.)
│   └── admin/                              # Tampilan Panel Admin (Sleek UI)
└── public/
    ├── Logo_PLN.png, PLN_White.png         # Logo resmi PLN
    ├── Logo_UPT_Manado.png                 # Logo hero UPT Manado
    ├── tower-data.js                       # Data koordinat titik tower transmisi
    └── uploads/                            # Folder upload logo & media dinamis
```
