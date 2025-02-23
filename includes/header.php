<?php
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Correct the path to config.php
require_once __DIR__ . "/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Where’s The Candy?</title>
    <link rel="stylesheet" href="assets/css/header.css">
    <style>
        a {
            /* font-size: 22px !important; */
            padding: 0 20px ;
        }
    </style>
    <!-- <script src="assets/js/post.js" defer></script> -->
</head>
<header class="main-header">
    <nav>
        <a href="index.php">Home</a>
        <a href="community.php">Community</a>
        <a href="map.php">Trick-or-Treat Map</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="logout-btn">Logout</a>
            <?php if ($_SESSION['is_admin'] ?? false): ?>
                <a href="admin/manage_reports.php">Admin Panel</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<body>