<?php
include("path.php");
include("connect.php");
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM log_in_table WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username']; // Use consistent key
            header("Location: Manage_Post.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Insight with Data</title>
  <link rel="stylesheet" href="Assets/css/Authenticator.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
 <?php include(ROOT_PATH."/App/includes/Header.php"); ?>

  <!-- Login Box -->
  <div class="login-container">
    <div class="login-box">
      <h2>Login to Insight with Data</h2>
      <form method="POST">
        <div class="input-group">
          <label for="username"><i class="fa fa-user"></i> Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>

        <div class="input-group">
          <label for="password"><i class="fa fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
        </div>

        <button type="submit" name="login" class="login-button">Login</button>
      </form>
    </div>
  </div>

<?php include(ROOT_PATH."/App/includes/Footer.php"); ?>
</body>
</html>
