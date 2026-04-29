<?php 
require_once __DIR__ . '/components/check_auth.php'; 
require_once __DIR__ . '/classes/AuditLog.php';
$auditModel = new AuditLog();
$logs = $auditModel->getAllLogs();

$pageTitle = 'Activity Log'; 
$activePage = 'activity'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <link rel="stylesheet" href="activity.css?v=<?php echo time(); ?>">
    <style>
        .activity-search-group {
            margin-left: auto !important;
            flex: 0 1 auto !important;
        }
        .search-form {
            width: 400px !important;
            flex: 0 0 400px !important;
        }
        .search-wrapper {
            background-color: #f1f3f4 !important;
            border-radius: 24px !important;
            height: 48px !important;
            padding: 0 16px 0 48px !important;
            display: flex !important;
            align-items: center !important;
            position: relative !important;
            transition: background 0.2s, box-shadow 0.2s !important;
        }
        .search-wrapper:focus-within {
            background-color: #fff !important;
            box-shadow: 0 1px 3px rgba(60,64,67,0.3) !important;
        }
        .search-icon {
            position: absolute !important;
            left: 16px !important;
            font-size: 24px !important;
            color: #5f6368 !important;
            pointer-events: none !important;
        }
        .search-input {
            border: none !important;
            background: transparent !important;
            width: 100% !important;
            height: 100% !important;
            font-size: 16px !important;
            outline: none !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="activity-content"> 
        <div class="activity-header-controls">
            <h1>Activity Log</h1>
            <div class="activity-search-group">
                <form class="search-form">
                    <div class="search-wrapper">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" class="search-input" placeholder="Search Activity...">
                    </div>
                </form>
            
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
                <?php if (empty($logs)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #666;"><strong>NO ACTIVITIES YET!</strong></td>
                </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td data-label="Date and Time"><?= htmlspecialchars($log['activitydate'] . ' ' . $log['activitytime']) ?></td>
                        <td data-label="Account"> 
                            <div class="td-content">
                                <a href="#" class="primary-text link"><?= htmlspecialchars($log['firstname'] . ' ' . $log['lastname']) ?></a>
                                <span class="secondary-text">User ID: <?= htmlspecialchars($log['officerid']) ?></span>
                            </div>
                        </td>
                        <td data-label="User">
                            <div class="td-content">
                                <strong class="primary-text"><?= htmlspecialchars($log['firstname'] . ' ' . $log['lastname']) ?></strong>
                            </div>
                        </td>
                        <td data-label="Activity ID">
                            <span class="primary-text" style="font-family: monospace;"><?= htmlspecialchars($log['activityid']) ?></span>
                        </td>
                        <td data-label="Actions">
                            <div class="td-content">
                                <span><?= htmlspecialchars($log['activity']) ?></span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
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