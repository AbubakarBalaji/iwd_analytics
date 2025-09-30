<?php
include("path.php");
include("connect.php");
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: Authenticator.php");
    exit();
}

// Default message
$msg = "";
$success = false;

// Check if valid ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $postId = (int)$_GET['id'];

    // Fetch post to get image name
    $query = "SELECT image FROM posts WHERE id = $postId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $post = mysqli_fetch_assoc($result);

        // Delete image file
        $imagePath = "Uploads/" . $post['image'];
        if (!empty($post['image']) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the post record
        $deleteQuery = "DELETE FROM posts WHERE id = $postId";
        if (mysqli_query($conn, $deleteQuery)) {
            $msg = "Post deleted successfully.";
            $success = true;
        } else {
            $msg = "Error deleting post: " . mysqli_error($conn);
        }
    } else {
        $msg = "Post not found.";
    }
} else {
    $msg = "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Post | Insight with Data</title>
  <meta http-equiv="refresh" content="3;url=Manage_Post.php" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f8;
      text-align: center;
      padding: 60px;
    }
    .message-box {
      max-width: 500px;
      margin: auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    .success {
      color: green;
    }
    .error {
      color: red;
    }
    .icon {
      font-size: 48px;
      margin-bottom: 15px;
    }
    a.back-link {
      display: inline-block;
      margin-top: 20px;
      color: #3b6ca8;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="message-box">
  <div class="icon">
    <i class="fas <?php echo $success ? 'fa-check-circle success' : 'fa-exclamation-triangle error'; ?>"></i>
  </div>
  <h2 class="<?php echo $success ? 'success' : 'error'; ?>">
    <?php echo $msg; ?>
  </h2>
  <p>You will be redirected to the Manage Posts page shortly...</p>
  <a class="back-link" href="Manage_Post.php">Go back manually</a>
</div>

</body>
</html>
