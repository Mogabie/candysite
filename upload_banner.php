<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Unauthorized access."]));
}

$user_id = $_SESSION['user_id'];

// Check if a file was uploaded
if (!isset($_FILES['banner']) || $_FILES['banner']['error'] !== UPLOAD_ERR_OK) {
    die(json_encode(["error" => "No file uploaded or upload error occurred."]));
}

$target_dir = "uploads/";
$original_name = basename($_FILES["banner"]["name"]);
$extension = pathinfo($original_name, PATHINFO_EXTENSION);
$allowed_extensions = ["jpg", "jpeg", "png", "gif"];

// Validate file extension
if (!in_array(strtolower($extension), $allowed_extensions)) {
    die(json_encode(["error" => "Invalid file type. Only JPG, PNG, and GIF allowed."]));
}

// Generate unique filename to prevent overwrites
$new_filename = $user_id . "_banner_" . time() . "." . $extension;
$target_file = $target_dir . $new_filename;

// Move the uploaded file to the correct directory
if (!move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
    die(json_encode(["error" => "Failed to upload file."]));
}

// Update the user's banner in the database
$query = "UPDATE users SET banner = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "si", $new_filename, $user_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["success" => true, "message" => "Banner updated successfully!", "banner_url" => $target_file]);
} else {
    echo json_encode(["error" => "Failed to update banner in database."]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
