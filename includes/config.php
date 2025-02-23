<?php
// Database Configuration
$host = 'localhost'; // Change if using a different host
$user = 'root'; // Default XAMPP user
$pass = ''; // Default XAMPP password is empty
$dbname = 'halloweendb'; // Your database name

// Debug mode (set to false in production)
$debug_mode = true;

// Connect to MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Improved Error Handling
if (!$conn) {
    error_log("❌ Database Connection Failed: " . mysqli_connect_error());
    
    // Display error only if in debug mode
    if ($debug_mode) {
        die("Database Connection Failed: " . mysqli_connect_error());
    } else {
        die("Database connection issue. Please contact support.");
    }
}

// Uncomment the following block to use PDO instead of MySQLi for better security
/*
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("❌ PDO Connection Failed: " . $e->getMessage());
    die("Database connection issue. Please contact support.");
}
*/
?>

