<?php 
$pageTitle = 'Activity Log'; 
$activePage = 'activity'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <link rel="stylesheet" href="activity.css">
</head>
<body>
    <?php include 'components/header.php'; ?>
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
            
                <div class="filter_btn">
                    <div class="filter-by-user">
                        <span>Filter by User</span>
                        <select class="row-select">
                            <option value="all-users" selected>All Users</option>
                            <option value="user1">John CIC</option>
                            <option value="user2">John USeP</option>
                            <option value="user3">John John</option>
                            <option value="user4">John CED</option>
                        </select>
                    </div>

                    <div class="filter-by-action">
                        <span>Filter by Action</span>
                        <select class="row-select">
                            <option value="all-actions" selected>All Actions</option>
                            <option value="action1">Updated Document</option>
                            <option value="action2">Downloaded Document</option>
                            <option value="action3">Uploaded Document</option>
                        </select>
                    </div>
                </div> 
            </div>
        </div>
        <table class="file-table">
            <thead>
                <tr>
                    <th>Date and Time</th>
                    <th>Account</th>
                    <th>User</th>
                    <th>Activity ID</th> <th>Actions</th>
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
                    <td data-label="Activity ID">
                        <span class="primary-text" style="font-family: monospace;">2026-041701ABCD</span>
                    </td>
                    <td data-label="Actions">
                        <div class="td-content">
                            <span>Downloaded <a href="#" class="file-link">name_of_file.pdf</a></span>
                        </div>
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
                    <td data-label="Activity ID">
                        <span class="primary-text" style="font-family: monospace;">2026-041702XYZA</span>
                    </td>
                    <td data-label="Actions">
                        <div class="td-content">
                            <span>Downloaded <a href="#" class="file-link">name_of_file.pdf</a></span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td data-label="Date and Time">04/08/2026, 11:30AM</td>
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
                    <td data-label="Activity ID">
                        <span class="primary-text" style="font-family: monospace;">2026-040811TRQE</span>
                    </td>
                    <td data-label="Actions">
                        <div class="td-content">
                            <span>Uploaded <a href="#" class="file-link">name_of_file.pdf</a></span>
                        </div>
                    </td>
                </tr>

                </tbody>
        </table>
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
    </main>
</body>
</html>