# JPRPRO - Jasa Pembersihan Rumah Profesional

## Deskripsi
JPRPRO adalah aplikasi web untuk layanan jasa pembersihan rumah profesional. Aplikasi ini menyediakan platform bagi pengguna untuk memesan layanan pembersihan rumah dengan mudah dan efisien. Dengan antarmuka yang intuitif dan sistem manajemen yang komprehensif, JPRPRO memudahkan pengguna dalam memesan layanan dan memantau status pesanan mereka.

## Fitur

### Untuk Pengguna
- Pemesanan layanan pembersihan secara online
- Pilihan berbagai jenis layanan pembersihan
- Sistem tracking status pesanan
- Halaman informasi tentang perusahaan
- Antarmuka yang responsif dan mudah digunakan

### Untuk Admin
- Dashboard admin untuk manajemen pesanan
- Pengelolaan layanan (tambah, edit, hapus)
- Manajemen status pesanan
- Pengaturan informasi perusahaan
- Sistem autentikasi yang aman

## Teknologi yang Digunakan
- PHP 7.4+
- MySQL/MariaDB
- Bootstrap 5
- HTML5 & CSS3
- JavaScript
- Bootstrap Icons

## Persyaratan Sistem
- Web Server (Apache/Nginx)
- PHP 7.4 atau lebih tinggi
- MySQL/MariaDB
- Web Browser modern

## Instalasi
1. Clone repositori ini ke direktori web server Anda
2. Buat database baru di MySQL/MariaDB
3. Import file `database/jprpro_db.sql` ke database yang telah dibuat
4. Salin file `config/database.example.php` menjadi `config/database.php`
5. Sesuaikan konfigurasi database di file `config/database.php`
6. Pastikan folder `uploads` memiliki permission yang sesuai (755)
7. Akses aplikasi melalui web browser

## Struktur Direktori
```
├── admin/           # File-file untuk panel admin
├── assets/          # Asset statis (CSS, JS, gambar)
├── config/          # File konfigurasi
├── database/        # File SQL database
├── includes/        # File-file pendukung
├── middleware/      # Middleware aplikasi
├── uploads/         # Folder untuk upload gambar
└── README.md        # Dokumentasi
```

## Penggunaan
### Akses Admin Panel
1. Buka `http://your-domain/admin/login.php`
2. Login menggunakan kredensial default:
   - Username: admin
   - Password: password
3. Segera ubah password default setelah login pertama kali

### Mengelola Layanan
1. Login ke panel admin
2. Akses menu "Kelola Layanan"
3. Tambah, edit, atau hapus layanan sesuai kebutuhan

### Mengelola Pesanan
1. Login ke panel admin
2. Akses menu "Kelola Pesanan"
3. Lihat detail pesanan dan update status