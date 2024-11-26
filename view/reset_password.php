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
        <form id="reset-password-form" onsubmit="return resetPassword()">
            <div class="form-group">
                <input type="password" name="new_password" id="new_password" required>
                <p><label for="new_password">New Password</label></p>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <p><label for="confirm_password">Confirm Password</label></p>
            </div>
            <button type="submit">Reset Password</button>
        </form>
        <div class="footer">
            <h5>New here? <a href="register.php">Sign Up.</a></h5>
            <h5>Already have an account? <a href="login.php">Sign In.</a></h5>
        </div>
    </div>
    <script>
        // Function to handle password reset
        function resetPassword() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            // Validate passwords
            if (!newPassword || !confirmPassword) {
                alert('Please fill out both fields.');
                return false;
            }
            if (newPassword !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return false;
            }

            // Simulate password reset request (replace with backend logic)
            alert('Password has been successfully reset! Redirecting to login page...');

            // Redirect to login page
            window.location.href = 'login.php'; // Replace with your actual login page URL
            return false; // Prevent form submission for demo purposes
        }
    </script>
</body>
</html>
