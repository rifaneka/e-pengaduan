<?php
// File Installer Database E-Pengaduan
// Jalankan file ini sekali untuk membuat database dan tabel

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi Database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'e_pengaduan';

echo "<h2>Installer Database E-Pengaduan</h2>";
echo "<hr>";

// Step 1: Koneksi ke MySQL tanpa database
$conn = mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    die("<p style='color:red;'>❌ Koneksi ke MySQL gagal: " . mysqli_connect_error() . "</p>
         <p>Pastikan MySQL sudah running dan username/password benar.</p>");
}

echo "<p style='color:green;'>✅ Koneksi ke MySQL berhasil</p>";

// Step 2: Buat database
$sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8 COLLATE utf8_general_ci";
if (mysqli_query($conn, $sql)) {
    echo "<p style='color:green;'>✅ Database '$db_name' berhasil dibuat</p>";
} else {
    echo "<p style='color:red;'>❌ Error membuat database: " . mysqli_error($conn) . "</p>";
}

// Step 3: Pilih database
mysqli_select_db($conn, $db_name);

// Step 4: Buat tabel users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql_users)) {
    echo "<p style='color:green;'>✅ Tabel 'users' berhasil dibuat</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Tabel 'users': " . mysqli_error($conn) . "</p>";
}

// Step 5: Buat tabel pengaduan
$sql_pengaduan = "CREATE TABLE IF NOT EXISTS pengaduan (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tanggal_pengaduan DATE NOT NULL,
    alamat_pengaduan VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    foto VARCHAR(255),
    status ENUM('Pending', 'Proses', 'Selesai') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql_pengaduan)) {
    echo "<p style='color:green;'>✅ Tabel 'pengaduan' berhasil dibuat</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Tabel 'pengaduan': " . mysqli_error($conn) . "</p>";
}

// Step 6: Buat tabel berita
$sql_berita = "CREATE TABLE IF NOT EXISTS berita (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tanggal_publikasi DATE NOT NULL,
    deskripsi TEXT NOT NULL,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql_berita)) {
    echo "<p style='color:green;'>✅ Tabel 'berita' berhasil dibuat</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Tabel 'berita': " . mysqli_error($conn) . "</p>";
}

// Step 6b: Buat tabel survey
$sql_survey = "CREATE TABLE IF NOT EXISTS survey (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    rating ENUM('Sangat Puas', 'Puas', 'Cukup', 'Tidak Puas') NOT NULL,
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($conn, $sql_survey)) {
    echo "<p style='color:green;'>✅ Tabel 'survey' berhasil dibuat</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Tabel 'survey': " . mysqli_error($conn) . "</p>";
}

// Step 7: Insert data admin default
$check_admin = "SELECT * FROM users WHERE email = 'admin@epengaduan.com'";
$result = mysqli_query($conn, $check_admin);

if (mysqli_num_rows($result) == 0) {
    $sql_admin = "INSERT INTO users (nik, nama, email, password, alamat, role) 
                  VALUES ('0000000000000001', 'Administrator', 'admin@epengaduan.com', MD5('admin123'), 'Semarang', 'admin')";
    
    if (mysqli_query($conn, $sql_admin)) {
        echo "<p style='color:green;'>✅ Admin default berhasil dibuat</p>";
        echo "<p><strong>Login Admin:</strong><br>
              Email: admin@epengaduan.com<br>
              Password: admin123</p>";
    } else {
        echo "<p style='color:red;'>❌ Error membuat admin: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:blue;'>ℹ️ Admin sudah ada, skip insert</p>";
}

// Step 8: Insert data user demo
$check_user = "SELECT * FROM users WHERE email = 'dimastraning@gmail.com'";
$result_user = mysqli_query($conn, $check_user);

if (mysqli_num_rows($result_user) == 0) {
    $sql_user = "INSERT INTO users (nik, nama, email, password, alamat, role) 
                 VALUES ('09876567897898', 'Dimas Ainur Pangestu', 'dimastraning@gmail.com', MD5('dimas123'), 'Jl. Pulang', 'user')";
    
    if (mysqli_query($conn, $sql_user)) {
        echo "<p style='color:green;'>✅ User demo berhasil dibuat</p>";
        echo "<p><strong>Login User Demo:</strong><br>
              Email: dimastraning@gmail.com<br>
              Password: dimas123</p>";
    } else {
        echo "<p style='color:red;'>❌ Error membuat user demo: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:blue;'>ℹ️ User demo sudah ada, skip insert</p>";
}

// Step 9: Cek folder upload
$folders = ['uploads', 'berita'];
foreach ($folders as $folder) {
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        echo "<p style='color:green;'>✅ Folder '$folder' berhasil dibuat</p>";
    } else {
        echo "<p style='color:blue;'>ℹ️ Folder '$folder' sudah ada</p>";
    }
}

mysqli_close($conn);

echo "<hr>";
echo "<h3 style='color:green;'>🎉 INSTALASI SELESAI!</h3>";
echo "<p>Database dan semua tabel berhasil dibuat.</p>";
echo "<p><a href='index.php' style='background:#3B82F6; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>LOGIN SEKARANG →</a></p>";
echo "<hr>";
echo "<p style='color:red;'><strong>PENTING:</strong> Hapus file install.php ini setelah instalasi selesai untuk keamanan!</p>";
?>
