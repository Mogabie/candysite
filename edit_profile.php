<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$user_query = mysqli_query($conn, "SELECT username, profile_pic, banner, banner_position, bio, location, passing_out_candy FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $bio = trim($_POST['bio']);
    $location = trim($_POST['location']);
    $passing_out_candy = isset($_POST['passing_out_candy']) ? 1 : 0;
    $cover_position = trim($_POST['cover_position']);

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $upload_dir = 'uploads/';
        $profile_pic_name = time() . "_" . basename($_FILES['profile_pic']['name']);
        $profile_target_file = $upload_dir . $profile_pic_name;
        
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_target_file)) {
            $profile_pic = $profile_target_file;
        } else {
            die("Error uploading profile picture.");
        }
    } else {
        $profile_pic = $user['profile_pic'];
    }

    // Handle cover photo upload
    if (!empty($_FILES['banner']['name'])) {
        $banner_name = time() . "_" . basename($_FILES['banner']['name']);
        $cover_target_file = $upload_dir . $banner_name;
        
        if (move_uploaded_file($_FILES['banner']['tmp_name'], $cover_target_file)) {
            $banner = $cover_target_file;
        } else {
            die("Error uploading cover photo.");
        }
    } else {
        $banner = $user['banner'];
    }

    // Update user info
    $update_query = mysqli_prepare($conn, "UPDATE users SET username = ?, profile_pic = ?, banner = ?, banner_position = ?, bio = ?, location = ?, passing_out_candy = ? WHERE id = ?");
    mysqli_stmt_bind_param($update_query, "ssssssii", $username, $profile_pic, $banner, $cover_position, $bio, $location, $passing_out_candy, $user_id);
    mysqli_stmt_execute($update_query);

    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="assets/css/edit_profile.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label>Profile Picture:</label>
            <input type="file" name="profile_pic">

            <label>Cover Photo:</label>
            <input type="file" name="banner">

            <label>Cover Position (Adjust Vertical Position %):</label>
            <input type="number" name="cover_position" value="<?php echo htmlspecialchars($user['cover_position'] ?? '50'); ?>" min="0" max="100">

            <label>Bio:</label>
            <textarea name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>

            <label>Location:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($user['location']); ?>">

            <label>Passing Out Candy:</label>
            <input type="checkbox" name="passing_out_candy" <?php echo $user['passing_out_candy'] ? 'checked' : ''; ?>>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
