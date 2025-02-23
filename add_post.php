<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$content = trim($_POST['content'] ?? '');
$image = $_FILES['image'] ?? null;
$video_url = trim($_POST['video_url'] ?? '');

// Ensure at least one input is provided
if (empty($content) && empty($image['name']) && empty($video_url)) {
    die("Error: You must provide text, an image, or a video.");
}

$image_url = '';
if ($image && $image['error'] === 0) {
    $upload_dir = 'uploads/';
    $image_name = time() . "_" . basename($image['name']);
    $target_file = $upload_dir . $image_name;

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowed_types)) {
        die("Error: Invalid image format. Only JPG, PNG, and GIF are allowed.");
    }
    
    if (move_uploaded_file($image['tmp_name'], $target_file)) {
        $image_url = $target_file;
    } else {
        die("Error uploading image.");
    }
}

// Insert post into database
$query = "INSERT INTO posts (user_id, content, image_url, video_url, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "isss", $user_id, $content, $image_url, $video_url);
mysqli_stmt_execute($stmt);

header("Location: community.php");
exit();
