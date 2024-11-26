<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Token</title>
    <style>
        <?php include '../assets/css/forgotpass.css'; ?>
    </style>
</head>
<body>
    <div class="row">
        <h1>Enter Token</h1>
        <h6 class="information-text">Enter the token sent to your email to reset your password.</h6>
        <div class="form-group">
            <input type="text" name="token" id="token" required>
            <p><label for="token">Token</label></p>
            <button onclick="verifyToken()">Submit</button>
        </div>
        <div class="footer">
            <h5>New here? <a href="register.php">Sign Up.</a></h5>
            <h5>Already have an account? <a href="login.php">Sign In.</a></h5>
        </div>
    </div>
    <script>
        // Function to verify token
        function verifyToken() {
            const token = document.getElementById('token').value;

            if (!token) {
                alert('Please enter the token.');
                return;
            }

            // Simulate token verification (replace this with your backend verification logic)
            alert('Token verified! Redirecting to password reset page...');

            // Redirect to password reset page
            window.location.href = 'reset_password.php'; // Replace with your actual password reset page URL
        }
    </script>
</body>
</html>
