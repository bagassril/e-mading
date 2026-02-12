<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM posts WHERE status='approved' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
        <div class="admin-container" style="max-width: 900px;">
            <div class="admin-header">
                <h2>Dashboard Admin</h2>
                <div>
                    <a href="add_post.php" class="btn">Tambah Postingan</a>
                </div>
            </div>
            
            <div class="admin-posts">
                <h3 style="margin-bottom: 20px; color: white;">Daftar Postingan</h3>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="post-item">
                    <div>
                        <h4><?php echo $row['title']; ?></h4>
                        <p style="color: #999; font-size: 14px;"><?php echo date('d F Y', strtotime($row['created_at'])); ?></p>
                    </div>
                    <div>
                        <a href="../detail.php?id=<?php echo $row['id']; ?>" class="btn" style="margin-right: 10px;">Lihat</a>
                        <a href="view_comments.php?post_id=<?php echo $row['id']; ?>" class="btn" style="background: #f39c12; margin-right: 10px;">Komentar</a>
                        <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>
