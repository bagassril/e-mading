<?php
include 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

if($search) {
    $query = "SELECT * FROM posts WHERE status='approved' AND (title LIKE '%$search%' OR content LIKE '%$search%') ORDER BY created_at DESC";
} else {
    $query = "SELECT * FROM posts WHERE status='approved' ORDER BY created_at DESC";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mading</title>
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
        <header>
            <h1>E-MADING DIGITAL</h1>
        </header>
        
        <div class="search-container">
            <form method="GET" class="search-box">
                <input type="text" name="search" class="search-input" placeholder="Cari postingan..." value="<?php echo $search; ?>">
                <button type="submit" class="search-btn">Cari</button>
            </form>
        </div>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="posts-grid">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="post-card">
                <?php if($row['image']): ?>
                <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                <?php endif; ?>
                <div class="post-content">
                    <h2><?php echo $row['title']; ?></h2>
                    <p><?php echo substr($row['content'], 0, 150); ?>...</p>
                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn">Baca Selengkapnya</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="no-results">
            <h3>Tidak ada hasil</h3>
            <p>Postingan yang Anda cari tidak ditemukan</p>
            <br>
            <a href="index.php" class="btn">Kembali ke Beranda</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
