# 🌐 Web Desa Balapulang Wetan

![Status](https://img.shields.io/badge/Status-Development-yellow)
![License](https://img.shields.io/badge/License-MIT-blue.svg)

Situs web resmi **Desa Balapulang Wetan**, Kecamatan Balapulang, Kabupaten Tegal.  
Proyek ini dikembangkan untuk mendukung tata kelola pemerintahan desa yang transparan, akuntabel, dan berbasis digital.

---

## 📋 Daftar Isi
- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Tutorial Instalasi di Local](#-tutorial-instalasi-di-local)
- [Struktur Folder](#-struktur-folder)
- [Kontribusi](#-kontribusi)
- [Kontak & Informasi](#-kontak--informasi)

---

## 📖 Tentang Proyek
Website ini berfungsi sebagai media informasi dan layanan publik antara Pemerintah Desa dan masyarakat.  
Fokus pengembangan mencakup keterbukaan informasi, kemudahan layanan administrasi, serta promosi potensi desa secara daring.

---

## ✨ Fitur Utama
- **Profil Desa**  
  Informasi wilayah, sejarah, visi misi, dan struktur organisasi pemerintahan desa.

- **Transparansi Anggaran (APBDes)**  
  Publikasi data anggaran dan realisasi dalam bentuk tabel dan visualisasi grafik.

- **Layanan Mandiri Warga**  
  Pengajuan surat keterangan (Domisili, Kelahiran, Usaha, dan lainnya) secara online.

- **Portal Berita & Pengumuman**  
  Informasi kegiatan desa, agenda, dan pengumuman resmi.

- **Katalog UMKM Desa**  
  Etalase produk unggulan UMKM lokal untuk mendukung ekonomi masyarakat.

- **Dashboard Admin**  
  Panel pengelolaan konten dan data oleh perangkat desa.

---

## 🛠 Teknologi
Teknologi yang digunakan dalam pengembangan aplikasi:
- **Frontend:** Bootstrap / Tailwind CSS
- **Backend:** Laravel
- **Database:** MySQL
- **Tools:** Git, Composer, NPM

---

## ⚙️ Prasyarat
Pastikan lingkungan pengembangan telah memenuhi persyaratan berikut:
- PHP >= 8.x
- Composer
- Node.js & NPM
- Web Server (Apache / Nginx / XAMPP)

---

## 🚀 Instalasi

### Clone Repository
```bash
git clone https://github.com/Ay-devlover/web-desa-balapulang-wetan.git
cd web-desa-balapulang-wetan
```

### Instal Dependensi
```bash
composer install
npm install
```

### Konfigurasi Environment
```bash
cp .env.example .env
```

> **Catatan**: Sesuaikan konfigurasi database pada file `.env` sesuai dengan setup lokal Anda.

### Generate Key & Migrasi Database
```bash
php artisan key:generate
php artisan migrate --seed
```

### Jalankan Aplikasi
```bash
php artisan serve
```

Aplikasi dapat diakses melalui: `http://localhost:8000`

---

## 📝 Tutorial Instalasi di Local

### 1. Persiapan Database

Pastikan MySQL sudah berjalan. Buat database baru dengan salah satu cara berikut:

**Menggunakan Command Line:**
```bash
mysql -u root -p
```

Kemudian di dalam MySQL shell, jalankan:
```sql
CREATE DATABASE desa_balapulang_wetan;
EXIT;
```

**Atau menggunakan phpMyAdmin:**
- Buka http://localhost/phpmyadmin
- Klik "New" untuk membuat database baru
- Nama database: `desa_balapulang_wetan`

### 2. Konfigurasi File .env

Edit file `.env` yang sudah dicopy dari `.env.example`:

```env
APP_NAME="Desa Balapulang Wetan"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_balapulang_wetan
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` sesuai konfigurasi MySQL lokal Anda.

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Jalankan Migration & Seeding

Sudah dijelaskan di bagian Instalasi dengan command:
```bash
php artisan migrate --seed
```

### 5. Build Assets Frontend

Untuk development, gunakan watch mode yang akan otomatis mengcompile saat ada perubahan:
```bash
npm run dev
```

Untuk production, gunakan optimized build:
```bash
npm run build
```

### 6. Mulai Development Server

Untuk memulai development, buka **2 terminal terpisah**:

**Terminal 1** - Jalankan Laravel server:
```bash
php artisan serve
```

**Terminal 2** - Jalankan file watcher untuk CSS/JS:
```bash
npm run dev
```

> **Catatan**: Terminal 2 bersifat optional namun sangat direkomendasikan agar perubahan CSS/JS langsung ter-compile tanpa perlu manual build.

### 7. Akses Aplikasi

Aplikasi sudah siap digunakan:

| Halaman | URL |
|---------|-----|
| **Website** | http://localhost:8000 |
| **Admin Panel** | http://localhost:8000/admin |

**Login Akun Default:**
Gunakan akun yang telah dibuat melalui seeding database atau buat akun baru dengan command:
```bash
php artisan make:user
```

### ❌ Troubleshooting

| Error | Solusi |
|-------|--------|
| **SQLSTATE - Database connection refused** | Pastikan MySQL service sudah running. Check konfigurasi DB di `.env` sesuai dengan MySQL lokal Anda. |
| **npm command not found** | Install Node.js dari https://nodejs.org/ |
| **composer command not found** | Install Composer dari https://getcomposer.org/ |
| **Storage permission denied** | Jalankan `php artisan storage:link`. Pastikan folder `storage/` dan `bootstrap/cache/` memiliki permission write. |

---

## 📂 Struktur Folder

```
├── app/            # Logika aplikasi
├── public/         # Aset publik (CSS, JS, Images)
├── resources/      # View dan template
├── routes/         # Routing aplikasi
└── database/       # Migrasi dan seeder
```

---

## 🤝 Kontribusi

Kontribusi terhadap proyek ini sangat terbuka. Berikut langkah-langkah untuk berkontribusi:

1. Fork repository ini
2. Buat branch fitur: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m "Menambahkan fitur X"`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Ajukan Pull Request

## 📞 Kontak & Informasi

**Pemerintah Desa Balapulang Wetan**  
Kecamatan Balapulang, Kabupaten Tegal, Jawa Tengah

- 📧 Email: admin@balapulangwetan.desa.id
- 🌐 Website: https://www.balapulangwetan.desa.id

---

Developed with ❤️ for Desa Balapulang Wetan

