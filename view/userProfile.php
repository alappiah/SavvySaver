<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Settings</title>
    <link rel="stylesheet" href="userProfileCss.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Side Navigation Pane -->
        <nav class="side-nav">
            <h2>Settings</h2>
            <ul>
                <li><a href="#personal-info" class="active" data-section="personal-info"><i class="fas fa-user"></i> Personal Info</a></li>
                <li><a href="#notification-settings" data-section="notification-settings"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="#account-security" data-section="account-security"><i class="fas fa-lock"></i> Account Security</a></li>
                <li><a href="#preferences" data-section="preferences"><i class="fas fa-cogs"></i> Preferences</a></li>
                <li><a href="#feedback" data-section="feedback"><i class="fas fa-comment-alt"></i> Feedback</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1>User Profile Settings</h1>

            <!-- Sections -->
            <section id="personal-info" class="section-content active">
                <h2>Personal Information</h2>
                <form id="user-profile-form" method="POST" action="updateProfile.php">
                    <div class="profile-picture-container">
                        <div class="profile-picture-card">
                            <img id="profile-image-preview" src="default-profile.png" alt="Profile Picture">
                        </div>
                        <input type="file" id="profile-picture" accept="image/*" onchange="updateProfileImage(event)">
                    </div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fName" placeholder="Enter your first name">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lName" placeholder="Enter your last name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </section>

            <section id="notification-settings" class="section-content">
                <h2>Notification Settings</h2>
                <form id="notification-settings-form">
                    <div class="form-group">
                        <label>Email Notifications</label>
                        <input type="checkbox" id="email-notifications" checked> Receive email notifications
                    </div>
                    <div class="form-group">
                        <label>SMS Notifications</label>
                        <input type="checkbox" id="sms-notifications"> Receive SMS notifications
                    </div>
                    <button type="submit" class="save-btn">Save Notification Settings</button>
                </form>
            </section>

            <section id="account-security" class="section-content">
                <h2>Account Security</h2>
                <form id="account-security-form" method="POST" action="password-change.php">
                    <h3>Change Password</h3>
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="currentPassword" placeholder="Enter current password" required>
                        <span id="current-password-error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="newPassword" placeholder="Enter new password">
                        <span id="new-password-error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm new password">
                        <span id="confirm-password-error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Two-Factor Authentication</label>
                        <input type="checkbox" id="two-factor-auth"> Enable two-factor authentication
                    </div>
                    <button type="submit" class="save-btn">Save Security Settings</button>
                </form>
            </section>

            <section id="preferences" class="section-content">
                <h2>Preferences</h2>
                <div class="form-group">
                    <label for="theme">Theme</label>
                    <select id="theme" name="theme">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                    </select>
                </div>
                <button id="apply-preferences" class="save-btn">Apply Preferences</button>
            </section>

            <section id="feedback" class="section-content">
                <h2>Feedback</h2>
                <form id="feedback-form">
                    <div class="form-group">
                        <label for="feedback-input">Your Feedback</label>
                        <textarea id="feedback-input" placeholder="How was your experience?"></textarea>
                    </div>
                    <button type="submit" class="save-btn">Submit Feedback</button>
                </form>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; SavvySaver 2024. All rights reserved.
    </footer>

    <script src="UserProfile.js"></script>
</body>
</html>
