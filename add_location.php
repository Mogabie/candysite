<?php
session_start();
include 'includes/config.php'; // Ensure correct DB connection

header('Content-Type: application/json'); // Ensure JSON response

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Unauthorized. Please log in."]));
}

$user_id = $_SESSION['user_id'];

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['name'], $data['address'], $data['type'])) {
    die(json_encode(["error" => "All fields are required!"]));
}

$name = trim($data['name']);
$address = trim($data['address']);
$type = trim($data['type']);

// Debugging logs (Check server error logs for this output)
error_log("Received Data - Name: $name, Address: $address, Type: $type");

// Prevent unsafe locations
$unsafe_keywords = ["alley", "parking lot", "industrial area", "highway"];
foreach ($unsafe_keywords as $keyword) {
    if (stripos($address, $keyword) !== false) {
        die(json_encode(["error" => "⚠️ Cannot add unsafe locations."]));
    }
}

// ✅ Convert Address to Lat/Lon using OpenStreetMap (Nominatim) with User-Agent
$address_encoded = urlencode($address);
$geocode_url = "https://nominatim.openstreetmap.org/search?format=json&q={$address_encoded}";

// Set User-Agent header to avoid 403 Forbidden errors
$options = [
    "http" => [
        "header" => "User-Agent: CandyTestMapBot/1.0 (your-email@example.com)\r\n"
    ]
];
$context = stream_context_create($options);

$geocode_response = file_get_contents($geocode_url, false, $context);
$geocode_data = json_decode($geocode_response, true);

// Check if geolocation was successful
if (!$geocode_data || count($geocode_data) === 0) {
    die(json_encode(["error" => "⚠️ Address not found!"]));
}

$latitude = $geocode_data[0]['lat'];
$longitude = $geocode_data[0]['lon'];

// Debug: Check Geocoding Result
error_log("Geocoded Address - Lat: $latitude, Lon: $longitude");

// ✅ Insert into Database
$sql = "INSERT INTO locations (user_id, name, address, latitude, longitude, type, is_safe, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 1, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die(json_encode(["error" => "SQL Prepare Error: " . mysqli_error($conn)]));
}

mysqli_stmt_bind_param($stmt, "isssss", $user_id, $name, $address, $latitude, $longitude, $type);
mysqli_stmt_execute($stmt);

// Debug: Check if insertion was successful
if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["success" => true, "message" => "✅ Location added successfully!"]);
} else {
    echo json_encode(["error" => "❌ Failed to add location."]);
}

mysqli_stmt_close($stmt);
?>
