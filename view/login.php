<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/login-register.css" />
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h1>Login</h1>
            <form onsubmit="return validateForm()" action="../actions/login_user.php" METHOD="POST">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <span id="email-error" class="error-message"></span>

                <input type="password" name="password" id="password" placeholder="Password" required>
                <span id="password-error" class="error-message"></span>

                <div class="remember-forgot">
                    <label for="checkbox"><input type="checkbox" id="checkbox" name="remember">Remember Me</label>
                    <a href="#">Forget Your Password?</a>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="welcome-container">
                <h1 class="a">Welcome, Friend</h1>
                <p>Unleash your taste with SavvySaver</p>
                <a href="register.php">
                    <button type="submit">Create Account</button>
                </a>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            // Clear previous error messages
            document.getElementById('email-error').textContent = '';
            document.getElementById('password-error').textContent = '';

            let isValid = true;

            // Validate Email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (email === "") {
                document.getElementById('email-error').textContent = "Email is required";
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = "Please enter a valid email";
                isValid = false;
            }

            // Validate Password
            const password = document.getElementById('password').value.trim();
            const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#\$%\^&\*]).{8,}$/;

            if (password === "") {
                document.getElementById('password-error').textContent = "Password is required";
                isValid = false;
            } else if (!passwordRegex.test(password)) {
                document.getElementById('password-error').textContent = "Please enter a valid password";
                isValid = false;
            }

            return isValid; // Prevent form submission if validation fails
        }

        // Clear error messages when the user interacts with the email input field
        document.getElementById('email').addEventListener('input', function () {
            document.getElementById('email-error').textContent = '';
        });



        // Validate email and show error messages while typing
        document.getElementById('email').addEventListener('input', function () {
            const email = this.value.trim();
            const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            document.getElementById('email-error').textContent = ''; // Clear previous error message

            if (email !== "" && !emailRegex.test(email)) {
                document.getElementById('email-error').textContent = "Please enter a valid email";
            }
        });

        // Validate password and show error messages while typing
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value.trim();
            const passwordRegex = /^(?=.*[A-Z])(?=(?:[^0-9]*[0-9]){3})(?=.*[!@#\$%\^&\*]).{8,}$/;
            document.getElementById('password-error').textContent = ''; // Clear previous error message

            if (password !== "" && !passwordRegex.test(password)) {
                document.getElementById('password-error').textContent = "Please enter a valid password";
            }
        });
    </script>
</body>
</html>