<?php
include("path.php");
include("connect.php");
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: Authenticator.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No post selected.";
    exit();
}

$postId = (int) $_GET['id'];
$msg = "";

// Fetch existing post
$sql = "SELECT * FROM posts WHERE id = $postId LIMIT 1";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) !== 1) {
    echo "Post not found.";
    exit();
}

$post = mysqli_fetch_assoc($result);

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = $post['image']; // default to old image

    // If a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        $newImage = $_FILES['image']['name'];
        $target = "Uploads/" . basename($newImage);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Delete old image file if exists
            $oldImagePath = "Uploads/" . $post['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $image = $newImage;
        } else {
            $msg = "Image upload failed. Keeping old image.";
        }
    }

    // Update DB
    $update = "UPDATE posts SET title='$title', description='$description', content='$content', category='$category', image='$image' WHERE id=$postId";
    if (mysqli_query($conn, $update)) {
        header("Location: Manage_Post.php?msg=Post+Updated+Successfully");
        exit();
    } else {
        $msg = "Error updating post: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Post | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/edit_post.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<div class="edit-container">
  <h2>Edit Post</h2>
  <?php if ($msg): ?>
    <p style="color: red;"><?php echo $msg; ?></p>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="3" required><?php echo htmlspecialchars($post['description']); ?></textarea>
    </div>

    <div class="form-group">
      <label>Content</label>
      <textarea name="content" rows="7" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>

    <div class="form-group">
      <label>Category</label>
      <select name="category" required>
        <option value="">-- Select Category --</option>
        <option value="Economy" <?php if($post['category'] == 'Economy') echo 'selected'; ?>>Economy</option>
        <option value="Finance" <?php if($post['category'] == 'Finance') echo 'selected'; ?>>Finance</option>
        <option value="Infrastructure" <?php if($post['category'] == 'Infrastructure') echo 'selected'; ?>>Infrastructure</option>
        <option value="Budget" <?php if($post['category'] == 'Budget') echo 'selected'; ?>>Budget</option>
      </select>
    </div>

    <div class="form-group">
      <label>Current Image</label><br>
      <img src="Uploads/<?php echo $post['image']; ?>" width="200" style="border: 1px solid #ccc;" alt="Post Image"><br><br>
      <input type="file" name="image">
    </div>

    <button type="submit" class="submit-btn">Update Post</button>
  </form>
  <br>
  <a href="Manage_Post.php" class="back-link">← Back to Manage Posts</a>
</div>
</body>
</html>
