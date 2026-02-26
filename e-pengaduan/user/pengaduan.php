<?php
require_once '../config.php';

// Cek login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Ambil data user
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

if (isset($_POST['submit'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Upload foto
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto = time() . '_' . $filename;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $foto);
        }
    }
    
    $query = "INSERT INTO pengaduan (user_id, nama_lengkap, kategori, tanggal_pengaduan, alamat_pengaduan, deskripsi, foto, status) 
              VALUES ($user_id, '$nama_lengkap', '$kategori', '$tanggal', '$alamat', '$deskripsi', '$foto', 'Pending')";
    
    if (mysqli_query($conn, $query)) {
        $success = 'Pengaduan berhasil dikirim!';
    } else {
        $error = 'Pengaduan gagal dikirim!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan - E-Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <div class="header-container">
            <div class="logo">E-Pengaduan</div>
            <div class="header-icons">
                <a href="profil.php">👤</a>
                <a href="#">✉️</a>
                <a href="#">🔔</a>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="dashboard.php">🏠 Dashboard</a></li>
                <li><a href="pengaduan.php" class="active">📋 Pengaduan</a></li>
                <li><a href="riwayat.php">📄 Riwayat</a></li>
                <li><a href="survey.php">⭐ Survey</a></li>
                <li><a href="bantuan.php">❓ Bantuan</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Form Pengaduan Masyarakat</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" 
                               value="<?php echo $user_data['nama']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Jalan Rusak">Jalan Rusak</option>
                            <option value="Fasilitas Umum">Fasilitas Umum</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Pengaduan</label>
                        <input type="date" name="tanggal" class="form-control" 
                               value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Alamat Pengaduan</label>
                        <input type="text" name="alamat" class="form-control" 
                               placeholder="Jl.Pulang" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi Pengaduan</label>
                        <textarea name="deskripsi" class="form-control" 
                                  placeholder="Ini Budi" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Unggah Bukti Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
