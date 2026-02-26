<?php
require_once '../config.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Statistik
$stats = [];

// Total pengguna baru
$user_query = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
$user_result = mysqli_query($conn, $user_query);
$stats['users'] = mysqli_fetch_assoc($user_result)['total'];

// Total pengaduan
$pengaduan_query = "SELECT COUNT(*) as total FROM pengaduan";
$pengaduan_result = mysqli_query($conn, $pengaduan_query);
$stats['pengaduan'] = mysqli_fetch_assoc($pengaduan_result)['total'];

// Total terselesaikan
$selesai_query = "SELECT COUNT(*) as total FROM pengaduan WHERE status = 'Selesai'";
$selesai_result = mysqli_query($conn, $selesai_query);
$stats['selesai'] = mysqli_fetch_assoc($selesai_result)['total'];

// Berita terbaru
$berita_query = "SELECT * FROM berita ORDER BY created_at DESC LIMIT 1";
$berita_result = mysqli_query($conn, $berita_query);
$berita = mysqli_fetch_assoc($berita_result);

// Data survey untuk grafik
$survey_stats = [
    'Sangat Puas' => 0,
    'Puas' => 0,
    'Cukup' => 0,
    'Tidak Puas' => 0
];

$survey_query = "SELECT rating, COUNT(*) as jumlah FROM survey GROUP BY rating";
$survey_result = mysqli_query($conn, $survey_query);
while ($row = mysqli_fetch_assoc($survey_result)) {
    $survey_stats[$row['rating']] = (int)$row['jumlah'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Pengaduan</title>
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
                <li><a href="dashboard.php" class="active">🏠 Dashboard</a></li>
                <li><a href="berita.php">📰 Tambah Berita</a></li>
                <li><a href="kelola_pengaduan.php">📋 Kelola Pengaduan</a></li>
                <li><a href="kelola_user.php">👥 Kelola User</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <h2 style="color: var(--primary-blue); margin-bottom: 10px;">
                Selamat Datang di Dashboard Admin
            </h2>
            <p style="color: #6B7280; margin-bottom: 30px;">Baca Berita dan Laporan Terkini !</p>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['users']; ?></div>
                    <div class="stat-label">Pengguna Baru</div>
                    <small style="color: #10B981;">Data yang valid dan Akurat</small>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['pengaduan']; ?></div>
                    <div class="stat-label">Laporan Pengaduan</div>
                    <small style="color: #10B981;">Data yang valid dan Akurat</small>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['selesai']; ?></div>
                    <div class="stat-label">Terselesaikan</div>
                    <small style="color: #10B981;">Data yang valid dan Akurat</small>
                </div>
            </div>
            
            <div class="card">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">Berita Desa Terkini</h3>
                
                <?php if ($berita): ?>
                <div style="display: flex; gap: 20px;">
                    <?php if ($berita['foto']): ?>
                    <img src="../berita/<?php echo $berita['foto']; ?>" 
                         alt="<?php echo $berita['judul']; ?>" 
                         style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px;">
                    <?php endif; ?>
                    
                    <div style="flex: 1;">
                        <h4><?php echo $berita['judul']; ?></h4>
                        <p style="color: #6B7280; margin: 10px 0;">
                            <?php echo substr($berita['deskripsi'], 0, 200); ?>...
                        </p>
                        <div style="margin-top: 15px;">
                            <button class="btn btn-primary">Baru</button>
                            <button class="btn btn-warning">Lanjutkan</button>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <p class="no-data">Belum ada berita terbaru</p>
                <?php endif; ?>
            </div>
            
            <div class="card" style="margin-top: 20px;">
                <h3 style="color: var(--primary-blue); margin-bottom: 10px;">Survey Kepuasan User</h3>
                <p style="color: #6B7280; margin-bottom: 20px;">Grafik kepuasan pengguna akan ditampilkan di sini</p>
                
                <canvas id="surveyChart" width="400" height="200"></canvas>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data survey kepuasan dari database
        const ctx = document.getElementById('surveyChart').getContext('2d');
        const surveyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sangat Puas', 'Puas', 'Cukup', 'Tidak Puas'],
                datasets: [{
                    label: 'Jumlah Responden',
                    data: [
                        <?php echo $survey_stats['Sangat Puas']; ?>,
                        <?php echo $survey_stats['Puas']; ?>,
                        <?php echo $survey_stats['Cukup']; ?>,
                        <?php echo $survey_stats['Tidak Puas']; ?>
                    ],
                    backgroundColor: [
                        '#3B82F6',
                        '#60A5FA',
                        '#93C5FD',
                        '#DBEAFE'
                    ],
                    borderColor: [
                        '#1E40AF',
                        '#3B82F6',
                        '#60A5FA',
                        '#93C5FD'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
