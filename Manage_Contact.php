<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: Authenticator.php");
    exit();
}

include("connect.php");
include("path.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle reply form submission
$replySuccess = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_message'])) {
    $to = $_POST['to_email'];
    $subject = "Re: Your message to IWD Analytics";
    $message = nl2br($_POST['reply_message']);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: abubakarabbaali2@gmail.com\r\n" .
                "Reply-To: abubakarabbaali2@gmail.com";

    if (mail($to, $subject, $message, $headers)) {
        $replySuccess = "Reply sent successfully to $to.";
    } else {
        $replySuccess = "Failed to send reply to $to.";
    }
}

// Fetch all messages
$messages = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Contact Messages</title>
    <link rel="stylesheet" href="Assets/css/manage_contact.css">
    <style>
.view-btn {
    display: inline-block;
    padding: 6px 10px;
    background: #007BFF;
    color: white;
    border-radius: 4px;
    text-decoration: none;
}
.view-btn:hover {
    background: #0056b3;
}
</style>

</head>
<body>
    <?php include(ROOT_PATH . "/App/includes/Header.php"); ?>

    <div class="container">
        <h1>Contact Messages</h1>

        <?php if ($replySuccess): ?>
            <div class="alert"><?= htmlspecialchars($replySuccess) ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($messages)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                      <td>
    <a href="View_Message.php?id=<?= $row['id'] ?>" class="view-btn">View</a>
</td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include(ROOT_PATH . "/App/includes/Footer.php"); ?>
</body>
</html>
