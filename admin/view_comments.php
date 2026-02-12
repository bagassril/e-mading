<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$post_id = $_GET['post_id'];
$post_query = "SELECT * FROM posts WHERE id = $post_id";
$post_result = mysqli_query($conn, $post_query);
$post = mysqli_fetch_assoc($post_result);

$comment_query = "SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = $post_id ORDER BY c.created_at DESC";
$comments = mysqli_query($conn, $comment_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Komentar</title>
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
            <h2>Kelola Komentar</h2>
            <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 20px;">
                Berita: <strong style="color: white;"><?php echo $post['title']; ?></strong>
            </p>
            
            <div class="admin-posts">
                <h3 style="margin-bottom: 20px; color: white;">Daftar Komentar (<?php echo mysqli_num_rows($comments); ?>)</h3>
                <?php if(mysqli_num_rows($comments) > 0): ?>
                <?php while($comment = mysqli_fetch_assoc($comments)): ?>
                <div class="comment-item" style="margin-bottom: 15px;">
                    <div class="comment-header">
                        <strong><?php echo $comment['username']; ?></strong>
                        <span><?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?></span>
                    </div>
                    <p style="margin: 10px 0;"><?php echo nl2br($comment['comment']); ?></p>
                    <a href="delete_comment.php?id=<?php echo $comment['id']; ?>&post_id=<?php echo $post_id; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus komentar ini?')">Hapus</a>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p style="text-align: center; color: rgba(255, 255, 255, 0.6);">Belum ada komentar</p>
                <?php endif; ?>
                <br>
                <a href="dashboard.php" class="btn">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
