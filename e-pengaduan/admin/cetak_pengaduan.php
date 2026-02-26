<?php
require_once '../config.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

$id = (int)$_GET['id'];

// Ambil data pengaduan
$query = "SELECT p.*, u.nama as nama_user, u.nik, u.alamat as alamat_user 
          FROM pengaduan p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die('Data tidak ditemukan');
}

// Load template configuration
require_once 'template_cetak.php';

// Get configuration for this category
$header = getHeaderConfig($data['kategori']);
$pembuka = getPembukaText($data['kategori'], $data['alamat_pengaduan']);
$hasil = getHasilText($data['kategori']);
$ttd = getTtdText($data['kategori']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengaduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        .header h2 {
            margin: 5px 0;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 10px 0;
            color: #333;
        }
        .content {
            margin: 20px 0;
        }
        .row {
            margin-bottom: 12px;
            line-height: 1.8;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }
        .foto-bukti {
            margin: 20px 0;
            text-align: center;
        }
        .foto-bukti img {
            max-width: 500px;
            max-height: 400px;
            border: 2px solid #333;
            padding: 5px;
        }
        .ttd-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .ttd-box {
            text-align: center;
            width: 45%;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Template sudah diload dari template_cetak.php
    ?>
    
    <div class="header">
        <h2><?php echo $header['judul']; ?></h2>
        <h3><?php echo $header['subjek']; ?></h3>
        <p style="margin: 5px 0;">No. Pengaduan: <?php echo str_pad($data['id'], 5, '0', STR_PAD_LEFT); ?>/<?php echo date('Y'); ?></p>
    </div>
    
    <div class="content">
        <p><strong>Kepada Yth.</strong></p>
        <p><strong><?php echo $header['tujuan']; ?></strong></p>
        <p><strong>Kabupaten Ponorogo</strong></p>
        <p><strong>di Tempat</strong></p>
        
        <p style="margin-top: 20px;"><strong>Dengan hormat,</strong></p>
        
        <p><?php echo $pembuka; ?></p>
        
        <p><strong>Rincian Pengaduan:</strong></p>
        
        <div class="row">
            <span class="label">• Pelapor:</span> <?php echo $data['nama_lengkap']; ?>
        </div>
        
        <div class="row">
            <span class="label">• Kategori:</span> <?php echo $data['kategori']; ?>
        </div>
        
        <div class="row">
            <span class="label">• Lokasi:</span> <?php echo $data['alamat_pengaduan']; ?>
        </div>
        
        <div class="row">
            <span class="label">• Tanggal Laporan:</span> 
            <?php echo date('d F Y', strtotime($data['tanggal_pengaduan'])); ?>
        </div>
        
        <div class="row">
            <span class="label">• Deskripsi Masalah:</span><br>
            <div style="margin-left: 20px; margin-top: 5px;">
                <?php echo nl2br($data['deskripsi']); ?>
            </div>
        </div>
        
        <?php if ($data['foto']): ?>
        <div class="foto-bukti no-print">
            <p><strong>Foto Bukti:</strong></p>
            <img src="../uploads/<?php echo $data['foto']; ?>" alt="Bukti Pengaduan">
        </div>
        <?php endif; ?>
        
        <p style="margin-top: 20px;"><strong>Rincian Penyelesaian:</strong></p>
        
        <div class="row">
            <span class="label">• Status:</span> 
            <strong style="color: green;"><?php echo $data['status']; ?></strong>
        </div>
        
        <div class="row">
            <span class="label">• Tanggal Penyelesaian:</span> 
            <?php echo date('d F Y'); ?>
        </div>
        
        <div class="row">
            <span class="label">• Hasil:</span><br>
            <div style="margin-left: 20px; margin-top: 5px;">
                <?php echo $hasil; ?>
            </div>
        </div>
        
        <div class="ttd-section">
            <div class="ttd-box">
                <p>Pelapor,</p>
                <br><br><br>
                <p><strong><?php echo $data['nama_lengkap']; ?></strong></p>
            </div>
            
            <div class="ttd-box">
                <p>Hormat kami,</p>
                <br><br><br>
                <p><strong><?php echo $ttd; ?></strong></p>
            </div>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #3B82F6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Sekarang
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; background: #6B7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            ❌ Tutup
        </button>
    </div>
</body>
</html>
