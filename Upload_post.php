<?php
include("connect.php"); // Make sure this file connects $conn to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data
    $title = $_POST['postTitle'];
    $description = $_POST['postDescription'];
    $category = $_POST['postCategory'];
    $content = $_POST['postContent'];

    // Handle image upload
    $imageName = time() . '_' . basename($_FILES['postImage']['name']); // Prevent file conflicts
    $uploadDir = "uploads/";
    $imagePath = $uploadDir . $imageName;

    // Move image to uploads folder
    if (move_uploaded_file($_FILES['postImage']['tmp_name'], $imagePath)) {
        // Save data into database (only filename for image)
        $stmt = $conn->prepare("INSERT INTO posts (title, description, category, content, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $category, $content, $imageName);
        $stmt->execute();
        $stmt->close();

        // Redirect to homepage
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to upload image.";
    }
}

$conn->close();
?>
