<?php
include 'config.php';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">E-MADING</a>
            <div class="navbar-menu">
                <a href="index.php" class="navbar-link">Beranda</a>
                <a href="register.php" class="navbar-link">Register</a>
            </div>
        </div>
    </nav>
    
    <div class="login-form">
        <h2>Login</h2>
        <?php if(isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn-submit">Login</button>
        </form>
        <br>
        <p style="text-align: center; color: rgba(255, 255, 255, 0.7);">
            Belum punya akun? <a href="register.php" style="color: #8a2be2;">Register</a>
        </p>
    </div>
</body>
</html>
