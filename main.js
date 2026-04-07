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

// =========================================
// USER PROFILE: ADD COMMITTEE MODAL
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const committeeModal = document.getElementById('addCommitteeModal');
    const addCommitteeBtn = document.querySelector('.add-committee-btn');
    const committeeCloseBtns = document.querySelectorAll('#addCommitteeModal .close-modal');

    // Only attach event listeners if the Add Committee button exists on this page
    if (addCommitteeBtn && committeeModal) {
        
        // Open Modal
        addCommitteeBtn.onclick = (e) => {
            e.preventDefault(); 
            committeeModal.style.display = 'flex';
        };

        // Close Modal 
        committeeCloseBtns.forEach(btn => {
            btn.onclick = (e) => {
                e.preventDefault();
                committeeModal.style.display = 'none';
            };
        });

        // Close on outside click
        window.addEventListener('click', (e) => {
            if (e.target === committeeModal) {
                committeeModal.style.display = 'none';
            }
        });
    }
});

// =========================================
// USER MANAGEMENT: ADD OFFICER MODAL
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const officerModal = document.getElementById('addOfficerModal');
    const addOfficerBtn = document.querySelector('.new-officer-btn');
    const officerCloseBtns = document.querySelectorAll('#addOfficerModal .close-modal');

    // Only run if the Add Officer button is actually on the current page
    if (addOfficerBtn && officerModal) {
        
        // Open Modal
        addOfficerBtn.addEventListener('click', (e) => {
            e.preventDefault(); 
            officerModal.style.display = 'flex';
        });

        // Close Modal 
        officerCloseBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                officerModal.style.display = 'none';
            });
        });

        // Close on outside click
        window.addEventListener('click', (e) => {
            if (e.target === officerModal) {
                officerModal.style.display = 'none';
            }
        });
    }
});