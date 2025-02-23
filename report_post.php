<?php
session_start();
include '../includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Unauthorized access. Please log in."]));
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

// Validate input
if ($post_id <= 0 || empty($reason)) {
    die(json_encode(["error" => "Post ID and reason are required."]));
}

// Ensure post exists
$post_check_query = mysqli_prepare($conn, "SELECT id FROM posts WHERE id = ?");
mysqli_stmt_bind_param($post_check_query, "i", $post_id);
mysqli_stmt_execute($post_check_query);
$result = mysqli_stmt_get_result($post_check_query);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die(json_encode(["error" => "Post not found."]));
}

// Check if the user has already reported this post
$check_report = mysqli_prepare($conn, "SELECT id FROM reports WHERE user_id = ? AND post_id = ?");
mysqli_stmt_bind_param($check_report, "ii", $user_id, $post_id);
mysqli_stmt_execute($check_report);
$result = mysqli_stmt_get_result($check_report);
$existing_report = mysqli_fetch_assoc($result);

if ($existing_report) {
    die(json_encode(["error" => "You have already reported this post."]));
}

// Insert the report
$insert_report = mysqli_prepare($conn, "INSERT INTO reports (user_id, post_id, reason, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
mysqli_stmt_bind_param($insert_report, "iis", $user_id, $post_id, $reason);
mysqli_stmt_execute($insert_report);

mysqli_stmt_close($post_check_query);
mysqli_stmt_close($check_report);
mysqli_stmt_close($insert_report);
mysqli_close($conn);

echo json_encode(["success" => true, "message" => "✅ Report submitted successfully!"]);
exit();
?>
