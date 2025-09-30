<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: Authenticator.php");
    exit();
}
include("path.php");
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Posts | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/Manage_Post.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

<!-- Footer Header -->
<footer class="footer">
  <div class="footer-logo">
    <img src="App/Database/Images/IWD LOGO new.png" alt="Left Logo" />
  </div>

  <div class="footer-center">
    <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
  </div>

  <div class="footer-links">
    <a href="http://localhost/IWD_Analytics/Admin.php">Home</a>
    <a href="http://localhost/IWD_Analytics/Post_page.php">New Post</a>
    <a href="http://localhost/IWD_Analytics/Adverts.php">Adverts</a>
    <a href="log_out.php" onclick="return confirm('Are you sure you want to logout?')" style="color: red;">Logout</a>
  </div>
</footer>

<!-- IWD Section -->
<div class="iwd-section">
  <div class="iwd-content">
    <h2 class="iwd-heading">IWD – Insight with Data</h2>
    <p class="iwd-subtext">Empowering you with smart decisions through data.</p>
    <p class="iwd-credit">A Blue Lynx Global Services Brand</p>
  </div>

  <div class="iwd-image">
    <img src="App/Database/Images/BL LOGO.png" alt="IWD Image" />
  </div>

  <div class="iwd-advert">
    <h3 class="advert-title">ADVERT</h3>
    <img src="App/Database/Images/Advert Picture.png" alt="Advert Image" class="advert-image" />
  </div>
</div>

<!-- Manage Posts Section -->
<section class="manage-posts">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>! You can manage your posts below.</h2>

  <?php if (isset($_GET['msg'])): ?>
    <p class="flash-message"><?php echo htmlspecialchars($_GET['msg']); ?></p>
  <?php endif; ?>

  <table class="crud-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Description</th>
        <th>Category</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM posts ORDER BY created_at DESC";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
      ?>
      <tr>
        <td>
          <img src="Uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" style="width: 60px; border-radius: 4px;">
        </td>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo date("F j, Y", strtotime($row['created_at'])); ?></td>
        <td>
          <a href="article.php?id=<?php echo $row['id']; ?>" class="icon-btn" title="View Post"><i class="fas fa-eye" style="color: green;"></i></a>
          <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="icon-btn" title="Edit Post"><i class="fas fa-edit" style="color: orange;"></i></a>
          <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="icon-btn" title="Delete Post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash-alt" style="color: red;"></i></a>
        </td>
      </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="6" style="text-align:center;">No posts found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>

</body>
</html>
