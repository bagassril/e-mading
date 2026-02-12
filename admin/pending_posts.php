<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM posts WHERE status='pending' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Pending</title>
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
                <h2>Berita Pending (<?php echo mysqli_num_rows($result); ?>)</h2>
            </div>
            
            <div class="admin-posts">
                <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="post-item">
                    <div>
                        <h4><?php echo $row['title']; ?></h4>
                        <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px;">
                            Oleh: <?php echo $row['created_by']; ?> | <?php echo date('d F Y', strtotime($row['created_at'])); ?>
                        </p>
                    </div>
                    <div>
                        <a href="view_pending.php?id=<?php echo $row['id']; ?>" class="btn" style="margin-right: 10px;">Lihat</a>
                        <a href="approve_post.php?id=<?php echo $row['id']; ?>" class="btn" style="background: #27ae60; margin-right: 10px;">Setujui</a>
                        <a href="reject_post.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menolak?')">Tolak</a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p style="text-align: center; color: rgba(255, 255, 255, 0.6);">Tidak ada berita pending</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
