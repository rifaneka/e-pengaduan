<?php
require_once 'config.php';

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // Cek apakah NIK atau email sudah ada
    $check = "SELECT * FROM users WHERE nik = '$nik' OR email = '$email'";
    $check_result = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = 'NIK atau Email sudah terdaftar!';
    } else {
        $query = "INSERT INTO users (nik, nama, email, password, alamat, role) 
                  VALUES ('$nik', '$nama', '$email', '$password', '$alamat', 'user')";
        
        if (mysqli_query($conn, $query)) {
            $success = 'Registrasi berhasil! Silakan login.';
        } else {
            $error = 'Registrasi gagal! Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - E-Pengaduan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2>Registrasi Pengguna</h2>
            <p class="subtitle">Isi formulir dibawah ini</p>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="text" name="nik" class="form-control" placeholder="Masukan Nomor NIK/KTP" required>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Lengkap." required>
                <input type="email" name="email" class="form-control" placeholder="Masukan Email" required>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password...." required>
                <input type="text" name="alamat" class="form-control" placeholder="Masukan Alamat Lengkap" required>
                <button type="submit" name="register" class="btn btn-primary">Registrasi</button>
            </form>
            
            <div class="auth-footer">
                Sudah punya akun? <a href="index.php">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
