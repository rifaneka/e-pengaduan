<?php
require_once '../config.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $delete = "DELETE FROM users WHERE id = $id AND role = 'user'";
    mysqli_query($conn, $delete);
    header('Location: kelola_user.php');
    exit();
}

// Ambil semua user
$users_query = "SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC";
$users_result = mysqli_query($conn, $users_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - E-Pengaduan</title>
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
                <li><a href="kelola_pengaduan.php">📋 Kelola Pengaduan</a></li>
                <li><a href="kelola_user.php" class="active">👥 Kelola User</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Kelola User</h2>
                
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (mysqli_num_rows($users_result) > 0):
                                while($user = mysqli_fetch_assoc($users_result)): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $user['nik']; ?></td>
                                <td><?php echo $user['nama']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['alamat']; ?></td>
                                <td>**********</td>
                                <td>
                                    <a href="?hapus=<?php echo $user['id']; ?>" 
                                       class="btn btn-danger" 
                                       style="padding: 5px 15px; font-size: 12px; text-decoration: none;"
                                       onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="no-data">Belum ada user terdaftar</td>
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
