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
// USER PROFILE: ADD COMMITTEE MODAL & ACTIONS
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const committeeModal = document.getElementById('addCommitteeModal');
    const addCommitteeBtn = document.querySelector('.add-committee-btn');
    const committeeCloseBtns = document.querySelectorAll('#addCommitteeModal .close-modal');
    const committeeTable = document.querySelector('.file-table');

    // 1. OPEN/CLOSE MODAL LOGIC
    if (addCommitteeBtn && committeeModal) {
        addCommitteeBtn.onclick = (e) => {
            e.preventDefault(); 
            committeeModal.style.display = 'flex';
        };

        committeeCloseBtns.forEach(btn => {
            btn.onclick = (e) => {
                e.preventDefault();
                committeeModal.style.display = 'none';
            };
        });

        window.addEventListener('click', (e) => {
            if (e.target === committeeModal) {
                committeeModal.style.display = 'none';
            }
        });
    }

    // 2. DROPDOWN ACTION LOGIC (The part you were unsure about)
    // We attach this to the table so it works for rows you add later!
    if (committeeTable) {
        committeeTable.addEventListener('click', (e) => {
            // This looks for the closest "•••" button that was clicked
            const dotsBtn = e.target.closest('.dots-btn');
            
            if (dotsBtn) {
                e.stopPropagation();
                const parentMenu = dotsBtn.parentElement;
                
                // Close any other open menus so only one is visible at a time
                document.querySelectorAll('.actions-menu.active').forEach(menu => {
                    if (menu !== parentMenu) menu.classList.remove('active');
                });

                // Toggle the "active" class to show/hide the Edit/Delete pop-up
                parentMenu.classList.toggle('active');
            }
        });
    }
});

// =========================================
// USER PROFILE: EDIT PROFILE PIC
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const pfpModal = document.getElementById('pfpModal');
    const editPfpBtn = document.querySelector('.edit-pfp-btn');
    const pfpInput = document.getElementById('pfpInput');
    const imagePreview = document.getElementById('imagePreview');
    const pfpCloseBtns = document.querySelectorAll('#pfpModal .close-modal');

    if (editPfpBtn && pfpModal) {
        // Open Modal
        editPfpBtn.onclick = () => {
            pfpModal.style.display = 'flex';
        };

        // Close Modal
        pfpCloseBtns.forEach(btn => {
            btn.onclick = () => {
                pfpModal.style.display = 'none';
                pfpInput.value = ''; // Reset input
                imagePreview.innerHTML = '<span>No file selected</span>';
            };
        });

        // Image Preview Logic
        pfpInput.onchange = function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        };

        // Handle Outside Click
        window.addEventListener('click', (e) => {
            if (e.target === pfpModal) {
                pfpModal.style.display = 'none';
            }
        });
    }
});

