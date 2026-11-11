# 🚀 PANDUAN LENGKAP DEPLOY LARAVEL (PLN UPT MANADO) KE RAILWAY.APP

Dokumen ini adalah panduan teknis langkah demi langkah dari nol untuk meng-onlinekan aplikasi **PLN UPT Manado Web** ke **Railway.app**.

Project di direktori ini sudah dipersiapkan dan dioptimalkan secara otomatis untuk Railway:
- ✅ Telah dibuat file `nixpacks.toml` (konfigurasi build server PHP 8.3 + Nginx).
- ✅ Telah dibuat file `.env.railway.example` (template variabel environment tinggal *copy-paste*).
- ✅ `DatabaseSeeder.php` telah diperbarui dengan seluruh 7 Section, 24 Kartu Statistik, Data Source, dan Akun Administrator.

---

## 📋 DAFTAR ISI
1. [Langkah 1: Upload Project ke GitHub](#langkah-1-upload-project-ke-github)
2. [Langkah 2: Buat Project & Database MySQL di Railway](#langkah-2-buat-project--database-mysql-di-railway)
3. [Langkah 3: Deploy Service Laravel dari GitHub](#langkah-3-deploy-service-laravel-dari-github)
4. [Langkah 4: Masukkan Environment Variables (.env)](#langkah-4-masukkan-environment-variables-env)
5. [Langkah 5: Generate Domain Publik](#langkah-5-generate-domain-publik)
6. [Langkah 6: Verifikasi & Login Admin](#langkah-6-verifikasi--login-admin)
7. [Tips Tambahan & Pemecahan Masalah](#tips-tambahan--pemecahan-masalah)

---

## LANGKAH 1: Upload Project ke GitHub

Railway melakukan deployment otomatis membaca repository GitHub Anda.

### Opsi A (Paling Mudah untuk Windows — Menggunakan GitHub Desktop):
1. Unduh dan install aplikasi **GitHub Desktop**: [https://desktop.github.com/](https://desktop.github.com/)
2. Buka GitHub Desktop dan login dengan akun GitHub Anda.
3. Klik menu **File** ➔ **Add Local Repository...** (atau tekan `Ctrl + O`).
4. Pilih folder:
   `c:\kevin\Magang\Web 1\upt-manado-laravel`
5. Jika muncul pesan *"This directory does not appear to be a Git repository"*, klik tombol **create a repository**.
6. Klik tombol **Publish repository** di bagian atas untuk mengunggahnya ke akun GitHub Anda (bisa dicentang *Keep this code private* atau *Public*).

### Opsi B (Menggunakan Git Command Line):
1. Unduh dan install **Git for Windows**: [https://git-scm.com/download/win](https://git-scm.com/download/win)
2. Buka terminal PowerShell di folder `upt-manado-laravel`:
   ```powershell
   git init
   git add .
   git commit -m "Initial commit for Railway deployment"
   git branch -M main
   git remote add origin https://github.com/USERNAME-ANDA/upt-manado-laravel.git
   git push -u origin main
   ```

---

## LANGKAH 2: Buat Project & Database MySQL di Railway

1. Buka [Railway.app](https://railway.app) di browser, lalu klik **Login** menggunakan akun **GitHub** Anda.
2. Di Dashboard Railway, klik tombol **`+ New Project`**.
3. Pertama, kita siapkan databasenya terlebih dahulu:
   - Pilih opsi **`Provision MySQL`**.
   - Tunggu sekitar 5 detik hingga kotak service database **MySQL** muncul di layar.

---

## LANGKAH 3: Deploy Service Laravel dari GitHub

1. Masih di halaman project Railway yang sama, klik tombol **`+ Create`** (atau `+ New`) di canvas.
2. Pilih opsi **`GitHub Repo`**.
3. Pilih repository `upt-manado-laravel` yang sudah Anda upload pada Langkah 1.
4. Railway akan membuat service baru dan langsung mendeteksi konfigurasi `nixpacks.toml` yang sudah kita buat.

---

## LANGKAH 4: Masukkan Environment Variables (.env)

Agar Laravel terhubung ke database MySQL Railway dan dapat berjalan dalam mode produksi:

1. Klik pada kotak service aplikasi Laravel (`upt-manado-laravel`) di canvas Railway.
2. Masuk ke tab **Variables** di bagian atas.
3. Klik tombol **`RAW Editor`** di pojok kanan atas tab Variables.
4. Buka file `.env.railway.example` di project ini, lalu salin (copy) seluruh isinya:

```env
APP_NAME="DASHBOARD KINERJA PLN UPT MANADO"
APP_ENV=production
APP_KEY=base64:7frZdTNLVZqi2OLxS7A144fjOIBXLo21WxTxvuqPRRo=
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stderr
LOG_LEVEL=info

NIXPACKS_PHP_ROOT_DIR=/public
```

5. Tempel (paste) ke dalam **RAW Editor** di Railway, lalu klik **Save / Update**.
6. Railway akan otomatis memulai build ulang (*re-deploy*) dengan konfigurasi baru.

---

## LANGKAH 5: Generate Domain Publik

1. Masih di service `upt-manado-laravel`, klik tab **Settings**.
2. Scroll ke bawah ke bagian **Networking**.
3. Di bawah kolom *Public Networking*, klik tombol **`Generate Domain`**.
4. Railway akan membuatkan URL gratis berakhiran `.up.railway.app` (contoh: `upt-manado-laravel-production-xxxx.up.railway.app`).

---

## LANGKAH 6: Verifikasi & Login Admin

1. Buka domain publik yang didapatkan di browser (contoh: `https://upt-manado-xxxx.up.railway.app`).
2. Dashboard publik PLN UPT Manado akan langsung tampil lengkap dengan seluruh 7 section dan peta Leaflet.
3. Untuk masuk ke Admin Panel:
   - Akses: `https://upt-manado-xxxx.up.railway.app/login`
   - Email: **`admin@pln.co.id`**
   - Password: **`admin123`**
4. Buka menu **Data Master ➔ Kartu Statistik & Metrik**:
   - Seluruh 24 kartu statistik telah terdaftar.
   - Anda dapat mencoba tombol **⚡ 2-Arah** untuk memastikan penulisan data berjalan lancar.

---

## 💡 TIPS TAMBAHAN & PEMECAHAN MASALAH

- **Bagaimana jika data tabel/admin belum terisi?**
  Masuk ke tab **Terminal** pada service `upt-manado-laravel` di Railway, lalu ketik:
  ```bash
  php artisan migrate:fresh --seed --force
  ```
- **Bagaimana cara update website jika ada perubahan kode di komputer lokal?**
  Anda cukup melakukan `commit` dan `push` ke GitHub (bisa lewat GitHub Desktop). Railway akan otomatis mendeteksi perubahan tersebut dan meng-update website secara langsung dalam waktu ~1 menit tanpa downtime.
- **Apakah perlu instalasi composer/node di server?**
  Tidak perlu. Nixpacks Railway sudah mengurus semua dependensi di cloud saat proses build berlangsung.
