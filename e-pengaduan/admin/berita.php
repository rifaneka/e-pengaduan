<?php
require_once '../config.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

$success = '';
$error = '';

// Tambah berita
if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Upload foto
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto = time() . '_' . $filename;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../berita/' . $foto);
        }
    }
    
    $query = "INSERT INTO berita (judul, kategori, tanggal_publikasi, deskripsi, foto) 
              VALUES ('$judul', '$kategori', '$tanggal', '$deskripsi', '$foto')";
    
    if (mysqli_query($conn, $query)) {
        $success = 'Berita berhasil ditambahkan!';
    } else {
        $error = 'Berita gagal ditambahkan!';
    }
}

// Hapus berita
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $delete = "DELETE FROM berita WHERE id = $id";
    mysqli_query($conn, $delete);
    header('Location: berita.php');
    exit();
}

// Ambil semua berita
$berita_query = "SELECT * FROM berita ORDER BY created_at DESC";
$berita_result = mysqli_query($conn, $berita_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - E-Pengaduan</title>
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
                <li><a href="berita.php" class="active">📰 Tambah Berita</a></li>
                <li><a href="kelola_pengaduan.php">📋 Kelola Pengaduan</a></li>
                <li><a href="kelola_user.php">👥 Kelola User</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <!-- Form Tambah Berita -->
            <div class="card" style="margin-bottom: 20px;">
                <h2 class="card-title">Form Tambah Berita</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Judul Berita</label>
                        <input type="text" name="judul" class="form-control" placeholder="Perseba" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kategori Berita</label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pembangunan">Pembangunan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Publikasi</label>
                        <input type="date" name="tanggal" class="form-control" 
                               value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi Berita</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Lalalalala" required></textarea>
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
            
            <!-- Data Berita -->
            <div class="card">
                <h2 class="card-title">Data Berita</h2>
                
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul Berita</th>
                                <th>Kategori</th>
                                <th>Tanggal Publikasi</th>
                                <th>Deskripsi</th>
                                <th>Bukti foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (mysqli_num_rows($berita_result) > 0):
                                while($berita = mysqli_fetch_assoc($berita_result)): 
                            ?>
                            <tr>
                                <td><?php echo $berita['judul']; ?></td>
                                <td><?php echo $berita['kategori']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($berita['tanggal_publikasi'])); ?></td>
                                <td><?php echo substr($berita['deskripsi'], 0, 50) . '...'; ?></td>
                                <td>
                                    <?php if ($berita['foto']): ?>
                                        <img src="../berita/<?php echo $berita['foto']; ?>" 
                                             style="width: 60px; height: 45px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px; text-decoration: none;">Edit</a>
                                    <a href="?hapus=<?php echo $berita['id']; ?>" 
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
                                <td colspan="6" class="no-data">Belum ada berita</td>
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