// =========================================
// USER MANAGEMENT: ADD OFFICER MODAL
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    // Modals/Forms
    const officerModal = document.getElementById('officerModal');
    const deleteModal = document.getElementById('deleteModal');
    const form = document.getElementById('officerForm');
    const modalTitle = document.getElementById('modalTitle');
    const deleteName = document.getElementById('targetName');

    // Buttons
    const addOfficerBtn = document.querySelector('.new-officer-btn');
    const officerCloseBtns = document.querySelectorAll('#officerModal .close-modal');
    const uploadBtn = document.querySelector('.btn-upload'); // Add/Edit button
    const confirmBtn = document.querySelector('.btn-confirm'); // Delete button
    const allCloseBtn = document.querySelectorAll('.close-modal');

    // Table
    const tbody = document.getElementById('tBody');
    const editRow = document.getElementById('editRow');

    // Initialize for Dropdown
    let currentOpenDropdown = null;

    // Initialize for Delete Modal
    let currentDelete = null;

    // --- METHODS ---
    // Open Modal 
    function openModal() { officerModal.style.display = 'flex';}

    // Multi-functional Close Modal
    function closeModal() {
        officerModal.style.display = 'none';
        deleteModal.style.display = 'none';
        form.reset();
        editRow.value = "";
        modalTitle.textContent = "Add New Officer";
        uploadBtn.textContent = "Add Officer";
    }

    // Delete Modal
    function showDeleteModal(row, name) {
        currentDelete = row;
        deleteName.textContent = name;
        deleteModal.style.display = 'flex';
    }

    // Open Edit Modal
    function openEditModal(row, rowId) {
        const data = JSON.parse(row.getAttribute('data-info'));

        document.getElementById('officerFirstName').value = data.firstName;
        document.getElementById('officerLastName').value = data.lastName;
        document.getElementById('officerAge').value = data.age;
        document.getElementById('officerContact').value = data.contact;
        document.getElementById('officerCourse').value = data.course;
        document.getElementById('officerYearLevel').value = data.yearLevel;
        document.getElementById('officerPosition').value = data.position;
        document.getElementById('officerTermYear').value = data.termYear;
        document.getElementById('officerDateAssumed').value = data.dateAssumed;
        document.getElementById('officerAccessLevel').value = data.accessLevel;

        editRow.value = rowId;
        modalTitle.textContent = "Edit Officer";
        uploadBtn.textContent = "Update Officer";
        openModal();
    }

    // Update "No Entries Yet!" Row Placeholder
    function updateEmptyPlaceholder() {
        const rows = tbody.querySelectorAll('tr');
        const emptyRow = tbody.querySelector('.empty-row');

        if (rows.length > 0 && emptyRow) {
            emptyRow.remove();
        } else if (rows.length === 0 && !emptyRow) {
            tbody.innerHTML = `<tr class="empty-row" id="emptyRow">
                <td colspan="5" style="color: #c872b5; text-align: center;"> <strong> NO ENTRIES YET! </strong></td>
            </tr>`;
        }
    }

    // Validate and get data (e.g., name, term year, roles)
    function getData() {
        // let isValid = true;

        const firstName = document.getElementById('officerFirstName').value;
        const lastName = document.getElementById('officerLastName').value;
        const age = document.getElementById('officerAge').value;
        const contact = document.getElementById('officerContact').value;
        const course = document.getElementById('officerCourse').value;
        const yearLevel = document.getElementById('officerYearLevel').value;
        const position = document.getElementById('officerPosition').value;
        const termYear = document.getElementById('officerTermYear').value;
        const dateAssumed = document.getElementById('officerDateAssumed').value;
        const accessLevel = document.getElementById('officerAccessLevel').value;

        return {
            firstName,
            lastName,
            fullName: `${firstName} ${lastName}`,
            age,
            contact,
            course,
            yearLevel,
            position,
            termYear,
            dateAssumed,
            accessLevel,
        };
    }

    // New row from data
    function createRow(data, rowId = null) {
        const id = rowId || Date.now();
        const row = document.createElement('tr');
        row.setAttribute('data-id', id);
        row.setAttribute('data-info', JSON.stringify(data));

        row.innerHTML = `
            <td>${escapeHTML(data.fullName)}</td>
            <td>${escapeHTML(data.termYear)}</td>
            <td>${escapeHTML(data.position)}</td>
            <td data-label="Status"><span class="status-inactive">Inactive</span></td> 
        `;

        showActionButtons(row, id);
        return row;
    }

    // Add row to table
    function addRow(data) {
        const newRow = createRow(data);
        tbody.appendChild(newRow);
        updateEmptyPlaceholder();
    }

    // Update exisiting row
    function updateRow(rowId, data) {
        const row = tbody.querySelector(`tr[data-id="${rowId}"]`);
        if (row) {
            row.cells[0].textContent = data.fullName;
            row.cells[1].textContent = data.termYear;
            row.cells[2].textContent = data.position;

            row.setAttribute('data-info', JSON.stringify(data));
        }
    }

    // Delete Row
    function deleteRow(row) {
        if(row) {
            row.remove();
            updateEmptyPlaceholder();
        }
        closeModal();
    }

    function escapeHTML(str) {
        const m = document.createElement('m');
        m.textContent = str;
        return m.innerHTML;
    }

    // Show Options in Dropdown
    function showActionButtons(row, rowId) {
        const actionCell = document.createElement('td');
        actionCell.className = "action-cell";

        const menuDiv = document.createElement('div');
        menuDiv.className = 'actions-menu';

        const triDotsBtn = document.createElement('button');
        triDotsBtn.className = 'dots-btn';
        triDotsBtn.textContent = '•••';

        const dropdown = document.createElement('div');
        dropdown.className = 'dropdown-action';

        const editBtn = document.createElement('button');
        editBtn.type = "button";
        editBtn.textContent = "Edit Officer";
        editBtn.className = 'edit-btn';
        editBtn.onclick = (e) => {
            e.stopPropagation();
            openEditModal(row, rowId);
            menuDiv.classList.remove('active');
            menuDiv.classList.remove('dropup')
            if (currentOpenDropdown === menuDiv) {
                currentOpenDropdown = null;
            }
        };

        const deleteBtn = document.createElement('button');
        deleteBtn.type = "button";
        deleteBtn.textContent = "Delete Officer";
        deleteBtn.className = 'delete-btn';
        deleteBtn.onclick = (e) => {
            e.stopPropagation();
            const name = row.cells[0].textContent;
            showDeleteModal(row, name);
            menuDiv.classList.remove('active');
            menuDiv.classList.remove('dropup');
            if (currentOpenDropdown === menuDiv) {
                currentOpenDropdown = null;
            }
        }

        dropdown.appendChild(editBtn);
        dropdown.appendChild(deleteBtn);
        menuDiv.appendChild(triDotsBtn);
        menuDiv.appendChild(dropdown);
        actionCell.appendChild(menuDiv);
        row.appendChild(actionCell);

        function adjustDropdown(menuDiv) {
            const dropdownMenu = menuDiv.querySelector('.dropdown-action');
    
            dropdownMenu.style.display = 'block';
            dropdownMenu.style.visibility = 'hidden';
    
            const menuRect = dropdownMenu.getBoundingClientRect();
            const btnRect = menuDiv.getBoundingClientRect();
    
            const spaceBelow = window.innerHeight - btnRect.bottom;
            const buffer = 20; 
    
            if (spaceBelow < menuRect.height + buffer) {
                menuDiv.classList.add('dropup');
            } else {
                menuDiv.classList.remove('dropup');
            }

            dropdownMenu.style.display = '';
            dropdownMenu.style.visibility = '';
            }

        // Dropdown Action
        triDotsBtn.addEventListener('click', (e) => {
            e.stopPropagation();

            // Close other dropdowns if open
            if (currentOpenDropdown && currentOpenDropdown !== menuDiv) {
                currentOpenDropdown.classList.remove('active');
                currentOpenDropdown.classList.remove('dropup');
            }

            // Toggle current dropdown
            if (menuDiv.classList.contains('active')) {
                menuDiv.classList.remove('active');
                menuDiv.classList.remove('dropup');
                currentOpenDropdown = null;
            } else {
                adjustDropdown(menuDiv);
                menuDiv.classList.add('active');
                currentOpenDropdown = menuDiv;
            }
        });
    }

    // --- EVENT LISTENERS --- 
    // Open Modal
    if (addOfficerBtn) {
        addOfficerBtn.addEventListener('click', openModal);
    }

    // Close when click outside
    window.addEventListener('click', (e) => {
        if (e.target === officerModal || e.target === deleteModal) {
            closeModal();
        }
    });

    // Submit/Edit Form
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = getData();
        const editingId = editRow.value;

        if (editingId) {
            updateRow(editingId, data);
        } else {
            addRow(data);
        }
        closeModal();
    });

    // Delete Form
    confirmBtn.addEventListener('click', () => {
        if (currentDelete) {
            currentDelete.remove();
            updateEmptyPlaceholder();
            closeModal();
            currentDelete = null;
        }
    });

    // Close/Cancel Button
    allCloseBtn.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Close dropdown when clicked outside
    document.addEventListener('click', function(e) {
        const isClickInMenu = e.target.closest('.actions-menu');

        if (!isClickInMenu && currentOpenDropdown) {
            currentOpenDropdown.classList.remove('active');
            currentOpenDropdown.classList.remove('dropup');
            currentOpenDropdown = null;
        }
    });

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