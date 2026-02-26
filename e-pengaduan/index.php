<?php
require_once 'config.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM users WHERE (email = '$username' OR nik = '$username') AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nama'];
        $_SESSION['user_role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: user/dashboard.php');
        }
        exit();
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Pengaduan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2>E-Pengaduan</h2>
            <p class="subtitle">"Suara Anda, Aksi Kami"</p>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="text" name="username" class="form-control" placeholder="Masukan Username...." required>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password...." required>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
            
            <div class="auth-footer">
                Belum punya akun? <a href="register.php">Registrasi</a>
            </div>
        </div>
    </div>
</body>
</html>
