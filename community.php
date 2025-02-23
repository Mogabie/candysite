<?php
session_start();
include 'includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user stats
$user_query = mysqli_query($conn, "SELECT username, profile_pic, 
    (SELECT COUNT(*) FROM posts WHERE user_id = users.id) AS post_count,
    (SELECT COUNT(*) FROM post_likes WHERE user_id = users.id) AS pumpkin_count,
    (SELECT COUNT(*) FROM friends WHERE user_id = users.id) AS friend_count,
    passing_out_candy, location, badges 
    FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// Fetch posts
$posts_query = mysqli_query($conn, "SELECT p.*, u.username, u.profile_pic, 
    (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) AS pumpkins 
    FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link rel="stylesheet" href="assets/css/community.css">
    <script src="assets/js/script.js" defer></script>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
            <img src="<?php echo $user['profile_pic'] ? htmlspecialchars($user['profile_pic']) : 'assets/images/default-profile.png'; ?>"
                class="profile-pic" alt="Profile Picture">
            <p>📬 Posts: <?php echo $user['post_count']; ?></p>
            <p>🎃 Pumpkins: <span id="user-pumpkins"><?php echo $user['pumpkin_count']; ?></span></p>
            <p>👥 Friends: <?php echo $user['friend_count']; ?></p>
            <p>🍬 Passing Out Candy: <?php echo $user['passing_out_candy'] ?? 'No'; ?></p>
            <p>📍 Location: <?php echo $user['location'] ?? 'Unknown'; ?></p>
            <p>📛 Badges: <?php echo $user['badges'] ?? 'None'; ?></p>
        </aside>

        <!-- Posts Section -->
        <div style="margin-top:50px;">
            <div class="post-form">
                <form action="add_post.php" method="POST" enctype="multipart/form-data">
                    <textarea name="content" placeholder="Say something..."></textarea>
                    <input type="file" name="image">
                    <input type="url" name="video_url" placeholder="YouTube or Rumble link">
                    <button type="submit">Post</button>
                </form>
            </div>

            <main class="posts">
                <?php while ($post = mysqli_fetch_assoc($posts_query)): ?>
                    <div class="post">
                        <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <?php if (!empty($post['image_url'])): ?>
                            <img src="<?php echo $post['image_url']; ?>" class="medium-image" onclick="expandImage(this)">
                        <?php endif; ?>
                        <?php if (!empty($post['video_url'])): ?>
                            <iframe src="<?php echo $post['video_url']; ?>" frameborder="0" allowfullscreen></iframe>
                        <?php endif; ?>
                        <div style="margin-top: 10px;">
                            <button style="font-size: 17px; border-radius: 5px; background: #A3EB1E;" class="like-button" data-post-id="<?php echo $post['id']; ?>"><span style="font-size: 30px;">🎃</span> <span
                                    class="like-count"><?php echo $post['pumpkins']; ?></span></button>
                            <?php if ($post['user_id'] == $user_id): ?>
                                <a style="font-size:17px;background: #A42CD6; padding: 4px 9px; border-radius: 5px; color:rgb(255, 255, 255); margin-left: 10px;" href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                                <a style="font-size:17px;background: #A42CD6; padding: 4px 9px; border-radius: 5px; color:rgb(255, 255, 255); margin-left: 10px;" href="delete_post.php?id=<?php echo $post['id']; ?>"
                                    onclick="return confirm('Delete this post?')">Delete</a>
                            <?php endif; ?>
                            <button style="font-size:17px;background:rgb(255, 0, 0); padding: 4px 9px; border-radius: 5px; border: 1px solid black; color:rgb(255, 255, 255); margin-left: 10px;" 
                                    class="report-btn" data-id="<?php echo $post['id']; ?>">Report</button>
                        </div>
                    </div>
                <?php endwhile; ?>
        </div>
        </main>
    </div>

    <script>
        document.querySelectorAll('.report-btn').forEach(button => {
            button.addEventListener('click', function () {
                let postId = this.getAttribute('data-id');
                let reason = prompt("Enter report reason:");

                if (!reason) {
                    alert("⚠️ Report reason is required.");
                    return;
                }

                fetch("submit_report.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "post_id=" + postId + "&reason=" + encodeURIComponent(reason)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ Report submitted!");
                    } else {
                        alert("❌ Error: " + data.error);
                    }
                })
                .catch(error => console.error("❌ Report submission error:", error));
            });
        });
    </script>

</body>

</html>
