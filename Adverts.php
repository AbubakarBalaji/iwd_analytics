<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "iwd_analytics";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['advert_image'])) {
    $image = $_FILES['advert_image']['name'];
    $target = "App/Database/Images/" . basename($image);

    if (move_uploaded_file($_FILES['advert_image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO adverts (image, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $image);
        if ($stmt->execute()) {
            $msg = "Advert uploaded successfully!";
        } else {
            $msg = "DB Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = "Failed to upload image.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Advert</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Insight with Data</title>
  <link rel="stylesheet" href="Assets\css\advert.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
 <footer class="footer">
    <div class="footer-logo">
      <img src="App\Database\Images\IWD LOGO new.png" alt="Left Logo" />
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
<div class="upload-container">
  <h2>Upload Advert Image</h2>
  <form method="POST" enctype="multipart/form-data">
      <input type="file" name="advert_image" required>
      <button type="submit">Upload</button>
  </form>
  <p><?php echo $msg; ?></p>
</div>
<p><?php echo $msg; ?></p>
</body>
  <!-- Bottom Info Section -->
  <div class="bottom-container">
    <div class="bottom-box">
      <h3>Contact Us</h3>
      <p>Email: supports@blynxgs.om</p>
      <p>Tel: +2347060872584</p>
    </div>

    <div class="bottom-box">
      <h3>Opening Hours</h3>
      <p>Mon - Fri: 9am - 6pm</p>
      <p>Remote Option: Available</p>
      <p>Global Access: Yes</p>
    </div>

    <div class="bottom-box">
      <h3>Quick Links</h3>
      <a href="#">About Us</a>
      <a href="#">Privacy Policy</a>
    </div>

    <div class="bottom-box">
      <h3>Support & Donations</h3>
      <a href="#donate">Donate Now</a><br>
      <a href="#Referrals">Referrals</a><br>
      <a href="#Recommendations">Recommendations</a><br>
      <a href="#Testimonials">Testimonials</a>
    </div>

    <div class="bottom-box">
      <h4>Follow Us</h4>
      <p>
        <a href="https://x.com/blynxgs" target="_blank"><i class="fab fa-x-twitter"></i> Twitter</a> |
        <a href="https://web.facebook.com/profile.php?id=61577595986433" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a><br>
        <a href="https://wa.me/qr/EE6TW2Z6KASBH1" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
        <a href="https://www.linkedin.com/company/blynxgs" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
      </p>
    </div>
  </div>

  <!-- Final Footer -->
  <div class="final-footer">
    <p>© 2025 Insights With Data | Powered by Blue Lynx Global Services</p>
  </div>

</body>
</html>

</html>
