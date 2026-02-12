<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = $id";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
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
        <div class="detail-post">
            <div style="background: rgba(255, 193, 7, 0.2); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255, 193, 7, 0.5);">
                <strong style="color: #ffc107;">Status: PENDING</strong> | Dikirim oleh: <?php echo $post['created_by']; ?>
            </div>
            <h1><?php echo $post['title']; ?></h1>
            <?php if($post['image']): ?>
            <img src="../uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
            <?php endif; ?>
            <p class="date"><?php echo date('d F Y', strtotime($post['created_at'])); ?></p>
            <div class="content">
                <?php echo nl2br($post['content']); ?>
            </div>
            <br><br>
            <div style="display: flex; gap: 10px;">
                <a href="approve_post.php?id=<?php echo $post['id']; ?>" class="btn" style="background: #27ae60;">Setujui Berita</a>
                <a href="reject_post.php?id=<?php echo $post['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menolak?')">Tolak Berita</a>
                <a href="pending_posts.php" class="btn">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
