document.addEventListener("DOMContentLoaded", function () {
    // Navigation functionality
    const navLinks = document.querySelectorAll(".side-nav ul li a");
    const sections = document.querySelectorAll(".section-content");

    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            // Highlight active link
            navLinks.forEach(nav => nav.classList.remove("active"));
            this.classList.add("active");

            // Show corresponding section
            sections.forEach(section => {
                section.classList.remove("active");
            });
            const targetSection = document.querySelector(this.getAttribute("href"));
            targetSection.classList.add("active");
        });
    });

    // Profile picture preview
    window.updateProfileImage = function (event) {
        const profileImagePreview = document.getElementById("profile-image-preview");
        const file = event.target.files[0];
        if (file) {
            profileImagePreview.src = URL.createObjectURL(file);
        }
    };

    // Theme preference
    const themeSelect = document.getElementById("theme");
    const applyPreferencesButton = document.getElementById("apply-preferences");

    applyPreferencesButton.addEventListener("click", function () {
        const theme = themeSelect.value;
        if (theme === "dark") {
            document.documentElement.style.setProperty("--background-color", "#1e1e1e");
            document.documentElement.style.setProperty("--text-color", "#f4f9ff");
            document.documentElement.style.setProperty("--main-bg", "#333");
        } else {
            document.documentElement.style.setProperty("--background-color", "#f4f9ff");
            document.documentElement.style.setProperty("--text-color", "#333");
            document.documentElement.style.setProperty("--main-bg", "white");
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const newPasswordField = document.getElementById("new-password");
    const confirmPasswordField = document.getElementById("confirm-password");
    const newPasswordError = document.getElementById("new-password-error");
    const confirmPasswordError = document.getElementById("confirm-password-error");

    const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#\$%\^&\*]).{8,}$/;

    // Validate password as the user types
    newPasswordField.addEventListener("input", function () {
        const password = this.value.trim();
        newPasswordError.textContent = ""; // Clear previous error message

        if (password !== "" && !passwordRegex.test(password)) {
            newPasswordError.textContent = "Password must be at least 8 characters long, contain an uppercase letter, at least 3 digits, and a special character.";
        }
    });

    // Validate confirm password
    confirmPasswordField.addEventListener("input", function () {
        const confirmPassword = this.value.trim();
        confirmPasswordError.textContent = ""; // Clear previous error message

        if (confirmPassword !== "" && confirmPassword !== newPasswordField.value.trim()) {
            confirmPasswordError.textContent = "Passwords do not match.";
        }
    });

    // Form submission validation
    document.getElementById("account-security-form").addEventListener("submit", function (e) {
        let isValid = true;

        // Validate new password
        const newPassword = newPasswordField.value.trim();
        if (newPassword === "") {
            newPasswordError.textContent = "Password is required";
            isValid = false;
        } else if (!passwordRegex.test(newPassword)) {
            newPasswordError.textContent = "Password must be at least 8 characters long, contain an uppercase letter, at least 3 digits, and a special character.";
            isValid = false;
        }

        // Validate confirm password
        const confirmPassword = confirmPasswordField.value.trim();
        if (confirmPassword !== newPassword) {
            confirmPasswordError.textContent = "Passwords do not match.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });
});

document.getElementById('email-notifications').addEventListener('change', function () {
    const isChecked = this.checked;

    fetch('update_notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ emailNotifications: isChecked })
    })
        .then(response => response.json())
        .then(data => {
            const statusElement = document.getElementById('notification-status');
            if (data.success) {
                statusElement.textContent = "Notification preference updated successfully.";
                statusElement.style.color = "green";
            } else {
                statusElement.textContent = "Failed to update notification preference.";
                statusElement.style.color = "red";
            }
        })
        .catch(error => {
            console.error('Error updating notification preference:', error);
        });
});
