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
        <table class="file-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 25%; text-align: left; padding: 12px 15px;">Date and Time</th>
                    <th style="width: 20%; text-align: left; padding: 12px 15px;">Account</th>
                    <th style="width: 20%; text-align: left; padding: 12px 15px;">User</th>
                    <th style="width: 10%; text-align: left; padding: 12px 15px;">Activity ID</th>
                    <th style="width: 25%; text-align: left; padding: 12px 15px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #666;"><strong>NO ACTIVITIES YET!</strong></td>
                </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): 
                        $activityText = $log['activity'];
                        $icon = 'info';
                        $color = '#5f6368'; // Default gray

                        if (stripos($activityText, 'upload') !== false || stripos($activityText, 'add') !== false) {
                            $icon = 'add_circle';
                            $color = '#188038'; // Green
                        } elseif (stripos($activityText, 'delete') !== false || stripos($activityText, 'remove') !== false) {
                            $icon = 'delete';
                            $color = '#d93025'; // Red
                        } elseif (stripos($activityText, 'update') !== false || stripos($activityText, 'edit') !== false) {
                            $icon = 'edit';
                            $color = '#e37400'; // Orange
                        } elseif (stripos($activityText, 'download') !== false) {
                            $icon = 'download';
                            $color = '#1a73e8'; // Blue
                        } elseif (stripos($activityText, 'login') !== false) {
                            $icon = 'login';
                            $color = '#00796b'; // Teal
                        } elseif (stripos($activityText, 'logout') !== false) {
                            $icon = 'logout';
                            $color = '#5f6368'; // Gray
                        }
                    ?>
                    <tr>
                        <td data-label="Date and Time" style="font-size: 13px; color: #5f6368; padding: 12px 15px;"><?= htmlspecialchars($log['activitydate'] . ' ' . $log['activitytime']) ?></td>
                        <td data-label="Account" style="padding: 12px 15px;"> 
                            <div class="td-content">
                                <a href="#" class="primary-text link"><?= htmlspecialchars($log['firstname'] . ' ' . $log['lastname']) ?></a>
                                <span class="secondary-text">User ID: <?= htmlspecialchars($log['officerid']) ?></span>
                            </div>
                        </td>
                        <td data-label="User" style="padding: 12px 15px;">
                            <div class="td-content">
                                <strong class="primary-text"><?= htmlspecialchars($log['firstname'] . ' ' . $log['lastname']) ?></strong>
                            </div>
                        </td>
                        <td data-label="Activity ID" style="padding: 12px 15px;">
                            <span class="primary-text" style="font-family: monospace; font-size: 13px;"><?= htmlspecialchars($log['activityid']) ?></span>
                        </td>
                        <td data-label="Actions" style="padding: 12px 15px;">
                            <div class="td-content" style="display: flex; flex-direction: row; align-items: center; gap: 8px; color: <?= $color ?>;">
                                <span class="material-symbols-outlined" style="font-size: 20px; flex-shrink: 0;"><?= $icon ?></span>
                                <span style="font-weight: 500; font-size: 13px;"><?= htmlspecialchars($activityText) ?></span>
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