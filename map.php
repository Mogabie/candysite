<?php
session_start();
include "includes/config.php";

// Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
$user_zip = null;

if ($user_id) {
    $query = mysqli_query($conn, "SELECT location FROM users WHERE id = '$user_id'");
    $user = mysqli_fetch_assoc($query);
    $user_zip = $user['location'] ?? null;
}
?>
<script>
    var userZip = "<?php echo $_SESSION['zipcode'] ?? ''; ?>";
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trick-or-Treat Hotspots Map</title>
    <link rel="stylesheet" href="assets/css/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="assets/js/map.js" defer></script>

</head>

<body>
    <?php include "includes/header.php"; ?>
    <div class="container">
        <h2>🎃 Trick-or-Treat Hotspots 🎃</h2>

        <div id="map"></div>
        <div id="map-search-container">
            <input type="text" id="map-search" placeholder="Search for a location...">
            <button style="display: inline-block;" onclick="searchLocation()">🔍 Search</button>
        </div>

        <div id="map-controls">
            <h3>Add a Location</h3>
            <form id="location-form">
                <input type="text" id="location-name" placeholder="Location Name" required>
                <input type="text" id="location-address" placeholder="Address, ZIP, or Landmark" required>
                <select id="location-type">
                    <option value="hotspot">🍬 Trick-or-Treat Hotspot</option>
                    <option value="haunted">👻 Haunted House</option>
                    <option value="decorations">🎃 Halloween Decorations</option>
                </select>
                <button type="submit">Add Location</button>
            </form>

        </div>
    </div>
</body>

</html>