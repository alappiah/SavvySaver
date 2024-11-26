<?php
session_start();
include("../db/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Sanitize inputs
        $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

        // Check if new passwords match
        if ($newPassword !== $confirmPassword) {
            echo "<script>alert('Passwords do not match. Please try again.'); window.history.back();</script>";
            exit();
        }

        // Validate new password strength
        if (strlen($newPassword) < 8) {
            echo "<script>alert('Password must be at least 8 characters long.'); window.history.back();</script>";
            exit();
        }

        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE team_project_users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashedNewPassword, $userId);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Password updated successfully! Redirecting to login page...');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            echo "<script>alert('Error updating password. Please try again later.'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('You are not logged in. Please log in to reset your password.'); window.location.href='login.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        <?php include '../assets/css/forgotpass.css'; ?>
    </style>
</head>
<body>
    <div class="row">
        <h1>Reset Password</h1>
        <h6 class="information-text">Enter your new password and confirm it to reset your password.</h6>
        <form action="" method="POST">
            <div class="form-group">
                <input type="password" name="new_password" id="new_password" required minlength="8">
                <p><label for="new_password">New Password</label></p>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" id="confirm_password" required minlength="8">
                <p><label for="confirm_password">Confirm Password</label></p>
            </div>
            <button type="submit">Reset Password</button>
        </form>
        <div class="footer">
            <h5>New here? <a href="register.php">Sign Up.</a></h5>
            <h5>Already have an account? <a href="login.php">Sign In.</a></h5>
        </div>
    </div>
</body>
</html>
