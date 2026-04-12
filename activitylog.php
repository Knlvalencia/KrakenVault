<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kraken Vault | Activity Log</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="activity.css">
    <script src="main.js"></script>
</head>
<body>
    <!-- HEADER START -->
    <header class="kraken-header">
        <div class="nav-group">
            <button class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <img src="logo.png" alt="logo" class="logo">
            <nav class="nav-menu">
                <a href="documentarchive.html">Document Archive</a>
                <a href="ActivityLog.html" class="active">Activity Log</a>
                <a href="UserManagement.html">User Management</a>
            </nav>
        </div>
        <a href="UserProfile.html" class="profile-area">
            <img src="pfp.png" alt="Profile" class="profile-icon">
        </a>
    </header>
    <!-- HEADER END -->

    <!-- TOP BAR START -->
    <main class="activity-content"> 
        <div class="activity-header-controls">
            <h1>Activity Log</h1>
            <div class="activity-search-group">
                <div class="search-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" class="search-input with-icon" placeholder="Search Activity...">
                </div>
                <button class="action-button filter-btn">+ Add Filter</button>
                <button class="action-button">•••</button>
            </div>
        </div>
        <!-- TOP BAR END -->

        <!-- MAIN CONTENT START -->
        <table class="file-table">
            <thead>
                <tr>
                    <th>Date and Time</th>
                    <th>Account</th>
                    <th>User</th>
                    <th>Actions</th>
                    <th style="width: 80px; text-align: center;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Date and Time">03/31/2026, 4:00AM</td>
                    <td data-label="Account"> 
                        <div class="td-content">
                            <a href="#" class="primary-text link">John CIC</a>
                            <span class="secondary-text">2025-0001</span>
                        </div>
                    </td>
                    <td data-label="User">
                        <div class="td-content">
                            <strong class="primary-text">Tony Stark</strong>
                            <span class="secondary-text">tstark@yourcompany.com</span>
                        </div>
                    </td>
                    <td data-label="Actions">
                        <div class="td-content">
                            <span>Downloaded <a href="#" class="file-link">name_of_file.pdf</a></span>
                        </div>
                    </td>
                    <td class="actions-cell" data-label="Undo"> 
                        <a href="#" class="undo-link">Undo</a>
                    </td>
                </tr>
                <tr>
                    <td data-label="Date and Time">03/31/2026, 5:00AM</td>
                    <td data-label="Account"> 
                        <div class="td-content">
                            <a href="#" class="primary-text link">John USeP</a>
                            <span class="secondary-text">2025-0002</span>
                        </div>
                    </td>
                    <td data-label="User">
                        <div class="td-content">
                            <strong class="primary-text">Mark Aslom</strong>
                            <span class="secondary-text">maslom@yourcompany.com</span>
                        </div>
                    </td>
                    <td data-label="Actions">
                        <div class="td-content">
                            <span>Downloaded <a href="#" class="file-link">name_of_file.pdf</a></span>
                        </div>
                    </td>
                    <td class="actions-cell" data-label="Undo"> 
                        <a href="#" class="undo-link">Undo</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- MAIN CONTENT END -->

        <!-- BOTTOM CONTROL BAR START -->
        <div class="bottom-bar">
            <div class="display-controls">
                <span>Rows per page</span>
                <select class="row-select">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="pagination-controls">
                <span style="margin-right: 12px; font-size: 14px; color: #5f6368;">1-10 of 200</span>
                <button class="page-btn">&lt;</button>
                <button class="page-btn">&gt;</button>
            </div>
        </div>
        <!-- BOTTOM CONTROL BAR END -->
    </main>
</body>
</html>