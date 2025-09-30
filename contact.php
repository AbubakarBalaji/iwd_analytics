<?php 
include("path.php");
include("connect.php"); // make sure this connects to your database

error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $email = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $query = "INSERT INTO contact_messages (name, email, message) 
                  VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $query)) {
            $success = "Thank you for contacting us!";
            $name = $email = $message = ""; // Clear fields
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        $error = "Please fill all the fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - IWD Analytics</title>
  <link rel="stylesheet" href="Assets/css/contact.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<?php include(ROOT_PATH . "/App/includes/Header.php"); ?>

<section class="services-hero">
  <div class="hero-flex-container">
    <h1>Get in Touch</h1>
  </div>
</section>

<section class="contact-section-wrapper">
  <div class="contact-box-group">
    <div class="top-row">
      <div class="service-box">
        <h2><i class="fas fa-envelope"></i> Call Us</h2>
        <p>You can give us a direct call on:</p>
        <p><strong> +23470608872584</strong></p>
      </div>

      <div class="service-box">
        <h2><i class="fab fa-whatsapp"></i> WhatsApp</h2>
        <p>Reach us instantly on WhatsApp:</p>
        <p>
          <a href="https://wa.me/2347060872584" target="_blank" style="color:#25D366; font-weight:bold;">
            +2347060872584
          </a>
        </p>
      </div>
    </div>

    <div class="form-row">
      <div class="service-box form-full-width">
        <h2><i class="fas fa-paper-plane"></i> Contact Form</h2>

        <!-- Success/Error Message -->
        <?php if ($success): ?>
          <p style="color: green; text-align: center; font-weight: bold;"><?= $success ?></p>
        <?php elseif ($error): ?>
          <p style="color: red; text-align: center; font-weight: bold;"><?= $error ?></p>
        <?php endif; ?>

        <form action="" method="post" class="contact-form">
          <input type="text" name="name" placeholder="Your Name" value="<?= htmlspecialchars($name) ?>" required />
          <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($email) ?>" required />
          <textarea name="message" placeholder="Your Message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include(ROOT_PATH . "/App/includes/Footer.php"); ?>
</body>
</html>
