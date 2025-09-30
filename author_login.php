<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM authors WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($author = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $author['password'])) {
            $_SESSION['author_id'] = $author['id'];
            header("Location: post_page.php");
            exit();
        }
    }
    echo "Invalid credentials!";
}
?>

<form method="POST">
  <input name="email" type="email" placeholder="Email" required><br>
  <input name="password" type="password" placeholder="Password" required><br>
  <button type="submit">Login</button>
</form>
