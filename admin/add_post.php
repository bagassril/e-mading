<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO posts (title, content, image) VALUES ('$title', '$content', '$image')";
        if(mysqli_query($conn, $query)) {
            header('Location: dashboard.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Postingan</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="../index.php" class="navbar-brand">E-MADING</a>
            <div class="navbar-menu">
                <a href="../index.php" class="navbar-link">Beranda</a>
                <a href="dashboard.php" class="navbar-link">Dashboard</a>
                <a href="pending_posts.php" class="navbar-link">Berita Pending</a>
                <a href="logout.php" class="navbar-link">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="admin-container">
            <h2>Tambah Postingan Baru</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="content" required></textarea>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <button type="submit" name="submit" class="btn-submit">Simpan Postingan</button>
                <br><br>
                <a href="dashboard.php" class="btn" style="display: block; text-align: center; text-decoration: none;">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
