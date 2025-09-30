<?php
include("connect.php");
include("path.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid advert ID.";
    exit();
}

$id = intval($_GET['id']);
$msg = "";

// Fetch current advert
$query = $conn->prepare("SELECT * FROM adverts WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$advert = $result->fetch_assoc();

if (!$advert) {
    echo "Advert not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['advert_image'])) {
    $newImage = $_FILES['advert_image']['name'];
    $target = "App/Database/Images/" . basename($newImage);

    if (move_uploaded_file($_FILES['advert_image']['tmp_name'], $target)) {
        $update = $conn->prepare("UPDATE adverts SET image = ?, created_at = NOW() WHERE id = ?");
        $update->bind_param("si", $newImage, $id);
        if ($update->execute()) {
            $msg = "Advert updated successfully!";
            $advert['image'] = $newImage; // Update current image shown
        } else {
            $msg = "Update failed: " . $update->error;
        }
        $update->close();
    } else {
        $msg = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Advert | Insight with Data</title>
  <link rel="stylesheet" href="Assets\css\edit_advert.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
 <footer class="footer">
  <div class="footer-logo">
      <img src="App/Database/Images/IWD LOGO new.png" alt="Left Logo" />
    </div>
    <div class="footer-center">
      <h2>INSIGHT WITH DATA ANALYTICS – DATA STORY TELLING</h2>
    </div>
    <div class="footer-links">
       <a href="http://localhost/IWD_Analytics/index.php">Public</a>
       <a href="http://localhost/IWD_Analytics/Authenticator.php">Manage Post</a>
       <a href="http://localhost/IWD_Analytics/manage_adverts.php">Manage Advert</a>
       <a href="#videos">Manage Site</a>
     </div>
  </footer>
  <div class="center-wrapper"><div class="container">
  <h2>Edit Advert</h2>

  <?php if (!empty($msg)): ?>
    <p class="message"><?php echo $msg; ?></p>
  <?php endif; ?>

  <div class="edit-preview">
    <p><strong>Current Image:</strong></p>
    <img src="App/Database/Images/<?php echo htmlspecialchars($advert['image']); ?>" class="thumbnail" alt="Current Advert">
  </div>

  <form method="POST" enctype="multipart/form-data">
    <label for="advert_image">Select New Image:</label><br>
    <input type="file" name="advert_image" id="advert_image" required><br><br>
    <button type="submit">Update Advert</button>
  </form>

  <br><a href="manage_adverts.php" style="text-decoration:none;">← Back to Manage Adverts</a>
 
</div>
 </div>
 
</body>

<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</html>
