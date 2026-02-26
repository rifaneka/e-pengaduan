# E-Pengaduan - Sistem Pengaduan Masyarakat

Website sistem pengaduan masyarakat berbasis web menggunakan PHP dan MySQL.

## Fitur Utama

### User (Masyarakat)
- Registrasi dan Login
- Membuat pengaduan baru
- Melihat riwayat pengaduan
- Melihat status pengaduan (Pending/Proses/Selesai)
- Menghapus pengaduan
- Melihat profil
- FAQ/Bantuan

### Admin
- Login sebagai admin
- Dashboard dengan statistik
- Kelola pengaduan (update status, hapus, cetak)
- Kelola user
- Tambah dan kelola berita
- Cetak laporan pengaduan

## Instalasi

### Persyaratan
- PHP 7.4 atau lebih tinggi
- MySQL/MariaDB
- Web server (Apache/Nginx)
- XAMPP atau WAMP

### Langkah Instalasi (MUDAH - Tanpa phpMyAdmin!)

1. **Download dan Ekstrak**
   - Download file `e-pengaduan.zip`
   - Ekstrak ke folder:
     - XAMPP: `C:\xampp\htdocs\`
     - WAMP: `C:\wamp\www\`

2. **Nyalakan Server**
   - Buka XAMPP Control Panel
   - Start Apache dan MySQL

3. **Instalasi Database Otomatis**
   - Buka browser
   - Ketik: `http://localhost/e-pengaduan/install.php`
   - Tunggu sampai muncul "INSTALASI SELESAI!"
   - Klik tombol "LOGIN SEKARANG"

4. **Keamanan**
   - Setelah berhasil login, HAPUS file `install.php`

**ALTERNATIF** jika cara otomatis gagal:
- Buka phpMyAdmin
- Import file `database.sql`
- Atau ikuti panduan di file `INSTALASI.txt`

## Login Default

### Admin
- Email: `admin@epengaduan.com`
- Password: `admin123`

### User Demo
- Email: `dimastraning@gmail.com`
- Password: `dimas123`

## Struktur Folder

```
e-pengaduan/
├── admin/              # Halaman admin
│   ├── dashboard.php
│   ├── berita.php
│   ├── kelola_pengaduan.php
│   ├── kelola_user.php
│   └── cetak_pengaduan.php
├── user/               # Halaman user
│   ├── dashboard.php
│   ├── pengaduan.php
│   ├── riwayat.php
│   ├── profil.php
│   └── bantuan.php
├── css/                # File CSS
│   └── style.css
├── uploads/            # Folder upload foto pengaduan
├── berita/             # Folder upload foto berita
├── config.php          # Konfigurasi database
├── index.php           # Halaman login
├── register.php        # Halaman registrasi
├── logout.php          # Proses logout
└── database.sql        # File SQL database

```

## Cara Penggunaan

### Untuk Masyarakat (User)

1. **Registrasi**
   - Klik "Registrasi" di halaman login
   - Isi data lengkap (NIK, Nama, Email, Password, Alamat)
   - Klik tombol "Registrasi"

2. **Login**
   - Masukkan email atau NIK
   - Masukkan password
   - Klik "Login"

3. **Membuat Pengaduan**
   - Klik menu "Pengaduan"
   - Isi formulir pengaduan
   - Upload foto bukti (opsional)
   - Klik "Submit"

4. **Melihat Riwayat**
   - Klik menu "Riwayat"
   - Lihat status pengaduan Anda
   - Hapus pengaduan jika diperlukan

### Untuk Admin

1. **Login Admin**
   - Login dengan akun admin
   - Akses dashboard admin

2. **Kelola Pengaduan**
   - Klik menu "Kelola Pengaduan"
   - Update status pengaduan (Pending → Proses → Selesai)
   - Cetak laporan pengaduan
   - Hapus pengaduan jika perlu

3. **Kelola User**
   - Klik menu "Kelola User"
   - Lihat daftar user terdaftar
   - Hapus user jika perlu

4. **Tambah Berita**
   - Klik menu "Tambah Berita"
   - Isi formulir berita
   - Upload foto berita
   - Klik "Submit"

## Fitur Keamanan

- Password di-hash menggunakan MD5
- Proteksi SQL Injection dengan `mysqli_real_escape_string`
- Session management untuk autentikasi
- Validasi role (user/admin)
- Upload file hanya menerima format gambar

## Teknologi yang Digunakan

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Design**: Custom CSS dengan warna biru (#3B82F6)

## Catatan Penting

1. Pastikan folder `uploads/` dan `berita/` memiliki permission write (777)
2. Ganti password default admin setelah instalasi
3. Untuk production, gunakan HTTPS dan hash password yang lebih aman (bcrypt)
4. Backup database secara berkala

## Troubleshooting

### Error koneksi database
- Pastikan MySQL sudah running
- Cek konfigurasi di `config.php`
- Pastikan database sudah dibuat

### Upload foto tidak berfungsi
- Cek permission folder `uploads/` dan `berita/`
- Pastikan php.ini mengizinkan file upload
- Cek ukuran maksimal upload di php.ini

### Session error
- Pastikan session_start() tidak error
- Cek permission folder session di server

## Developer

Dibuat berdasarkan desain UI/UX dari PDF E-Pengaduan

## Lisensi

Free to use for educational purposes

---
Untuk pertanyaan atau bantuan, hubungi administrator sistem.
