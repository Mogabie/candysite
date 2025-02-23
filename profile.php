<?php
session_start();
include 'includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch profile owner's details
$user_query = mysqli_query($conn, "SELECT username, profile_pic, banner, banner_position, bio, location, passing_out_candy, 
    (SELECT COUNT(*) FROM posts WHERE user_id = users.id) AS post_count,
    (SELECT COUNT(*) FROM post_likes WHERE user_id = users.id) AS pumpkin_count,
    (SELECT COUNT(*) FROM friends WHERE user_id = users.id) AS friend_count,
    badges FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// **Fix Banner Path**
$banner = !empty($user['banner']) ? "uploads/" . htmlspecialchars($user['banner']) : "assets/images/default-cover.png";
$banner_position = isset($user['banner_position']) ? intval($user['banner_position']) : 50;

// Fetch Public Feed Posts
$posts_query = mysqli_query($conn, "SELECT p.*, u.username, u.profile_pic, 
    (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) AS pumpkins 
    FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Feed</title>
    <link rel="stylesheet" href="assets/css/profile.css">
    <script src="assets/js/script.js" defer></script>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <!-- Profile Banner -->
    <div class="profile-banner" id="profile-banner"
        style="background-image: url('<?= $banner; ?>?t=<?= time(); ?>'); background-position: center <?= $banner_position; ?>%;">
        
        <?php if ($user_id === $_SESSION['user_id']): ?>
            <div class="edit-cover-container">
                <button id="edit-cover-btn">Edit Cover ▼</button>
                <div class="edit-cover-dropdown">
                    <button id="move-cover-btn">Move Banner</button>
                    <form action="upload_banner.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="banner" accept="image/*">
                        <button type="submit">Upload New</button>
                    </form>
                    <button id="delete-banner-btn">Delete Banner</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="profile-container">
        <!-- Sidebar with Stats -->
        <aside class="sidebar">
            <img src="<?= !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'assets/images/default-profile.png'; ?>" class="profile-pic" alt="Profile Picture">
            <h2><?= htmlspecialchars($user['username']); ?></h2>
            <p>📍 Location: <?= $user['location'] ?? 'Unknown'; ?></p>
            <p>🍬 Passing Out Candy: <?= $user['passing_out_candy'] ? 'Yes' : 'No'; ?></p>
            <p>📝 Bio: <?= htmlspecialchars($user['bio'] ?? 'No bio yet.'); ?></p>
            <a href="edit_profile.php">Edit Profile</a>

            <hr>
            <p>📬 Posts: <?= $user['post_count']; ?></p>
            <p>🎃 Pumpkins: <?= $user['pumpkin_count']; ?></p>
            <p>👥 Friends: <?= $user['friend_count']; ?></p>
            <p>📛 Badges: <?= $user['badges'] ?? 'None'; ?></p>
        </aside>

        <!-- Posts Section (Public Feed) -->
        <main class="posts">
            <form action="add_post.php" method="POST" enctype="multipart/form-data" class="post-form">
                <textarea name="content" placeholder="Say something..."></textarea>
                <input type="file" name="image">
                <input type="url" name="video_url" placeholder="YouTube or Rumble link">
                <button type="submit">Post</button>
            </form>

            <?php while ($post = mysqli_fetch_assoc($posts_query)): ?>
                <div class="post <?= ($post['user_id'] == $user_id) ? 'user-post' : ''; ?>">
                    <h3><?= htmlspecialchars($post['username']); ?></h3>
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (!empty($post['image_url'])): ?>
                        <img src="<?= $post['image_url']; ?>" class="medium-image" onclick="expandImage(this)">
                    <?php endif; ?>
                    <?php if (!empty($post['video_url'])): ?>
                        <iframe src="<?= $post['video_url']; ?>" frameborder="0" allowfullscreen></iframe>
                    <?php endif; ?>
                    <button class="like-button" data-post-id="<?= $post['id']; ?>">🎃 <span class="like-count"><?= $post['pumpkins']; ?></span></button>
                    <?php if ($post['user_id'] == $user_id): ?>
                        <a href="edit_post.php?id=<?= $post['id']; ?>">Edit</a>
                        <a href="delete_post.php?id=<?= $post['id']; ?>" onclick="return confirm('Delete this post?')">Delete</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </main>
    </div>
</body>

</html>
