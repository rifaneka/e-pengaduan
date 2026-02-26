-- Database E-Pengaduan
CREATE DATABASE IF NOT EXISTS e_pengaduan;
USE e_pengaduan;

-- Tabel User
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pengaduan
CREATE TABLE IF NOT EXISTS pengaduan (
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
);

-- Tabel Berita
CREATE TABLE IF NOT EXISTS berita (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tanggal_publikasi DATE NOT NULL,
    deskripsi TEXT NOT NULL,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Survey Kepuasan User
CREATE TABLE IF NOT EXISTS survey (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    rating ENUM('Sangat Puas', 'Puas', 'Cukup', 'Tidak Puas') NOT NULL,
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id)
);

-- Insert Admin Default
INSERT INTO users (nik, nama, email, password, alamat, role) 
VALUES ('0000000000000001', 'Administrator', 'adminpengaduan@gmail.com', MD5('admin123'), 'Ponorogo', 'admin');

-- Insert User Demo
INSERT INTO users (nik, nama, email, password, alamat, role) 
VALUES ('09876567897898', 'Dimas Ainur Pangestu', 'dimastraning@gmail.com', MD5('12345678'), 'Jl. Pulang', 'user');
