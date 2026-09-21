// Scroll Reveal logic removed as animations are disabled.
document.addEventListener('DOMContentLoaded', () => {
    // Nav Toggle for Mobile
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('show');
        });
    }
});
