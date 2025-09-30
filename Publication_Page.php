<?php 
include("path.php");
include("connect.php");

// Filter input
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

// Count total posts for pagination
$countQuery = "SELECT COUNT(*) AS total FROM posts WHERE 1";
if ($search !== '') {
    $countQuery .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR content LIKE '%$search%')";
}
if ($category !== '') {
    $countQuery .= " AND category = '$category'";
}
$countResult = mysqli_query($conn, $countQuery);
$total_rows = mysqli_fetch_assoc($countResult)['total'];
$total_pages = ceil($total_rows / $limit);

// Main query
$query = "SELECT * FROM posts WHERE 1";
if ($search !== '') {
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR content LIKE '%$search%')";
}
if ($category !== '') {
    $query .= " AND category = '$category'";
}
$query .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Publications | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/publication.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

<!-- Footer Header -->
<footer class="footer">
  <div class="footer-logo">
    <img src="App/Database/Images/IWD LOGO new.png" alt="IWD Logo" />
  </div>
  <div class="footer-center">
    <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
  </div>
  <div class="footer-links">
    <a href="index.php">Home</a>
    <a href="Publication_Page.php">Publications</a>
    <a href="#">Services</a>
    <a href="#">Videos</a>
  </div>
</footer>

<!-- Main Layout -->
<div class="main-wrapper">

  <!-- Left: Publications -->
  <section class="publications-section">
    <h2 class="publications-heading">Publications</h2>
    <p class="publications-intro">
      Welcome to our publications page! Explore insightful articles, data-driven stories, and expert perspectives on public policy, innovation, economy, and more.
    </p>

    <!-- Filter Form -->
    <div class="filter-bar">
      <form method="GET">
        <input type="text" name="search" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="category">
          <option value="">All Topics</option>
          <option value="Economy" <?php if($category == 'Economy') echo 'selected'; ?>>Economy</option>
          <option value="Finance" <?php if($category == 'Finance') echo 'selected'; ?>>Finance</option>
          <option value="Infrastructure" <?php if($category == 'Infrastructure') echo 'selected'; ?>>Infrastructure</option>
          <option value="Budget" <?php if($category == 'Budget') echo 'selected'; ?>>Budget</option>
        </select>
        <button type="submit">Filter</button>
      </form>
    </div>

    <!-- Publications List -->
    <div class="publication-list">
      <?php
      if ($result && mysqli_num_rows($result) > 0):
        while ($post = mysqli_fetch_assoc($result)):
          $image = !empty($post['image']) ? 'Uploads/' . $post['image'] : 'App/Database/Images/IWD LOGO.jpg';
          $formattedDate = date("F j, Y", strtotime($post['created_at']));
          $isNew = (strtotime('now') - strtotime($post['created_at'])) < 2 * 24 * 3600;
      ?>
        <div class="publication-item">
          <img src="<?php echo $image; ?>" alt="Post Image" class="publication-image" />
          <div class="publication-content">
            <h3 class="publication-title">
              <a href="article.php?id=<?php echo $post['id']; ?>">
                <?php echo htmlspecialchars($post['title']); ?>
                <?php if ($isNew): ?>
                  <span class="new-label">NEW</span>
                <?php endif; ?>
              </a>
            </h3>
            <p class="publication-description"><?php echo htmlspecialchars($post['description']); ?></p>
            <p class="publication-date"><em>Posted on <?php echo $formattedDate; ?></em></p>
          </div>
        </div>
      <?php endwhile; else: ?>
        <p style="text-align:center;">No publications found.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $page - 1 ?>">&laquo; Previous</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $page + 1 ?>">Next &raquo;</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </section>

  <!-- Right: Adverts -->
  <aside class="advert-right-box">
    <h3 class="advert-title">ADVERTS</h3>
    <?php
    $adQuery = "SELECT image FROM adverts ORDER BY created_at DESC LIMIT 2";
    $adResult = mysqli_query($conn, $adQuery);

    if ($adResult && mysqli_num_rows($adResult) > 0):
      while ($adRow = mysqli_fetch_assoc($adResult)):
    ?>
      <div class="advert-box">
        <img src="App/Database/Images/<?php echo htmlspecialchars($adRow['image']); ?>" alt="Advert" class="advert-image" />
      </div>
    <?php endwhile; else: ?>
      <p>No adverts yet.</p>
    <?php endif; ?>
  </aside>
</div>

<!-- Footer Bottom -->
<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</body>
</html>
