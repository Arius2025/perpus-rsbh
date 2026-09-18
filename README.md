<p align="center">
  <img src="public/images/logo.png" width="96" alt="Logo RS TK. III Baladhika Husada">
</p>

<h1 align="center">PustakaDigital</h1>

<p align="center">
  <strong>Sistem Perpustakaan & Repositori Pengetahuan Digital</strong><br>
  Rumah Sakit Tingkat III Baladhika Husada Jember
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-0f766e?style=for-the-badge" alt="Status">
</p>

---

## Ringkasan Proyek

**PustakaDigital** adalah platform repositori literatur dan manajemen perpustakaan digital terintegrasi yang dirancang untuk mendukung penelitian, pelayanan medis, administrasi rumah sakit, dan pembelajaran berkelanjutan bagi seluruh tenaga kesehatan di **RS TK. III Baladhika Husada (RS DKT) Jember**.

Aplikasi ini dibangun dengan mengutamakan kecepatan akses, tata letak editorial yang rapi, aksesibilitas tingkat tinggi (WCAG AA), dan kemudahan operasional bagi pustakawan.

---

## Fitur Utama

### 1. Antarmuka Publik & Pembaca
- **Katalog Terstruktur**: Eksplorasi koleksi berdasarkan kategori (Kesehatan, SIMRS, Rekam Medis, Kebijakan, dll.) lengkap dengan jumlah dokumen per kategori.
- **Pencarian Cepat & Filter Topik**: Penelusuran instan berdasarkan judul atau nama penulis, dilengkapi pintasan topik terpopuler (*Rekam medis*, *SIMRS*, *BPJS*).
- **Pengurutan Fleksibel**: Pilihan urutan dokumen berdasarkan koleksi terbaru, judul alfabetis (A-Z), atau nama penulis.
- **Penanganan Sampul Otomatis (*Default Cover Fallback*)**: Jika buku belum memiliki gambar sampul, sistem otomatis merender sampul vektor (`default-cover.svg`) beresolusi tinggi tanpa gambar rusak (*broken image*).
- **Pembaca & Pengunduh PDF**: Dukungan pembacaan dokumen langsung di peramban (*inline reader*) atau unduhan berkas fisik, serta tautan eksternal ke repositori induk.
- **Tema Terang & Gelap (*Synchronized Dark Mode*)**: Beralih tema secara mulus yang tersinkronisasi otomatis dengan preferensi sistem operasi dan penyimpanan lokal peramban.
- **Ramah Perangkat Bergerak (*Mobile First*)**: Tata letak adaptif yang nyaman digunakan di ponsel cerdas dengan bilah navigasi bawah (*bottom bar*) dan target sentuh ramah jempol (minimal 44px).

### 2. Panel Pengelola (Admin Dashboard)
- **Ringkasan Metrik Institusional**: Pemantauan jumlah koleksi aktif, total akses/unduhan, pembagian jenis dokumen (PDF lokal vs tautan eksternal).
- **Manajemen Koleksi Buku**: Tambah, edit metadata (judul, penulis, penerbit, sinopsis, kategori), unggah berkas cover dan PDF, serta fitur visibilitas (tampilkan/sembunyikan).
- **Manajemen Kategori**: Pengelolaan taksonomi koleksi dengan pengaktifan status kategori.
- **Manajemen Akun Pengelola**: Pengelolaan hak akses staf perpustakaan dengan opsi aktivasi/nonaktivasi akun.
- **Keamanan**: Autentikasi berbasis session dengan pembatasan laju percobaan masuk (*rate limiting / throttling*).

---

## Standar Desain & Aksesibilitas

Antarmuka PustakaDigital mematuhi prinsip desain bebas *AI slop*:
- **Tipografi**: Menggunakan jenis huruf *Jakarta / Plus Jakarta Sans* yang dirancang untuk keterbacaan teks editorial panjang.
- **Kontras Warna**: Memenuhi standar kontras minimum WCAG AAA (14.2:1 untuk teks normal) pada tema terang dan gelap.
- **Aksesibilitas Penuh**: Navigasi keyboard terstruktur dengan tautan loncat (*skip to main content*) dan indikator fokus visual yang tegas (`:focus-visible`).
- **Resiliensi Data**: Dilengkapi tampilan status kosong (*empty state*) yang informatif serta pesan umpan balik interaktif.

---

## Prasyarat Sistem

Sebelum memasang aplikasi, pastikan server atau komputer pengembangan Anda memenuhi kebutuhan berikut:
- **PHP** >= 8.2 (dengan ekstensi: `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `PDO_MySQL`, `Tokenizer`, `XML`)
- **Web Server**: Apache / Nginx (atau lingkungan lokal seperti MAMP / XAMPP / Laravel Herd)
- **Database**: MySQL 5.7+ atau MySQL 8.0+ / MariaDB 10.3+
- **Composer** >= 2.0
- **Node.js** & **NPM** (opsional untuk *build tool* frontend)

---

## Panduan Instalasi Lokal

### 1. Klon Repositori
```bash
git clone https://github.com/Arius2025/perpus-rsbh.git
cd perpus-rsbh
```

### 2. Pasang Dependensi Composer
```bash
composer install --optimize-autoloader --no-dev
```
*(Gunakan `composer install` jika dalam mode pengembangan lokal).*

### 3. Konfigurasi Lingkungan (.env)
Salin berkas template lingkungan dan buat kunci aplikasi baru:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi basis data pada berkas `.env`:
```env
APP_NAME="PustakaDigital"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=root
```

### 4. Jalankan Migrasi Basis Data
```bash
php artisan migrate --seed
```

### 5. Buat Tautan Simbolik Storage
Pastikan direktori unggahan dapat diakses secara publik:
```bash
php artisan storage:link
```

### 6. Jalankan Server Pengembangan
```bash
php artisan serve
```
Aplikasi dapat diakses melalui peramban di: `http://localhost:8000`

---

## Struktur Direktori Utama

```text
perpus-rsbh/
├── app/
│   ├── Http/Controllers/      # Pengontrol logika aplikasi (Book, Category, Auth, User)
│   └── Models/                # Model Eloquent (Book, Category, User)
├── config/                    # Konfigurasi aplikasi & database
├── database/
│   ├── migrations/            # Struktur tabel database
│   └── seeders/               # Data awal / dummy pengguna dan kategori
├── public/
│   ├── fonts/                 # Berkas font tipografi (Jakarta.ttf)
│   ├── images/                # Logo resmi dan vektor sampul default (default-cover.svg)
│   └── uploads/books/         # Lokasi penyimpanan berkas sampul dan PDF
├── resources/
│   └── views/                 # Blade templates
│       ├── admin/             # Panel pengelola (Dashboard, Buku, Kategori, Akun)
│       ├── auth/              # Halaman autentikasi login pengelola
│       ├── home.blade.php     # Halaman utama katalog pustaka publik
│       ├── show.blade.php     # Halaman detail dan pembaca buku
│       └── layout.blade.php   # Kerangka dasar induk antarmuka
└── routes/
    └── web.php                # Rute publik, autentikasi, dan pengelola
```

---

## Hak Cipta & Lisensi

Perangkat lunak ini dikembangkan untuk kebutuhan internal dan pelayanan **Rumah Sakit Tingkat III Baladhika Husada Jember**. 

Hak cipta konten, logo, dan dokumen milik **RS TK. III Baladhika Husada**. Kerangka kerja dasar menggunakan [Laravel](https://laravel.com) di bawah lisensi [MIT License](LICENSE).
