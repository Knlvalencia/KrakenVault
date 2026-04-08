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

// =========================================
// ACTIVITY LOG: FILTER BY USER AND ACTION
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector(".file-table tbody");

    if (!tableBody) return;

    const searchInput = document.querySelector(".search-input");
    const userFilter = document.querySelector(".filter-by-user .row-select");
    const actionFilter = document.querySelector(".filter-by-action .row-select");
    const rowsPerPageSelect = document.querySelector(" .display-controls .row-select");

    const allRows = Array.from(tableBody.querySelectorAll("tr"))

    let filteredRows = [...allRows];

    let currentPage = 1;

    function updateTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";

        const selectedUser = userFilter ? userFilter.options[userFilter.selectedIndex].text : "All Users";

        const selectedAction = actionFilter ? actionFilter.options[actionFilter.selectedIndex].text : "All Actions";

        filteredRows = allRows.filter(row => {
            const rowText = row.innerText.toLowerCase();

            const userCell = row.querySelector("td[data-label='Account']");
            const actionCell = row.querySelector("td[data-label='Actions']");

            const userCellText = userCell ? userCell.innerText : "";
            const actionCellText = actionCell ? actionCell.innerText : "";

            const matchesSearch = rowText.includes(searchTerm);

            const matchesUser = selectedUser === "All Users" || userCellText.includes(selectedUser);

            const actionKeyword = selectedAction === "All Actions" ? "" : selectedAction.split(' ')[0];
            const matchesAction = selectedAction === "All Actions" || actionCellText.includes(actionKeyword);

            return matchesSearch && matchesUser && matchesAction;

        });

        tableBody.innerHTML = "";

        filteredRows.forEach(row => {
            tableBody.appendChild(row);
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", () => {
            currentPage = 1;
            updateTable();
        });
    }

    if (userFilter) {
        userFilter.addEventListener("change", () => {
            currentPage = 1;
            updateTable();
        });
    }

    if (actionFilter) {
        actionFilter.addEventListener("change", () => {
            currentPage = 1;
            updateTable();
        });
    }

    if (rowsPerPageSelect) {
        rowsPerPageSelect.addEventListener("change", (e) => {
            rowsPerPage = parseInt(e.target.value);
            currentPage = 1;
            updateTable();
         });
     }

    updateTable();
});