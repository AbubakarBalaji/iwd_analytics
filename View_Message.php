<?php
include("path.php");
include("connect.php");

require './App/includes/PHPMailer/src/PHPMailer.php';
require './App/includes/PHPMailer/src/SMTP.php';
require './App/includes/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = $success = "";
$contact = null;

// Get the message to view
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM contact_messages WHERE id = $id LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $contact = mysqli_fetch_assoc($result);
    } else {
        $error = "Message not found.";
    }
} else {
    $error = "No message ID provided.";
}

// Handle the reply form
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reply'])) {
    $toEmail = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'supports@blynxgs.com'; // your Zoho email
        $mail->Password = 'AZ6dhdrtpR3J';  // your Zoho app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Timeout = 300;

        $mail->setFrom('supports@blynxgs.com', 'IWD Analytics');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);

        $mail->send();
        $success = "Reply sent successfully!";
    } catch (Exception $e) {
        $error = "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Message</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .section {
            margin-bottom: 30px;
        }
        input, textarea, button {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Contact Message</h2>

        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php elseif ($contact): ?>
            <div class="section">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($contact['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
                <p><strong>Message:</strong><br><?php echo nl2br(htmlspecialchars($contact['message'])); ?></p>
                <p><strong>Sent:</strong> <?php echo htmlspecialchars($contact['submitted_at'] ?? 'N/A'); ?></p>
            </div>

            <?php if ($success): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>

            <h3>Reply to this message</h3>
            <form method="POST">
                <label>Email To</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required readonly>

                <label>Subject</label>
                <input type="text" name="subject" required placeholder="Reply Subject">

                <label>Message</label>
                <textarea name="message" rows="6" required placeholder="Your reply here..."></textarea>

                <button type="submit" name="reply">Send Reply</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
