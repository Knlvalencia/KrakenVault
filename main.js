/*NAVIGATION MENU*/
document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const body = document.body;

    // Toggle Menu
    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        navMenu.classList.toggle('open');
        body.classList.toggle('menu-pushed');
    });

    // Close menu when clicking anywhere else
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && navMenu.classList.contains('open')) {
            navMenu.classList.remove('open');
            body.classList.remove('menu-pushed');
        }
    });
});