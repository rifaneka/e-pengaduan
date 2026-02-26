<?php
require_once '../config.php';

// Cek login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan - E-Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .faq-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .faq-item h4 {
            color: var(--primary-blue);
            margin-bottom: 10px;
        }
        .faq-answer {
            display: none;
            color: #6B7280;
            margin-top: 10px;
        }
        .faq-item.active .faq-answer {
            display: block;
        }
    </style>
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
                <li><a href="riwayat.php">📄 Riwayat</a></li>
                <li><a href="survey.php">⭐ Survey</a></li>
                <li><a href="bantuan.php" class="active">❓ Bantuan</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Bantuan / FAQ</h2>
                
                <div class="faq-item">
                    <h4>1. Cara membuat Pengaduan</h4>
                    <div class="faq-answer">
                        Untuk membuat pengaduan, klik menu "Pengaduan" di sidebar, 
                        kemudian isi formulir dengan lengkap dan klik tombol "Submit".
                    </div>
                </div>
                
                <div class="faq-item">
                    <h4>2. Cara Melihat Status Pengaduan</h4>
                    <div class="faq-answer">
                        Anda dapat melihat status pengaduan Anda di menu "Riwayat". 
                        Status akan ditampilkan dengan badge berwarna (Pending, Proses, atau Selesai).
                    </div>
                </div>
                
                <div class="faq-item">
                    <h4>3. Kendala Login / Lupa Password</h4>
                    <div class="faq-answer">
                        Jika mengalami kendala login atau lupa password, silakan hubungi 
                        administrator melalui email: admin@epengaduan.com
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
