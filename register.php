<?php
include 'config.php';

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($result) > 0) {
        $error = "Username atau email sudah digunakan!";
    } else {
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if(mysqli_query($conn, $query)) {
            header('Location: login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">E-MADING</a>
            <div class="navbar-menu">
                <a href="index.php" class="navbar-link">Beranda</a>
                <a href="login.php" class="navbar-link">Login</a>
            </div>
        </div>
    </nav>
    
    <div class="login-form">
        <h2>Register</h2>
        <?php if(isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="register" class="btn-submit">Register</button>
        </form>
        <br>
        <p style="text-align: center; color: rgba(255, 255, 255, 0.7);">
            Sudah punya akun? <a href="login.php" style="color: #8a2be2;">Login</a>
        </p>
    </div>
</body>
</html>
