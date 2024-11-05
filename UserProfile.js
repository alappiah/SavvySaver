document.addEventListener("DOMContentLoaded", function() {
    const userProfileForm = document.getElementById("user-profile-form");
    const feedbackForm = document.getElementById("feedback-form");

    // Handle profile form submission
    userProfileForm.addEventListener("submit", function(event) {
        event.preventDefault();
        alert("Profile updated successfully!");
    });

    // Handle feedback form submission
    feedbackForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const feedback = document.getElementById("feedback-input").value;
        alert("Thank you for your feedback: " + feedback);
        feedbackForm.reset();
    });

    // Update the preview image on profile picture upload
    window.updateProfileImage = function(event) {
        const profileImagePreview = document.getElementById("profile-image-preview");
        const file = event.target.files[0];
        if (file) {
            profileImagePreview.src = URL.createObjectURL(file);
        }
    };

    // Show the selected section based on nav click
    const navLinks = document.querySelectorAll(".side-nav ul li a");
    const sections = document.querySelectorAll(".section-content");

    navLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();

            // Remove 'active' from all links, add to the clicked one
            navLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            // Hide all sections and show the selected one
            const targetSectionId = this.getAttribute("data-section");
            sections.forEach(section => {
                if (section.id === targetSectionId) {
                    section.classList.remove("hidden");
                } else {
                    section.classList.add("hidden");
                }
            });
        });
    });
});
