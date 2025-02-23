<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Unauthorized access."]));
}

$user_id = $_SESSION['user_id'];
$position = isset($_POST['position']) ? intval($_POST['position']) : null;

// Validate input
if ($position === null || $position < 0 || $position > 100) {
    die(json_encode(["error" => "Invalid position value. Must be between 0 and 100."]));
}

// Update banner position in the database
$query = "UPDATE users SET banner_position = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $position, $user_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["success" => true, "message" => "Banner position updated!"]);
} else {
    echo json_encode(["error" => "Failed to update banner position."]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
