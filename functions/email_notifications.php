<?php
require '../db/database.php';
require '../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('User not logged in.');
            window.location.href = '../view/login.php';
          </script>";
    exit;
}

// Retrieve logged-in user's user_id
$userId = $_SESSION['user_id'];

// Check if the user has enabled email notifications
$preferenceQuery = "SELECT email_notifications FROM team_project_users WHERE user_id = ?";
$preferenceStmt = $conn->prepare($preferenceQuery);
$preferenceStmt->bind_param("i", $userId);
$preferenceStmt->execute();
$preferenceResult = $preferenceStmt->get_result();
$userPreference = $preferenceResult->fetch_assoc();

// If user has disabled email notifications
if (!$userPreference || !$userPreference['email_notifications']) {
    echo "<script>alert('User has disabled email notifications.');</script>";
    exit;
}

// Query to fetch food items expiring in the next 14 days
$query = "
    SELECT item_name, expiration_date 
    FROM team_project_food_items 
    WHERE user_id = ? 
    AND expiration_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY) 
    ORDER BY expiration_date ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Email content generation
$emailBody = "<h1>Food Items Expiring Soon</h1><ul>";
foreach ($notifications as $notification) {
    $emailBody .= "<li>'" . htmlspecialchars($notification['item_name']) . "' expires on " . htmlspecialchars($notification['expiration_date']) . "</li>";
}
$emailBody .= "</ul>";

if (empty($notifications)) {
    $emailBody = "<h1>No food items are expiring in the next 14 days!</h1>";
}

// Set up PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'saversavvy400@gmail.com'; // Your email
    $mail->Password = 'rnpbldhmiaqtcfvn'; // Your email password (use environment variables in production)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('saversavvy400@gmail.com', 'SavvySaver');
    $mail->addAddress($_SESSION['email']); // Send to the logged-in user

    $mail->isHTML(true);
    $mail->Subject = 'Food Items Expiring Soon';
    $mail->Body    = $emailBody;
    $mail->AltBody = strip_tags(str_replace('</li>', "\n", str_replace('<li>', "- ", $emailBody)));

    $mail->send();
    echo "<script>
            alert('Notification sent successfully!');
            window.location.href = '../view/inventory.php';
        </script>";
} catch (Exception $e) {
    echo "<script>
            alert('Mailer Error: " . addslashes($mail->ErrorInfo) . "');
            window.location.href = '../view/inventory.php';
        </script>";
}

$stmt->close();
$conn->close();

?>
