<?php
include 'config.php';

if(isset($_POST['submit'])) {
    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
    $post_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
    
    if($parent_id) {
        $query = "INSERT INTO comments (post_id, user_id, comment, parent_id) VALUES ('$post_id', '$user_id', '$comment', '$parent_id')";
    } else {
        $query = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
    }
    mysqli_query($conn, $query);
    header('Location: detail.php?id='.$post_id);
    exit;
}

if(isset($_POST['admin_reply'])) {
    if(!isset($_SESSION['admin'])) {
        header('Location: admin/login.php');
        exit;
    }
    
    $post_id = $_GET['id'];
    $comment = $_POST['comment'];
    $parent_id = $_POST['parent_id'];
    
    $query = "INSERT INTO comments (post_id, comment, parent_id, is_admin) VALUES ('$post_id', '$comment', '$parent_id', 1)";
    mysqli_query($conn, $query);
    header('Location: detail.php?id='.$post_id);
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = $id AND status='approved'";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

$comment_query = "SELECT c.*, u.username FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.post_id = $id AND c.parent_id IS NULL ORDER BY c.created_at DESC";
$comments = mysqli_query($conn, $comment_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
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
        
        <div class="detail-post">
            <h1><?php echo $post['title']; ?></h1>
            <?php if($post['image']): ?>
            <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
            <?php endif; ?>
            <p class="date"><?php echo date('d F Y', strtotime($post['created_at'])); ?></p>
            <div class="content">
                <?php echo nl2br($post['content']); ?>
            </div>
        </div>
        
        <div class="comments-section">
            <h2>Komentar</h2>
            
            <?php if(isset($_SESSION['user_id']) || isset($_SESSION['admin'])): ?>
            <form method="POST" class="comment-form">
                <div class="form-group">
                    <label>Komentar</label>
                    <textarea name="comment" rows="4" required></textarea>
                </div>
                <?php if(isset($_SESSION['admin'])): ?>
                <button type="submit" name="admin_reply" class="btn-submit">Kirim Komentar (Admin)</button>
                <?php else: ?>
                <button type="submit" name="submit" class="btn-submit">Kirim Komentar</button>
                <?php endif; ?>
            </form>
            <?php else: ?>
            <div class="alert alert-error">
                Anda harus <a href="login.php" style="color: #8a2be2; font-weight: bold;">login</a> terlebih dahulu untuk berkomentar.
            </div>
            <?php endif; ?>
            
            <div class="comments-list">
                <h3>Semua Komentar (<?php echo mysqli_num_rows($comments); ?>)</h3>
                <?php while($comment = mysqli_fetch_assoc($comments)): ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <strong><?php echo $comment['is_admin'] ? 'Admin' : $comment['username']; ?></strong>
                        <?php if($comment['is_admin']): ?>
                        <span style="background: #8a2be2; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 5px;">ADMIN</span>
                        <?php endif; ?>
                        <span><?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?></span>
                    </div>
                    <p><?php echo nl2br($comment['comment']); ?></p>
                    
                    <?php
                    $reply_query = "SELECT c.*, u.username FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.parent_id = ".$comment['id']." ORDER BY c.created_at ASC";
                    $replies = mysqli_query($conn, $reply_query);
                    if(mysqli_num_rows($replies) > 0):
                    ?>
                    <div class="replies">
                        <?php while($reply = mysqli_fetch_assoc($replies)): ?>
                        <div class="reply-item">
                            <div class="comment-header">
                                <strong><?php echo $reply['is_admin'] ? 'Admin' : $reply['username']; ?></strong>
                                <?php if($reply['is_admin']): ?>
                                <span style="background: #8a2be2; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 5px;">ADMIN</span>
                                <?php endif; ?>
                                <span><?php echo date('d M Y H:i', strtotime($reply['created_at'])); ?></span>
                            </div>
                            <p><?php echo nl2br($reply['comment']); ?></p>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($_SESSION['user_id']) || isset($_SESSION['admin'])): ?>
                    <button class="btn-reply" onclick="toggleReply(<?php echo $comment['id']; ?>)">Balas</button>
                    <form method="POST" class="reply-form" id="reply-form-<?php echo $comment['id']; ?>" style="display: none; margin-top: 15px;">
                        <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
                        <div class="form-group">
                            <textarea name="comment" rows="3" placeholder="Tulis balasan..." required></textarea>
                        </div>
                        <?php if(isset($_SESSION['admin'])): ?>
                        <button type="submit" name="admin_reply" class="btn-submit">Kirim Balasan (Admin)</button>
                        <?php else: ?>
                        <button type="submit" name="submit" class="btn-submit">Kirim Balasan</button>
                        <?php endif; ?>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    
    <script>
    function toggleReply(id) {
        var form = document.getElementById('reply-form-' + id);
        if(form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
    </script>
</body>
</html>
