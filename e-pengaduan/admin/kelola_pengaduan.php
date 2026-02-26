<?php
require_once '../config.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Update status
if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update = "UPDATE pengaduan SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $update);
    header('Location: kelola_pengaduan.php');
    exit();
}

// Hapus pengaduan
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $delete = "DELETE FROM pengaduan WHERE id = $id";
    mysqli_query($conn, $delete);
    header('Location: kelola_pengaduan.php');
    exit();
}

// Ambil semua pengaduan
$pengaduan_query = "SELECT p.*, u.nama as nama_user 
                    FROM pengaduan p 
                    JOIN users u ON p.user_id = u.id 
                    ORDER BY p.created_at DESC";
$pengaduan_result = mysqli_query($conn, $pengaduan_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - E-Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <div class="header-container">
            <div class="logo">E-Pengaduan</div>
            <div class="header-icons">
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
                <li><a href="berita.php">📰 Tambah Berita</a></li>
                <li><a href="kelola_pengaduan.php" class="active">📋 Kelola Pengaduan</a></li>
                <li><a href="kelola_user.php">👥 Kelola User</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Data Pengaduan</h2>
                
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>Bukti foto</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (mysqli_num_rows($pengaduan_result) > 0):
                                while($p = mysqli_fetch_assoc($pengaduan_result)): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $p['nama_lengkap']; ?></td>
                                <td><?php echo $p['kategori']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($p['tanggal_pengaduan'])); ?></td>
                                <td><?php echo substr($p['deskripsi'], 0, 50) . '...'; ?></td>
                                <td><?php echo $p['alamat_pengaduan']; ?></td>
                                <td>
                                    <?php if ($p['foto']): ?>
                                        <img src="../uploads/<?php echo $p['foto']; ?>" 
                                             style="width: 60px; height: 45px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                        <select name="status" class="badge badge-<?php echo strtolower($p['status']); ?>" 
                                                onchange="this.form.submit()" style="border: none; cursor: pointer;">
                                            <option value="Pending" <?php echo $p['status']=='Pending'?'selected':''; ?>>Pending</option>
                                            <option value="Proses" <?php echo $p['status']=='Proses'?'selected':''; ?>>Proses</option>
                                            <option value="Selesai" <?php echo $p['status']=='Selesai'?'selected':''; ?>>Selesai</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td>
                                    <a href="cetak_pengaduan.php?id=<?php echo $p['id']; ?>" 
                                       class="btn btn-warning" 
                                       style="padding: 5px 10px; font-size: 12px; text-decoration: none;" 
                                       target="_blank">Cetak</a>
                                    <a href="?hapus=<?php echo $p['id']; ?>" 
                                       class="btn btn-danger" 
                                       style="padding: 5px 10px; font-size: 12px; text-decoration: none;"
                                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="9" class="no-data">Belum ada pengaduan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
