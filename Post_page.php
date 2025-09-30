<?php
include("connect.php");
include("path.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create New Post</title>
  <link rel="stylesheet" href="Assets/css/Post_page.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
</head>
<body>

<!-- Header or Nav can be added here -->

<!-- Footer Top Navigation -->
<div class="footer">
  <div class="footer-center">
    <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
  </div>
  <div class="footer-links">
    <a href="http://localhost/IWD_Analytics/Admin.php">Home</a>
    <a href="http://localhost/IWD_Analytics/Post_page.php">New Post</a>
    <a href="http://localhost/IWD_Analytics/Adverts.php">Adverts</a>
    <a href="log_out.php" onclick="return confirm('Are you sure you want to logout?')" style="color: red;">Logout</a>
  </div>
</div>

<!-- Post Editor Section -->
<section class="post-editor">
  <h2>Create New Post</h2>

  <form id="postForm" method="POST" enctype="multipart/form-data" action="upload_post.php">
    <!-- Title -->
    <label for="postTitle">Title:</label>
    <input type="text" id="postTitle" name="postTitle" placeholder="Enter post title" required>

    <!-- Description -->
    <label for="postDescription">Description:</label>
    <input type="text" id="postDescription" name="postDescription" placeholder="Enter short description" required>

    <!-- Category -->
    <label for="postCategory">Category:</label>
    <select id="postCategory" name="postCategory" required>
      <option value="" disabled selected>-- Select Category --</option>
      <option value="Economy">Economy</option>
      <option value="Finance">Finance</option>
      <option value="Infrastructure">Infrastructure</option>
      <option value="Budget">Budget</option>
    </select>

    <!-- Content (CKEditor) -->
    <label for="postContent">Content:</label>
    <textarea id="postContent" name="postContent" rows="10" cols="80" required></textarea>
    <script>
      CKEDITOR.replace('postContent');
    </script>

    <!-- Image Upload -->
    <label for="postImage">Upload Image:</label>
    <input type="file" id="postImage" name="postImage" accept="image/*" required>

    <!-- Submit Button -->
    <button type="submit" class="upload-button">Upload Post</button>
  </form>
</section>

<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</body>
</html>
