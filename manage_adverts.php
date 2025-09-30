<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: Authenticator.php");
    exit();
}

include("connect.php");
include("path.php");

// Handle status toggle
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get current status from DB
    $statusResult = $conn->query("SELECT status FROM adverts WHERE id = $id");
    if ($statusResult && $statusResult->num_rows === 1) {
        $currentStatus = $statusResult->fetch_assoc()['status'];
        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';

        // Update status
        $conn->query("UPDATE adverts SET status = '$newStatus' WHERE id = $id");
    }

    header("Location: manage_adverts.php");
    exit();
}

// Handle search filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT * FROM adverts";
if (!empty($search)) {
    $query .= " WHERE image LIKE '%$search%'";
}
$query .= " ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Adverts | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/Manage_Advert.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 8px;
    }
    h2 {
      text-align: center;
      color: #0b2a5b;
    }
    p.intro {
      text-align: center;
      margin-bottom: 20px;
      color: #555;
    }
    form.search-form {
      text-align: center;
      margin-bottom: 20px;
    }
    input[name="search"] {
      padding: 8px 12px;
      width: 250px;
    }
    .advert-table {
      width: 100%;
      border-collapse: collapse;
    }
    .advert-table th, .advert-table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }
    .advert-table th {
      background-color: #3b6cc5;
      color: white;
    }
    .advert-table img.thumbnail {
      width: 100px;
      cursor: pointer;
      border-radius: 4px;
    }
    .icon-btn {
      margin: 0 5px;
      font-size: 18px;
      text-decoration: none;
      transition: 0.3s;
    }
    .icon-btn:hover {
      transform: scale(1.2);
    }
    .view { color: green; }
    .edit { color: #0077cc; }
    .delete { color: red; }
    .toggle { color: orange; }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.7);
    }
    .modal-content {
      margin: 10% auto;
      padding: 20px;
      background: white;
      width: 50%;
      text-align: center;
      border-radius: 8px;
    }
    .modal-content img {
      width: 100%;
      max-height: 500px;
      object-fit: contain;
    }
    .close-modal {
      float: right;
      font-size: 24px;
      color: red;
      cursor: pointer;
    }
  </style>
</head>
<body>

<!-- Footer/Header -->
<footer class="footer">
  <div class="footer-logo">
    <img src="App/Database/Images/IWD LOGO new.png" alt="IWD Logo">
  </div>
  <div class="footer-center">
    <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
  </div>
  <div class="footer-links">
    <a href="Admin.php">Admin Home</a>
    <a href="Adverts.php">Upload Advert</a>
    <a href="Manage_Post.php">Manage Posts</a>
    <a href="log_out.php" onclick="return confirm('Are you sure you want to logout?')" style="color: red;">Logout</a>
  </div>
</footer>

<!-- Container -->
<div class="container">
  <h2>Manage Uploaded Adverts</h2>
  <p class="intro">View, update, activate, or delete adverts you've uploaded.</p>

  <form class="search-form" method="GET">
    <input type="text" name="search" placeholder="Search by image name..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
  </form>

  <?php if ($result && $result->num_rows > 0): ?>
  <table class="advert-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Status</th>
        <th>Uploaded</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td>
          <img src="App/Database/Images/<?php echo htmlspecialchars($row['image']); ?>"
               class="thumbnail"
               alt="Advert"
               onclick="openModal('App/Database/Images/<?php echo htmlspecialchars($row['image']); ?>')">
        </td>
        <td>
          <?php echo $row['status'] ?? 'inactive'; ?>
        </td>
        <td><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></td>
        <td>
          <a href="#" class="icon-btn view" onclick="openModal('App/Database/Images/<?php echo htmlspecialchars($row['image']); ?>')" title="View">
            <i class="fas fa-eye"></i>
          </a>
          <a href="edit_advert.php?id=<?php echo $row['id']; ?>" class="icon-btn edit" title="Edit">
            <i class="fas fa-edit"></i>
          </a>
          <a href="delete_advert.php?id=<?php echo $row['id']; ?>" class="icon-btn delete" title="Delete" onclick="return confirm('Delete this advert?')">
            <i class="fas fa-trash-alt"></i>
          </a>


        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p style="text-align:center;">No adverts found.</p>
  <?php endif; ?>
</div>

<!-- Modal Preview -->
<div id="imageModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="" alt="Preview">
  </div>
</div>

<script>
  function openModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').style.display = 'block';
  }

  function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
  }

  window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>

<?php include(ROOT_PATH . "/App/includes/Footer.php"); ?>
</body>
</html>
