<?php
require_once '../config.php';

// Cek login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Hapus pengaduan
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $delete_query = "DELETE FROM pengaduan WHERE id = $id AND user_id = $user_id";
    mysqli_query($conn, $delete_query);
    header('Location: riwayat.php');
    exit();
}

// Ambil riwayat pengaduan
$pengaduan_query = "SELECT * FROM pengaduan WHERE user_id = $user_id ORDER BY created_at DESC";
$pengaduan_result = mysqli_query($conn, $pengaduan_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan - E-Pengaduan</title>
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
                <li><a href="pengaduan.php">📋 Pengaduan</a></li>
                <li><a href="riwayat.php" class="active">📄 Riwayat</a></li>
                <li><a href="bantuan.php">❓ Bantuan</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Riwayat Pengaduan Pengguna</h2>
                
                <?php if (mysqli_num_rows($pengaduan_result) > 0): ?>
                    <?php while($pengaduan = mysqli_fetch_assoc($pengaduan_result)): ?>
                    <div style="background: #F3F4F6; padding: 20px; border-radius: 12px; margin-bottom: 15px; display: flex; gap: 20px; align-items: center;">
                        <?php if ($pengaduan['foto']): ?>
                        <img src="../uploads/<?php echo $pengaduan['foto']; ?>" 
                             alt="Foto pengaduan" 
                             style="width: 120px; height: 90px; object-fit: cover; border-radius: 8px;">
                        <?php endif; ?>
                        
                        <div style="flex: 1;">
                            <div style="color: #6B7280; font-size: 14px;">
                                <strong>Id Pengaduan:</strong> <?php echo $pengaduan['id']; ?>
                            </div>
                            <div style="color: #6B7280; font-size: 14px;">
                                <strong>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($pengaduan['tanggal_pengaduan'])); ?>
                            </div>
                            <div style="color: #6B7280; font-size: 14px;">
                                <strong>Kategori:</strong> <?php echo $pengaduan['kategori']; ?>
                            </div>
                            <div style="color: #6B7280; font-size: 14px;">
                                <strong>Deskripsi:</strong> <?php echo $pengaduan['deskripsi']; ?>
                            </div>
                        </div>
                        
                        <div style="text-align: center;">
                            <span class="badge badge-<?php echo strtolower($pengaduan['status']); ?>">
                                <?php echo $pengaduan['status']; ?>
                            </span>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-warning" style="padding: 6px 15px; font-size: 12px;">Detail</button>
                                <a href="?hapus=<?php echo $pengaduan['id']; ?>" 
                                   class="btn btn-danger" 
                                   style="padding: 6px 15px; font-size: 12px; text-decoration: none;"
                                   onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-data">Belum ada pengaduan</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
