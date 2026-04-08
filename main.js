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
    const officerModal = document.getElementById('officerModal');
    const addOfficerBtn = document.querySelector('.new-officer-btn');
    const officerCloseBtns = document.querySelectorAll('#officerModal .close-modal');
    const tbody = document.getElementById('tBody');
    const form = document.getElementById('officerForm');
    const editRow = document.getElementById('editRow');
    const deleteName = document.getElementById('targetName');

    // AUTOMATE TEST - Comment the loop at the last part of the code to disable
    function autoTestAddOfficer() {
    addOfficerBtn.click();

    document.getElementById('officerFirstName').value = "Test";
    document.getElementById('officerLastName').value = "User " + Math.floor(Math.random() * 100);
    document.getElementById('officerAge').value = Math.floor(Math.random() * 100);
    document.getElementById('officerContact').value = "123 456 7890";
    document.getElementById('officerCourse').value = "BSIT-IS";
    document.getElementById('officerYearLevel').value = 2;
    document.getElementById('officerTermYear').value = "2026-2027";
    document.getElementById('officerPosition').value = "PLACEHOLDER 1";
    document.getElementById('officerDateAssumed').value = "2026-05-17";
    document.getElementById('officerAccessLevel').value = "Viewer";

    form.dispatchEvent(new Event('submit')); 
    }

    // METHODS
    // Open Modal 
    function openModal() {
        officerModal.style.display = 'flex';
    }

    // Closes Modal
    function closeModal() {
        officerModal.style.display = 'none';
    }

    // Update "No Entries Yet!" Row Placeholder
    function updateEmptyPlaceholder() {
        const rows = tbody.querySelectorAll('tr');
        const emptyRow =tbody.querySelector('.empty-row');

        if (rows.length > 0) {
            if (emptyRow) {
                emptyRow.remove();
            }
        } else {
            if (!emptyRow) {
                tbody.innerHTML = `<tr class="empty-row" id="emptyRow">
                                    <td colspan="5" style="color: #c872b5; text-align: center;"> <strong> NO ENTRIES YET! </strong></td>
                                   </tr>`;
            }
        }
    }

    // Validate and get data (e.g., name, term year, roles)
    function getData() {
        let isValid = true;

        const firstName = document.getElementById('officerFirstName').value;
        const lastName = document.getElementById('officerLastName').value;
        const fullName = `${firstName} ${lastName}`;
        const termYear = document.getElementById('officerTermYear').value;
        const officerPosition = document.getElementById('officerPosition').value;

        if (!fullName) {
            setError('nameError', 'Full name is required');
            isValid = false;
        }
        if (!termYear) {
            setError('termYearError', 'Term Year is required');
            isValid = false;
        }
        if (!officerPosition) {
            setError('positionError', 'Position is required');
            isValid = false;
        }
        if (!isValid) {
            return null;
        }

        return {fullName, termYear, officerPosition}
    }


    // Add row to table
    function addRow(data) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${escapeHTML(data.fullName)}</td>
            <td>${escapeHTML(data.termYear)}</td>
            <td>${escapeHTML(data.officerPosition)}</td>
            <td data-label="Status"><span class="status-inactive">Inactive</span></td> 
            <td class="actions-cell" data-label="Actions">
                <button class="action-button">•••</button>
            </td>
        `;
        tbody.appendChild(row);
        updateEmptyPlaceholder();
    }

    function escapeHTML(str) {
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp';
            if (m === '<') return '&lt';
            if (m === '>') return '&gt';
            return m;
        });
    }

    // Only run if the Add Officer button is actually on the current page
    if (addOfficerBtn && officerModal) {
        
        // Open Modal
        addOfficerBtn.addEventListener('click', (e) => {
            e.preventDefault(); 
            openModal();
        });

        // Close Modal 
        officerCloseBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                closeModal();
            });
        });

        // Close on outside click
        window.addEventListener('click', (e) => {
            if (e.target === officerModal) {
                officerModal.style.display = 'none';
            }
        });

        // Submit Form
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const data = getData();
            if (!data) return;
            addRow(data);
            closeModal();
            form.reset();
        });
    }

    // Comment this to disable
    for(let i = 0; i < 10; i++) {
        autoTestAddOfficer();
    }   
});