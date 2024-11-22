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
