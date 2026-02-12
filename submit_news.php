<?php
include 'config.php';

if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $name = $_POST['name'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO posts (title, content, image, status, created_by) VALUES ('$title', '$content', '$image', 'pending', '$name')";
        if(mysqli_query($conn, $query)) {
            $success = "Berita berhasil dikirim! Menunggu persetujuan admin.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Berita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">E-MADING</a>
            <div class="navbar-menu">
                <a href="index.php" class="navbar-link">Beranda</a>
                <a href="submit_news.php" class="navbar-link">Kirim Berita</a>
                <?php if(isset($_SESSION['admin'])): ?>
                    <a href="admin/dashboard.php" class="navbar-link">Dashboard Admin</a>
                    <a href="admin/logout.php" class="navbar-link">Logout (Admin)</a>
                <?php elseif(isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="navbar-link">Logout (<?php echo $_SESSION['username']; ?>)</a>
                <?php else: ?>
                    <a href="login.php" class="navbar-link">Login</a>
                    <a href="register.php" class="navbar-link">Register</a>
                    <a href="admin/login.php" class="navbar-link">Admin</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="admin-container">
            <h2>Kirim Berita</h2>
            <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Anda</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Konten Berita</label>
                    <textarea name="content" required></textarea>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <button type="submit" name="submit" class="btn-submit">Kirim Berita</button>
                <br><br>
                <a href="index.php" class="btn" style="display: block; text-align: center; text-decoration: none;">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
