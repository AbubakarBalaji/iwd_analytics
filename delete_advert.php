<?php
include("connect.php");
include("path.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid advert ID.";
    exit();
}

$id = intval($_GET['id']);

// Fetch advert to delete its image file as well
$query = $conn->prepare("SELECT image FROM adverts WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$advert = $result->fetch_assoc();

if (!$advert) {
    echo "Advert not found.";
    exit();
}

// Delete advert from DB
$delete = $conn->prepare("DELETE FROM adverts WHERE id = ?");
$delete->bind_param("i", $id);
if ($delete->execute()) {
    // Delete image file if exists
    $imagePath = "App/Database/Images/" . $advert['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    header("Location: manage_adverts.php?msg=Advert deleted successfully");
    exit();
} else {
    echo "Error deleting advert: " . $delete->error;
}
?>
