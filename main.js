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
    // Modals/Forms
    const officerModal = document.getElementById('officerModal');
    const deleteModal = document.getElementById('deleteModal');
    const form = document.getElementById('officerForm');
    const modalTitle = document.getElementById('modalTitle');
    const deleteName = document.getElementById('targetName');
    const filterWrapper = document.querySelector('.filter-wrapper');
    const filterYear = document.getElementById('filterYear');
    const customRange = document.getElementById('customYearRange');
    const yearFrom = document.getElementById('yearFrom');
    const yearTo = document.getElementById('yearTo');

    // Buttons
    const addOfficerBtn = document.querySelector('.new-officer-btn');
    const officerCloseBtns = document.querySelectorAll('#officerModal .close-modal');
    const uploadBtn = document.querySelector('.btn-upload'); // Add/Edit button
    const confirmBtn = document.querySelector('.btn-confirm'); // Delete button
    const allCloseBtn = document.querySelectorAll('.close-modal');
    const sortBtn = document.querySelector('.sort-btn');
    const filterBtn = document.getElementById('filterBtn');

    // Table
    const tbody = document.getElementById('tBody');
    const editRow = document.getElementById('editRow');

    // Pagination
    // const perPageValue = document.getElementById('perPageValue');
    const perPageSelect = document.getElementById('perPageSelect');
    // const perPageDropdown = document.querySelector('.per-page-dropdown');

    // Initialize for Dropdown
    let currentOpenDropdown = null;

    // Initialize for Delete Modal
    let currentDelete = null;

    // Pagination Variables
    let currentPage = 1;
    let rowsPerPage = 5; // Default rows per page (Can be changed accordingly)
    let allRows = [];
    let currentDisplayRows = [];

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

    // Open Delete Modal
    function showDeleteModal(row) {
        currentDelete = row;
        const data = JSON.parse(row.getAttribute('data-info'));
        deleteName.textContent = data.fullName;
        deleteModal.style.display = 'flex';
    }

    // Open Edit Modal
    function openEditModal(row, rowId) {
        const data = JSON.parse(row.getAttribute('data-info'));

        document.getElementById('officerFullName').value = data.fullName;
        document.getElementById('officerStudentId').value = data.studentId;
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

    // Update Display of Pagination
    function updatePagination() {
        const totalMembers = currentDisplayRows.length;
        const totalPages = Math.ceil(totalMembers / rowsPerPage);

        // Update "members of #"
        document.getElementById('totalMembers').textContent = totalMembers;

        // Update pagination buttons
        const paginationContainer = document.querySelector('.pagination-controls');
        paginationContainer.innerHTML = '';

        // Previous Button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.textContent = '<';
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderCurrentPage();
            }
        };
        paginationContainer.appendChild(prevBtn);

        // Page Number Buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = 'page-btn';
            if (i === currentPage) {pageBtn.classList.add('active');}
            pageBtn.textContent = i;
            pageBtn.onclick = () => {
                currentPage = i;
                renderCurrentPage();
            };
            paginationContainer.appendChild(pageBtn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.textContent = '>';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderCurrentPage();
            }
        };
        paginationContainer.appendChild(nextBtn);
    }

    // Render Current Page
    function renderCurrentPage() {
        const totalMembers = currentDisplayRows.length;

        if (totalMembers === 0) {
            const allTableRows = Array.from(tbody.querySelectorAll('tr:not(.empty-row)'));
            allTableRows.forEach(row => row.style.display = 'none');
            updatePagination();
            return;
        }

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const rowsToShow = currentDisplayRows.slice(start, end);

        // Initially hide the rows
        const allTableRows = Array.from(tbody.querySelectorAll('tr:not(.empty-row)'));
        allTableRows.forEach(row => row.style.display = 'none');

        // Only show rows for each page
        rowsToShow.forEach(row => row.style.display = '');

        updatePagination();
    }

    function updateDisplay() {
        currentDisplayRows = Array.from(tbody.querySelectorAll('tr:not(.empty-row)'));
        currentPage = 1;
        renderCurrentPage();
    }

    // Validate and get data (e.g., name, term year, roles)
    function getData() {
        const fullName = document.getElementById('officerFullName').value;
        const studentId = document.getElementById('officerStudentId').value;
        const age = document.getElementById('officerAge').value;
        const contact = document.getElementById('officerContact').value;
        const course = document.getElementById('officerCourse').value;
        const yearLevel = document.getElementById('officerYearLevel').value;
        const position = document.getElementById('officerPosition').value;
        const termYear = document.getElementById('officerTermYear').value;
        const dateAssumed = document.getElementById('officerDateAssumed').value;
        const accessLevel = document.getElementById('officerAccessLevel').value;

        return {
            fullName,
            studentId,
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

        // For Status
        const statusClass = data.status === 'active' ? 'status-active' : 'status-inactive';
        const statusText = data.status === 'active' ? 'Active' : 'Inactive';
        row.setAttribute('data-id', id);
        row.setAttribute('data-info', JSON.stringify(data));

        row.innerHTML = `
            <td>${escapeHTML(data.fullName)} <br> <small>${escapeHTML(data.studentId)}</small></td>
            <td>${escapeHTML(data.termYear)}</td>
            <td>${escapeHTML(data.position)}</td>
            <td data-label="Status"><span class="${statusClass}">${statusText}</span></td> 
        `;

        showActionButtons(row, id);
        return row;
    }

    // Add row to table
    function addRow(data) {
        // Generate Random Status (SHOULD BE REMOVED WHEN TRANSITIONING TO DATABASE)
        const statuses = ['active', 'inactive'];
        const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
        const dataWithStatus = {...data, status: randomStatus};

        const newRow = createRow(dataWithStatus); // must be changed to createRow(data) when removing 
        tbody.appendChild(newRow);
        updateEmptyPlaceholder();

        updateDisplay();
    }

    // Update exisiting row
    function updateRow(rowId, data) {
        const row = tbody.querySelector(`tr[data-id="${rowId}"]`);
        if (row) {
            // Added for randomized status
            const existingData = JSON.parse(row.getAttribute('data-info')); 

            row.cells[0].innerHTML = `${escapeHTML(data.fullName)} <br> <small style="font-size: 12px; color: #5f6368;">${escapeHTML(data.studentId)}</small>`;
            row.cells[1].textContent = data.termYear;
            row.cells[2].textContent = data.position;

            // For Status
            const statusClass = data.status === 'active' ? 'status-active' : 'status-inactive';
            const statusText = data.status === 'active' ? 'Active' : 'Inactive';
            row.cells[3].innerHTML = `<span class="${statusClass}">${statusText}</span>`;

            // Added for randomized status
            const updatedData = {...data, status: existingData.status};
            row.setAttribute('data-info', JSON.stringify(updatedData)); // Must be changed to JSON.stringify(data);

            updateDisplay();
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
            showDeleteModal(row);
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

            // Close Sort & Filter if opened
            if (filterWrapper) {
                filterWrapper.classList.remove('active');
            }

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

    function applyFilterAndSort() {
        const filterRole = document.getElementById('filterRole').value;
        const filterStatus = document.getElementById('filterStatus').value;
        const filterYear = document.getElementById('filterYear').value;
        const sortType = document.getElementById('sortType').value;
        const sortOrder = document.getElementById('sortOrder').value;

        // Get all rows
        let rows = Array.from(tbody.querySelectorAll('tr:not(.empty-row)'));

        rows.forEach(row => {
            const data = JSON.parse(row.getAttribute('data-info'));
            const statusSpan = row.querySelector('td:nth-child(4) span');
            const status = statusSpan ? statusSpan.textContent.toLowerCase() : '';

            // Filter Logic
            let showRow = true;

            // Role Filter
            if (filterRole !== "allRoles" && data.position !== filterRole) {showRow = false;}

            // Status Filter 
            if (filterStatus !== "allStatus" && status !== filterStatus) {showRow = false;}

            // Year Filter
            if (filterYear !== "allTime") {
                const termYear = data.termYear.replace(/\s/g, ''); // Removes the spaces (e.g., 2025 - 2026 --> 2025-2026)
                if (filterYear === 'present' && termYear !== '2026-2027')  {showRow = false;}
                if (filterYear === 'previous-year' && termYear !== '2025-2026') {showRow = false;}
                if (filterYear === 'last-previous-year' && termYear !== '2024-2025') {showRow = false;}
                if (filterYear === 'custom') {
                    const from = parseInt(yearFrom.value);
                    const to = parseInt(yearTo.value);
                    if (!isNaN(from) && !isNaN(to)) {
                        const termStart = parseInt(termYear.split('-')[0]);
                        if (termStart < from || termStart > to) {showRow = false;}
                    }
                }
            }

            row.style.display = showRow ? '' : 'none';
        });

        // Only show visible rows
        let visibleRows = rows.filter(row => row.style.display !== 'none');

        // Sort Logic 
        visibleRows.sort((a, b) => {
            const dataA = JSON.parse(a.getAttribute('data-info'));
            const dataB = JSON.parse(b.getAttribute('data-info'));

            let valA, valB;

            switch (sortType) {
                case 'name':
                    // In any case there are prefixes (e.g, Mr., Ms., Mrs., Prof., Dr., Engr.)
                    function removePrefix(fullName) {
                        const prefixes = ['Dr. ', 'Prof. ', 'Engr. ', 'Mr. ', 'Ms. ', 'Mrs. ']; // May be added if there are more
                        let nameWithNoPrefix = fullName;
                        for (let prefix of prefixes) {
                            if (fullName.startsWith(prefix)) {
                                nameWithNoPrefix = fullName.substring(prefix.length);
                                break;
                            }
                        }
                        return nameWithNoPrefix.toLowerCase();
                    }

                    valA = removePrefix(dataA.fullName);
                    valB = removePrefix(dataB.fullName);
                    break;
                case 'dateAssumed':
                    valA = new Date(dataA.dateAssumed);
                    valB = new Date(dataB.dateAssumed);
                    break;
                case 'yearLevel':
                    valA = parseInt(dataA.yearLevel);
                    valB = parseInt(dataB.yearLevel);
                    break;
                default:
                    valA = dataA.fullName;
                    valB = dataB.fullName;
            }

            if (valA < valB) {return sortOrder === 'asc' ? -1 : 1;}
            if (valA > valB) {return sortOrder === 'asc' ? 1 : -1;}
            return 0;
        });
        
        visibleRows.forEach(row => tbody.appendChild(row));
        rows.filter(row => row.style.display === 'none').forEach(row => tbody.appendChild(row));

        return visibleRows;
    }

    // --- EVENT LISTENERS --- 
    // Open Modal
    if (addOfficerBtn) {
        addOfficerBtn.addEventListener('click', openModal);
    }

    // Modal (Close when clicked outside)
    window.addEventListener('click', (e) => {
        if (e.target === officerModal || e.target === deleteModal) {
            closeModal();
        }
    });

    // Sort & Filter 
    if (sortBtn && filterWrapper) {
        sortBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Close dropdown action if opened
            if (currentOpenDropdown) {
                currentOpenDropdown.classList.remove('active');
                currentOpenDropdown.classList.remove('dropup');
                currentOpenDropdown = null;
            }

            filterWrapper.classList.toggle('active');
        });
    }

    // If "Custom Year" is chosen as an option
    if (filterYear && customRange) {
        filterYear.addEventListener('change', function() {
            if (this.value === 'custom') {
                customRange.style.display = 'block';
            } else {
                customRange.style.display = 'none';
            }
        });
    }

    // Prevents negative inputs in custom year
    [yearFrom, yearTo].forEach(input => {
        if (input) {
            input.addEventListener('change', function() {
                if (this.value !== "" && parseInt(this.value) < 0) {
                    alert("Please enter a valid year.");
                    this.value = "";
                    this.classList.add('input-error');
                } else {
                    this.classList.remove('input-error');
                }
            })
        }
    })

    // Sort & Filter (Closed when clicked outside)
    document.addEventListener('click', function (e) {
        if (filterWrapper && !filterWrapper.contains(e.target) && filterWrapper.classList.contains('active')) {
            filterWrapper.classList.remove('active');
        }

        const isClickInMenu = e.target.closest('.actions-menu');
        if (isClickInMenu && currentOpenDropdown) {
            currentOpenDropdown.classList.remove('active');
            currentOpenDropdown.classList.remove('dropup');
            currentOpenDropdown = null;
        }
    });

    // Sort & Filter Form
    if (filterBtn) {
        filterBtn.addEventListener('click', () => {
            applyFilterAndSort();
            currentDisplayRows = Array.from(tbody.querySelectorAll('tr:not(.empty-row)')).filter(row => row.style.display !== 'none');
            currentPage = 1;
            renderCurrentPage();
            filterWrapper.classList.remove('active');
        });
    }

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

    // Action Dropdown (Close when clicked outside)
    document.addEventListener('click', function(e) {
        const isClickInMenu = e.target.closest('.actions-menu');

        if (!isClickInMenu && currentOpenDropdown) {
            currentOpenDropdown.classList.remove('active');
            currentOpenDropdown.classList.remove('dropup');
            currentOpenDropdown = null;
        }
    });

    if (perPageSelect) {
        perPageSelect.addEventListener('change' , (e) => {
            rowsPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderCurrentPage();
        });
    }

    // AUTOMATE TEST - Comment the loop to disable
    function autoTestAddOfficer() {
        // officerFullName
        const firstNames = ['James', 'Maria', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 
                            'William', 'Elizabeth', 'David', 'Susan', 'Richard', 'Jessica', 'Joseph', 'Sarah',
                            'Thomas', 'Karen', 'Charles', 'Nancy', 'Christopher', 'Lisa', 'Daniel', 'Betty',
                            'Matthew', 'Margaret', 'Anthony', 'Sandra', 'Donald', 'Ashley', 'Mark', 'Kimberly',
                            'Paul', 'Emily', 'Steven', 'Donna', 'Andrew', 'Michelle', 'Kenneth', 'Dorothy'];
        const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis',
                           'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson',
                           'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson',
                           'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker',
                           'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores'];
        const prefixes = ['', 'Dr. ', 'Prof. ', 'Engr. ', 'Mr. ', 'Ms. ', 'Mrs. '];
        const suffixes = ['', ' Jr.', ' Sr.', ' II', ' III', ' IV'];

        const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
        const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
        const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
        const suffix = suffixes[Math.floor(Math.random() * suffixes.length)];
        const fullName = `${prefix}${firstName} ${lastName}${suffix}`.trim();


        // officerContact
        const contactFormat = ["09" + Math.floor(Math.random() * 100000000),"0" + Math.floor(Math.random() * 900000000 + 100000000),Math.floor(Math.random() * 9000000000 + 1000000000)];

        // officerYearLevel
        const yearLevels = ['1', '2', '3', '4'];

        // officerTermYear
        const startYears = ['2023', '2024', '2025', '2026'];
        const startYear = startYears[Math.floor(Math.random() * startYears.length)];
        const endYear = parseInt(startYear) + 1;

        // officerPosition
        const positions = ['PLACEHOLDER 1', 'PLACEHOLDER 2'];

        // officerDateAssumed
        const startDate = new Date(2023, 0, 1);
        const endDate = new Date(2026, 11, 31);
        const randomDate = new Date(startDate.getTime() + Math.random() * (endDate.getTime() - startDate.getTime()));

        // officerAccessLevel
        const accessLevels = ['Admin', 'Editor', 'Viewer'];

        addOfficerBtn.click();

        // Populate the Fields
        document.getElementById('officerFullName').value = fullName;
        document.getElementById('officerStudentId').value = "2024-" + String(Math.floor(Math.random() * 10000)).padStart(5, '0');
        document.getElementById('officerAge').value = Math.floor(Math.random() * 100);
        document.getElementById('officerContact').value = contactFormat[Math.floor(Math.random() * contactFormat.length)];
        document.getElementById('officerCourse').value = "BSIT-IS";
        document.getElementById('officerYearLevel').value = yearLevels[Math.floor(Math.random() * yearLevels.length)];
        document.getElementById('officerTermYear').value = `${startYear}-${endYear}`;
        document.getElementById('officerPosition').value = positions[Math.floor(Math.random() * positions.length)];
        document.getElementById('officerDateAssumed').value = randomDate.toISOString().split('T')[0];
        document.getElementById('officerAccessLevel').value = accessLevels[Math.floor(Math.random() * accessLevels.length)];

        form.dispatchEvent(new Event('submit')); 
    }

    async function runAutoTest() {
        for (var i = 0; i < 57; i++) {
            await new Promise(resolve => setTimeout(resolve, 100));
            autoTestAddOfficer();
        }
    }

    // Comment this to disable automate test
    runAutoTest();
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