<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch post data
$post_query = mysqli_prepare($conn, "SELECT content, image_url, video_url FROM posts WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($post_query, "ii", $post_id, $user_id);
mysqli_stmt_execute($post_query);
$result = mysqli_stmt_get_result($post_query);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("Error: Post not found or you do not have permission to edit it.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    $video_url = trim($_POST['video_url'] ?? '');
    $image_url = $post['image_url'];

    // Handle image upload if a new one is added
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = 'uploads/';
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_url = $target_file;
            } else {
                die("Error uploading image.");
            }
        } else {
            die("Error: Invalid image format. Only JPG, PNG, and GIF are allowed.");
        }
    }

    // Update the post
    $update_query = mysqli_prepare($conn, "UPDATE posts SET content = ?, image_url = ?, video_url = ? WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($update_query, "sssii", $content, $image_url, $video_url, $post_id, $user_id);
    mysqli_stmt_execute($update_query);

    header("Location: community.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="assets/css/community.css">
</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <form action="edit_post.php?id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data">
            <textarea name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
            <input type="file" name="image">
            <input type="url" name="video_url" placeholder="YouTube or Rumble link" value="<?php echo htmlspecialchars($post['video_url']); ?>">
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
