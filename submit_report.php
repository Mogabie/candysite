<?php
session_start();
include 'includes/config.php'; // Database connection

header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    error_log("❌ Report failed: User is not logged in.");
    die(json_encode(["error" => "Unauthorized. Please log in."]));
}

$user_id = intval($_SESSION['user_id']); // Ensure it's an integer
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;
$reason = isset($_POST['reason']) ? trim(htmlspecialchars($_POST['reason'])) : '';
$type = isset($_POST['type']) ? $_POST['type'] : 'post'; // Default to post reports

// ✅ Log received data for debugging
error_log("📩 Received Report Request: Post ID: $post_id, Reason: $reason, Type: $type, User: $user_id");

// Validate input
if (empty($post_id) || empty($reason)) {
    error_log("❌ Missing required data: Post ID or Reason is empty.");
    die(json_encode(["error" => "⚠️ Post ID and reason are required!"]));
}

// ✅ Ensure post exists in `posts` table
$check_post_query = "SELECT id FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $check_post_query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$post) {
    error_log("❌ Report failed: Post ID $post_id does not exist in `posts` table.");
    die(json_encode(["error" => "❌ Cannot report: Post not found."]));
}

// ✅ Ensure user exists in `users` table
$check_user_query = "SELECT id FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $check_user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    error_log("❌ Report failed: User ID $user_id does not exist in `users` table.");
    die(json_encode(["error" => "❌ Cannot report: User not found."]));
}

// ✅ Check if the user has already reported this post
$check_report_query = "SELECT id FROM reports WHERE post_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $check_report_query);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$existing_report = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($existing_report) {
    error_log("⚠️ Duplicate report: User $user_id already reported post ID $post_id");
    die(json_encode(["error" => "⚠️ You have already reported this post."]));
}

// ✅ Insert into `reports` table
$query = "INSERT INTO reports (post_id, user_id, reason, type, status, created_at) 
          VALUES (?, ?, ?, ?, 'pending', NOW())";
;
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iiss", $post_id, $user_id, $reason, $type);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    error_log("✅ Report submitted successfully for Post ID $post_id by User $user_id");
    echo json_encode(["success" => true, "message" => "✅ Report submitted!"]);
} else {
    error_log("❌ Report submission failed for Post ID $post_id");
    echo json_encode(["error" => "❌ Failed to submit report."]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>