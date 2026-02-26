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

// Cek apakah user sudah pernah survey
$check_query = "SELECT * FROM survey WHERE user_id = $user_id";
$check_result = mysqli_query($conn, $check_query);
$sudah_survey = mysqli_num_rows($check_result) > 0;

if (isset($_POST['submit_survey'])) {
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    
    if ($sudah_survey) {
        // Update survey
        $query = "UPDATE survey SET rating = '$rating', komentar = '$komentar', updated_at = NOW() 
                  WHERE user_id = $user_id";
    } else {
        // Insert survey baru
        $query = "INSERT INTO survey (user_id, rating, komentar) 
                  VALUES ($user_id, '$rating', '$komentar')";
    }
    
    if (mysqli_query($conn, $query)) {
        $success = 'Terima kasih atas feedback Anda!';
        $sudah_survey = true;
    } else {
        $error = 'Gagal menyimpan survey!';
    }
}

// Ambil survey user jika sudah pernah
if ($sudah_survey) {
    $survey_data = mysqli_fetch_assoc($check_result);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Kepuasan - E-Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .rating-container {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .rating-option {
            flex: 1;
            min-width: 200px;
        }
        .rating-option input[type="radio"] {
            display: none;
        }
        .rating-label {
            display: block;
            padding: 20px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .rating-option input[type="radio"]:checked + .rating-label {
            border-color: #3B82F6;
            background: #EFF6FF;
        }
        .rating-label:hover {
            border-color: #3B82F6;
        }
        .emoji {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .rating-text {
            font-weight: 600;
            color: #1F2937;
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
                <li><a href="bantuan.php">❓ Bantuan</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="card">
                <h2 class="card-title">Survey Kepuasan User</h2>
                <p style="color: #6B7280; margin-bottom: 30px;">
                    Bantu kami meningkatkan pelayanan dengan memberikan penilaian Anda
                </p>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <label style="display: block; margin-bottom: 15px; font-weight: 600; color: #1F2937;">
                        Bagaimana tingkat kepuasan Anda terhadap layanan E-Pengaduan?
                    </label>
                    
                    <div class="rating-container">
                        <div class="rating-option">
                            <input type="radio" name="rating" id="sangat_puas" value="Sangat Puas" 
                                   <?php echo (isset($survey_data) && $survey_data['rating'] == 'Sangat Puas') ? 'checked' : ''; ?> required>
                            <label for="sangat_puas" class="rating-label">
                                <div class="emoji">😍</div>
                                <div class="rating-text">Sangat Puas</div>
                            </label>
                        </div>
                        
                        <div class="rating-option">
                            <input type="radio" name="rating" id="puas" value="Puas"
                                   <?php echo (isset($survey_data) && $survey_data['rating'] == 'Puas') ? 'checked' : ''; ?>>
                            <label for="puas" class="rating-label">
                                <div class="emoji">😊</div>
                                <div class="rating-text">Puas</div>
                            </label>
                        </div>
                        
                        <div class="rating-option">
                            <input type="radio" name="rating" id="cukup" value="Cukup"
                                   <?php echo (isset($survey_data) && $survey_data['rating'] == 'Cukup') ? 'checked' : ''; ?>>
                            <label for="cukup" class="rating-label">
                                <div class="emoji">😐</div>
                                <div class="rating-text">Cukup</div>
                            </label>
                        </div>
                        
                        <div class="rating-option">
                            <input type="radio" name="rating" id="tidak_puas" value="Tidak Puas"
                                   <?php echo (isset($survey_data) && $survey_data['rating'] == 'Tidak Puas') ? 'checked' : ''; ?>>
                            <label for="tidak_puas" class="rating-label">
                                <div class="emoji">😞</div>
                                <div class="rating-text">Tidak Puas</div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 30px;">
                        <label>Komentar / Saran (Opsional)</label>
                        <textarea name="komentar" class="form-control" rows="4" 
                                  placeholder="Bagikan pengalaman atau saran Anda..."><?php echo isset($survey_data) ? $survey_data['komentar'] : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" name="submit_survey" class="btn btn-primary">
                        <?php echo $sudah_survey ? 'Update Survey' : 'Kirim Survey'; ?>
                    </button>
                </form>
                
                <?php if ($sudah_survey): ?>
                <div style="margin-top: 20px; padding: 15px; background: #EFF6FF; border-left: 4px solid #3B82F6; border-radius: 8px;">
                    <p style="margin: 0; color: #1E40AF;">
                        <strong>✓ Terima kasih!</strong> Anda sudah memberikan penilaian sebelumnya. 
                        Anda dapat mengubahnya kapan saja.
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
