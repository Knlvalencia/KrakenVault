<?php 
    $pageTitle = 'User Management'; 
    $activePage = 'users'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    
    <link rel="stylesheet" href="users.css">
</head>
<body>
    <!-- HEADER START -->
        <?php include 'components/header.php'; ?>
    <!-- HEADER END -->

    <!-- START MODAL -->
    <div id="officerModal" class="modal-overlay">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Officer</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="officerForm">
                <input type="hidden" id="editRow" value=""> 
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="officerFullName" placeholder="Full name..." required>
                    </div>
                    <div class="form-group">
                        <label>Student ID</label>
                        <input type="text" id="officerStudentId" placeholder="e.g., 20XX-00001" required>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" id="officerAge" min="1" max="100" placeholder="Age..." required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="tel" id="officerContact" placeholder="Contact number..." required>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" id="officerCourse" placeholder="e.g., BSIT-IS..." required>
                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <select id="officerYearLevel" required>
                            <option value="" disabled selected>Select Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <select id="officerPosition" required>
                            <option value="" disabled selected>Select Position</option>
                            <option value="PLACEHOLDER 1">PLACEHOLDER 1</option>
                            <option value="PLACEHOLDER 2">PLACEHOLDER 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Term Year</label>
                        <input type="text" id="officerTermYear" placeholder="e.g., 2025-2026" required>
                    </div>
                    <div class="form-group">
                        <label>Date Assumed</label>
                        <input type="date" id="officerDateAssumed" required>
                    </div>
                    <div class="form-group">
                        <label>Access Level</label>
                        <select id="officerAccessLevel" required>
                            <option value="" disabled selected>Select Access Level</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                            <option value="Viewer">Viewer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-delete close-modal">Cancel</button>
                    <button type="submit" class="btn-upload">Add Officer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END MODAL -->

    <!-- START DELETE MODAL -->
    <div id="deleteModal" class="delete-modal">
        <div class="delete-modal-content">
            <h3> Confirm Deletion </h3>
            <p> Are you sure you want to delete <strong id="targetName"></strong>?</p>
            <div class="delete-modal-actions">
                <button type="button" class="btn-delete close-modal"> Cancel </button>
                <button type="submit" class="btn-confirm"> Delete </button>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->

    <!-- TITLE AREA START -->
    <main class="users-content">
        <div class="users-header-controls">
            <h1>User Management</h1>
            <div class="user-search-group">

                <!-- SEARCH BAR -->
                <div class="search-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" class="search-input with-icon" placeholder="Search by username or id">
                </div>
                <!-- END OF SEARCH BAR -->

                <!-- FILTER DROPDOWN MODAL START-->
                <div class="filter-wrapper">
                    <button class="action-button sort-btn"><span class="sort-icon">⇅</span> Sort & Filter</button>

                    <div id="filterDropdown" class="filter-panel">
                    <div class="filter-title"> Show Only: </div>
                    <div class="filter-field-group">
                        <label> Role: </label>
                        <select id="filterRole">
                            <option value="allRoles"> All Roles </option>
                            <option value="PLACEHOLDER 1"> PLACEHOLDER 1</option>
                            <option value="PLACEHOLDER 2"> PLACEHOLDER 2</option>
                        </select>
                    </div>
                    <div class="filter-field-group">
                        <label> Status: </label>
                        <select id="filterStatus">
                            <option value="allStatus"> All Status </option>
                            <option value="active"> Active </option>
                            <option value="inactive"> Inactive </option>
                        </select>
                    </div>
                    <div class="filter-field-group">
                        <label> Term Year: </label>
                        <select id="filterYear">
                            <option value="allTime"> Any time </option>
                            <option value="present"> Since 2026 - present </option>
                            <option value="previous-year"> Since 2025 - 2026 </option>
                            <option value="last-previous-year"> Since 2024 - 2025</option>
                            <option value="custom"> Custom Range: </option>
                        </select>
                        <div id="customYearRange" class="custom-year-range">
                            <div class="range-row">
                                <input type="number" id="yearFrom" name="yearFrom" placeholder="From...">
                                <span>-</span>
                                <input type="number" id="yearTo" name="yearTo" placeholder="To...">
                            </div>
                        </div>
                    </div>
                    <div class="filter-field-group">
                        <label> Sort by: </label>
                        <div class="sort-row">
                            <select id="sortType">
                                <option value="name"> Name</option>
                                <option value="dateAssumed"> Date Assumed </option>
                                <option value="yearLevel"> Year Level </option>
                            </select>
                            <select id="sortOrder">
                                <option value="asc"> Ascending </option>
                                <option value="desc"> Descending </option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-footer">
                        <button type="button" id="filterBtn" class="btn-filter"> Filter </button>
                    </div>
                </div>
                </div>
                <!-- END FILTER DROPDOWN MODAL -->
                <button class="action-button new-officer-btn">+ Add New Officer</button>
            </div>
        </div>
        <!-- TITLE AREA END -->

        <!-- MAIN TABLE START -->
        <table class="file-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Term Year</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th style="width: 100px; text-align: center;">Actions</th>
                </tr>
            </thead>

            <tbody id="tBody">
                <tr class="empty-row" id="emptyRow">
                    <td colspan="5" style="color: #c872b5; text-align: center;"> <strong> NO ENTRIES YET! </strong></td>
                </tr>
            </tbody>
        </table>
        <!-- MAIN TABLE END -->

        <!-- CONTROL BAR START -->
        <div class="bottom-bar">

            <div class="display-controls">
                <span>Showing</span>
                <select id="perPageSelect" class="per-page-select">
                    <option value="5"> 5 </option>
                    <option value="10"> 10 </option>
                    <option value="20"> 20 </option>
                    <option value="50"> 50 </option>
                </select>
                <span> of </span>
                <span id="totalMembers"> 0 </span>
                <span> members </span>
            </div>

            <!-- PAGINATION START -->
            <div class="pagination-controls">
                <button class="page-btn">&lt;</button>
                <button class="page-btn">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">&gt;</button>
            </div>
            <!-- END OF PAGINATION -->
        </div>
        <!-- CONTROL BAR END -->
    </main>
</body>
</html>