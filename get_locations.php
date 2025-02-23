<?php
include 'includes/config.php'; // Database connection

// Fetch only safe locations
$query = "SELECT id, user_id, name, address, latitude, longitude, is_safe FROM locations WHERE is_safe = 1";
$result = mysqli_query($conn, $query);

$locations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = [
        "id" => $row["id"],
        "user_id" => $row["user_id"],
        "name" => $row["name"],
        "address" => $row["address"],
        "lat" => $row["latitude"],
        "lng" => $row["longitude"],
        "is_safe" => $row["is_safe"]
    ];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($locations);
?>
