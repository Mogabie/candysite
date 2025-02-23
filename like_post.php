<?php
session_start();
include 'includes/config.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

if ($post_id === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid post ID."]);
    exit();
}

// Check if the user already liked the post
$check_query = mysqli_prepare($conn, "SELECT id FROM post_likes WHERE user_id = ? AND post_id = ?");
mysqli_stmt_bind_param($check_query, "ii", $user_id, $post_id);
mysqli_stmt_execute($check_query);
$result = mysqli_stmt_get_result($check_query);
$existing_like = mysqli_fetch_assoc($result);

if ($existing_like) {
    // Unlike the post
    $delete_query = mysqli_prepare($conn, "DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
    mysqli_stmt_bind_param($delete_query, "ii", $user_id, $post_id);
    mysqli_stmt_execute($delete_query);

    if (mysqli_stmt_affected_rows($delete_query) > 0) {
        echo json_encode(["status" => "unliked", "post_id" => $post_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to unlike."]);
    }
} else {
    // Like the post
    $insert_query = mysqli_prepare($conn, "INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_query, "ii", $user_id, $post_id);
    mysqli_stmt_execute($insert_query);

    if (mysqli_stmt_affected_rows($insert_query) > 0) {
        echo json_encode(["status" => "liked", "post_id" => $post_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to like."]);
    }
}

exit();
