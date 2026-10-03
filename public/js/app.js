// Scroll Reveal logic removed as animations are disabled.
document.addEventListener('DOMContentLoaded', () => {
    // Nav Toggle for Mobile
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', () => {
            const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
            navLinks.classList.toggle('show', !isExpanded);
            navToggle.setAttribute('aria-expanded', String(!isExpanded));

            const icon = navToggle.querySelector('i');
            icon?.classList.toggle('fa-bars', isExpanded);
            icon?.classList.toggle('fa-times', !isExpanded);
        });
    }
});
