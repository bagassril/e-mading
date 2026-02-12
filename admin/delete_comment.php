<?php
include '../config.php';

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$post_id = $_GET['post_id'];
$query = "DELETE FROM comments WHERE id = $id";
mysqli_query($conn, $query);
header('Location: view_comments.php?post_id='.$post_id);
?>
