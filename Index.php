<?php 
include("path.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Insight with Data</title> 
  <link rel="stylesheet" href="Assets/css/index.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<?php include(ROOT_PATH."/App/includes/Header.php"); ?>

<!-- IWD Section -->
<div class="iwd-section">

  <!-- Left: Logo + Content -->
  <div class="iwd-left">
    <div class="iwd-image">
      <p>POWERED BY: BLUE LYNX GLOBAL SERVICES</p>
      <img src="App/Database/Images/BL LOGO.png" alt="IWD Logo" />
    </div>

    <div class="iwd-content"> 
      <h2 class="iwd-heading">IWD – Insight with Data</h2>
      <p class="iwd-subtext">Empowering you with smart decisions through data.</p>
      <p class="iwd-credit">A Blue Lynx Global Services Brand</p>
    </div>
  </div>

  <!-- Right: Advert -->
  <div class="iwd-advert">
    <h3 class="advert-title">ADVERT</h3>
    <img src="App/Database/Images/Advert Picture.png" alt="Advert Image" class="advert-image" />
  </div>

</div>


<!-- Top Stories & Adverts Section -->
<div class="top-stories-wrapper">
  <div class="top-stories-column">
    <h2 class="top-stories-heading">TOP STORIES</h2>
    <div class="story-grid">
      <?php
        $conn = new mysqli("localhost", "root", "", "iwd_analytics");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Pagination setup
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Count total posts
        $total_result = $conn->query("SELECT COUNT(*) AS total FROM posts");
        $total_rows = $total_result->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);

        // Fetch paginated posts
        $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
      ?>
      <div class="story-card">
        <a href="article.php?id=<?php echo $row['id']; ?>">
          <img src="Uploads/<?php echo htmlspecialchars($row['image']); ?>" class="story-image" alt="Story Image" />
        </a>
        <div class="story-content">
          <h3 class="story-title">
            <a href="article.php?id=<?php echo $row['id']; ?>">
              <?php echo htmlspecialchars($row['title']); ?>
            </a>
          </h3>
          <p class="story-description">
            <a href="article.php?id=<?php echo $row['id']; ?>" style="color: inherit; text-decoration: none;">
              <?php echo htmlspecialchars($row['description']); ?>
            </a>
          </p>
        </div>
      </div>
      <?php endwhile; else: ?>
        <p>No posts available.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Dynamic Advert Section -->
  <div class="top-stories-adverts">
    <h2 class="advert-title">ADVERTS</h2>
    <?php
      $adQuery = "SELECT image FROM adverts ORDER BY created_at DESC LIMIT 2";
      $adResult = $conn->query($adQuery);

      if ($adResult && $adResult->num_rows > 0):
          while ($adRow = $adResult->fetch_assoc()):
    ?>
      <div class="advert-box">
        <img src="App/Database/Images/<?php echo htmlspecialchars($adRow['image']); ?>" class="advert-img-full" alt="Advert" />
      </div>
    <?php endwhile; else: ?>
      <p>No adverts yet.</p>
    <?php endif; $conn->close(); ?>
  </div>
</div>

<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</body>
</html>
