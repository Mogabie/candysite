<?php
session_start();
include '../includes/config.php';

// Ensure user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

// Fetch reported posts and comments
$reported_posts = mysqli_query($conn, "SELECT p.id, p.content, u.username FROM reports r JOIN posts p ON r.content_id = p.id JOIN users u ON p.user_id = u.id WHERE r.type = 'post'");
$reported_comments = mysqli_query($conn, "SELECT c.id, c.comment, u.username FROM reports r JOIN comments c ON r.content_id = c.id JOIN users u ON c.user_id = u.id WHERE r.type = 'comment'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Reported Posts</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Post</th>
            <th>Actions</th>
        </tr>
        <?php while ($post = mysqli_fetch_assoc($reported_posts)): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['username']); ?></td>
                <td><?php echo htmlspecialchars($post['content']); ?></td>
                <td>
                    <button class="delete-btn" data-id="<?php echo $post['id']; ?>" data-type="post">🗑️ Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Reported Comments</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Comment</th>
            <th>Actions</th>
        </tr>
        <?php while ($comment = mysqli_fetch_assoc($reported_comments)): ?>
            <tr>
                <td><?php echo htmlspecialchars($comment['username']); ?></td>
                <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                <td>
                    <button class="delete-btn" data-id="<?php echo $comment['id']; ?>" data-type="comment">🗑️ Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script src="../assets/js/admin.js"></script>
</body>
</html>
