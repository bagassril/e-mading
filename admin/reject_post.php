<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$query = "DELETE FROM posts WHERE id = $id";
mysqli_query($conn, $query);
header('Location: pending_posts.php');
?>
