# Dashboard Kinerja & CMS Admin — PLN UPT Manado

Sistem dashboard monitoring kinerja transmisi dan manajemen konten (CMS) berbasis **Laravel**, dirancang untuk visualisasi metrik operasional, pemetaan GIS interaktif, serta pengelolaan data secara dinamis.

---

## 🌟 Fitur Utama

### 1. Halaman Publik (Frontend)
- **Dashboard Utama**:
  - Ringkasan Kinerja Unit (NKO) dengan filter berkala.
  - Peta GIS interaktif (Leaflet.js) menampilkan jalur transmisi 150kV / 70kV dan titik Gardu Induk (GI).
  - Ringkasan Health Index Peralatan (MTU, Proteksi/Relay, Tower, dan inspeksi IL3 Power Inspect).
  - Ringkasan Common Enemy dan Program Anti Blackout (ABO).
  - Indikator progres konstruksi & penyaluran COD / STO.
- **Halaman Detail**: Kinerja Transmisi, Anggaran Unit, Anomali Health Index (AHI), Common Enemy, dan Anti Blackout.
- **UI & Tema**: Mendukung Light Mode & Dark Mode dengan palet warna korporat yang responsif di berbagai perangkat.

### 2. Panel Admin CMS
Panel administrasi untuk memperbarui konten website tanpa mengubah kode:
- 📊 **Dashboard Overview**: Ringkasan status sistem dan metrik aktif.
- ⚙️ **Pengaturan Website & Branding**: Kustomisasi judul, sub-judul, logo, jam live, dan informasi footer.
- 📑 **Manajemen Section**: Mengatur urutan, mengubah deskripsi, atau mengaktifkan/menonaktifkan section di halaman utama.
- 📈 **Kartu Statistik & Metrik**: Kelola data capaian aset, KPI, dan indikator unit.
- 🏗️ **Progres Konstruksi & COD**: Pelacakan persentase penyelesaian fisik proyek.
- 🌐 **Integrasi Sumber Data**: Manajemen endpoint data eksternal (Google Sheets / CSV) dengan fitur tes koneksi.
- 🧭 **Navigasi Header**: Pengaturan menu navigasi dinamis.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11 / PHP 8.2+
- **Frontend**: Blade Templating, Tailwind CSS, JavaScript
- **Peta GIS**: Leaflet.js
- **Database**: SQLite / MySQL / PostgreSQL

---

## 🚀 Panduan Instalasi Lokal

### 1. Clone Repository
```bash
git clone https://github.com/<username>/monitoring-plnuptmdo.git
cd monitoring-plnuptmdo
```

### 2. Install Dependensi Backend & Frontend
```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment
Salin file konfigurasi contoh dan buat application key:
```bash
cp .env.example .env
php artisan key:generate
```
> Sesuaikan pengaturan database pada file `.env` jika ingin menggunakan MySQL atau PostgreSQL.

### 4. Migrasi Database & Seeding
Jalankan migrasi tabel beserta data awal:
```bash
php artisan migrate --seed
```

### 5. Jalankan Server Pengembangan
```bash
php artisan serve
```
Akses aplikasi melalui browser:
- **Website Publik**: `http://127.0.0.1:8000`
- **Panel Admin**: `http://127.0.0.1:8000/login`

> **Catatan Administrator**: Akun default dibuat secara otomatis melalui `DatabaseSeeder.php`. Anda dapat menyesuaikan kredensial admin pada file seeder tersebut sebelum migrasi, atau memperbaruinya melalui dashboard setelah login pertama kali.

---

## 📂 Struktur Direktori

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── WebController.php         # Kontroller halaman publik
│   │   ├── AuthController.php        # Autentikasi CMS
│   │   └── Admin/                    # Kontroller modul panel admin
│   └── Models/                       # Model Eloquent (SiteSetting, Section, dll.)
├── database/
│   ├── migrations/                   # Skema database
│   └── seeders/                      # Data awal sistem & pengaturan
├── resources/views/
│   ├── layouts/app.blade.php         # Master layout
│   ├── pages/                        # Tampilan halaman publik
│   └── admin/                        # Tampilan panel admin
└── public/                           # Aset publik (gambar, icon, script GIS)
```

---

## 🔒 Keamanan

- File kredensial sensitif (`.env`) diabaikan oleh Git secara default dan tidak boleh diunggah ke repository publik.
- Pastikan `APP_DEBUG=false` pada lingkungan produksi (*production*).
- Selalu ganti password default akun administrator sebelum mempublikasikan aplikasi ke server online.
