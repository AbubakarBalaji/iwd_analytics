<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO authors (name, position, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $position, $email, $phone, $password);
    $stmt->execute();
    echo "Author registered successfully.";
}
?>

<form method="post">
  Name: <input type="text" name="name"><br>
  Position: <input type="text" name="position"><br>
  Email: <input type="email" name="email"><br>
  Phone: <input type="text" name="phone"><br>
  Password: <input type="password" name="password"><br>
  <button type="submit">Register</button>
</form>
