<?php
include("path.php");
include("connect.php");

// Fetch Counts from Real Tables
$post_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];
$advert_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM adverts"))['total'];
$author_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM authors"))['total'];
$comment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/Admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Header/Footer Section -->
  <footer class="footer">
    <div class="footer-logo">
      <img src="App/Database/Images/IWD LOGO new.png" alt="Left Logo" />
    </div>
    <div class="footer-center">
      <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
    </div>
    <div class="footer-links">
      <a href="index.php">Public</a>
      <a href="Authenticator.php">Manage Post</a>
      <a href="Manage_Contact.php">Inbox</a>
    </div>
  </footer>

  <!-- IWD Branding Section -->
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

  <!-- Admin Dashboard Summary -->
  <section class="dashboard-section">
    <h2 class="dashboard-heading">Admin Dashboard Summary</h2>
    <div class="dashboard-cards">
      <div class="dashboard-card">
        <i class="fas fa-newspaper"></i>
        <h3>Total Posts</h3>
        <p><?php echo $post_count; ?></p>
      </div>
      <div class="dashboard-card">
        <i class="fas fa-bullhorn"></i>
        <h3>Total Adverts</h3>
        <p><?php echo $advert_count; ?></p>
      </div>
      <div class="dashboard-card">
        <i class="fas fa-user-edit"></i>
        <h3>Authors</h3>
        <p><?php echo $author_count; ?></p>
      </div>
      <div class="dashboard-card">
        <i class="fas fa-comments"></i>
        <h3>Comments</h3>
        <p><?php echo $comment_count; ?></p>
      </div>
      <div class="dashboard-card">
        <i class="fas fa-user-shield"></i>
        <h3>Admin Users</h3>
        <p><?php echo $user_count; ?></p>
      </div>
    </div>
  </section>

</body>
<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</html>
