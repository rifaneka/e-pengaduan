<?php
require_once '../config.php';

// Cek login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil User - E-Pengaduan</title>
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
                <li><a href="pengaduan.php">📋 Pengaduan</a></li>
                <li><a href="riwayat.php">📄 Riwayat</a></li>
                <li><a href="survey.php">⭐ Survey</a></li>
                <li><a href="bantuan.php">❓ Bantuan</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Profil User</h2>
                
                <div style="max-width: 600px; margin: 0 auto;">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: var(--primary-blue); margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 60px;">
                            👤
                        </div>
                    </div>
                    
                    <div style="background: #E0E7FF; padding: 30px; border-radius: 12px;">
                        <div style="margin-bottom: 15px;">
                            <strong>Nama :</strong> <?php echo $user_data['nama']; ?>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>E-mail :</strong> <?php echo $user_data['email']; ?>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>Password :</strong> **************
                        </div>
                        <div>
                            <strong>Alamat :</strong> <?php echo $user_data['alamat']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
