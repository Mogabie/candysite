<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch post data
$post_query = mysqli_prepare($conn, "SELECT image_url FROM posts WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($post_query, "ii", $post_id, $user_id);
mysqli_stmt_execute($post_query);
$result = mysqli_stmt_get_result($post_query);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("Error: Post not found or you do not have permission to delete it.");
}

// Delete image if exists
if (!empty($post['image_url']) && file_exists($post['image_url'])) {
    unlink($post['image_url']);
}

// Delete post
$delete_query = mysqli_prepare($conn, "DELETE FROM posts WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($delete_query, "ii", $post_id, $user_id);
mysqli_stmt_execute($delete_query);

header("Location: community.php");
exit();
