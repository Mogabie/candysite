<?php
session_start();
include 'includes/config.php'; // Database connection

header('Content-Type: application/json'); // Ensure JSON response

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["error" => "Unauthorized access."]);
    exit();
}

// Get the report ID from the POST request
if (!isset($_POST['id'])) {
    echo json_encode(["error" => "Missing report ID."]);
    exit();
}

$report_id = intval($_POST['id']);

// Update the report status to "dismissed"
$query = "UPDATE reports SET status = 'dismissed' WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo json_encode(["error" => "SQL Error: " . mysqli_error($conn)]);
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $report_id);
mysqli_stmt_execute($stmt);

// Check if the update was successful
if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["success" => true, "message" => "✅ Report dismissed successfully!"]);
} else {
    echo json_encode(["error" => "❌ Failed to dismiss report."]);
}

mysqli_stmt_close($stmt);
?>
