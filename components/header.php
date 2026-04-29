<header class="kraken-header">
    <div class="nav-group">
        <button class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <img src="logo.png" alt="logo" class="logo">
        <nav class="nav-menu">
            <a href="documentarchive.php" class="<?php echo ($activePage == 'archive') ? 'active' : ''; ?>">
                <span class="material-symbols-outlined">folder_open</span>
                <span>Document Archive</span>
            </a>
            <a href="activitylog.php" class="<?php echo ($activePage == 'activity') ? 'active' : ''; ?>">
                <span class="material-symbols-outlined">history</span>
                <span>Activity Log</span>
            </a>
            <a href="usermanagement.php" class="<?php echo ($activePage == 'users') ? 'active' : ''; ?>">
                <span class="material-symbols-outlined">manage_accounts</span>
                <span>User Management</span>
            </a>
        </nav>
    </div>
    <a href="userprofile.php" class="profile-area">
        <img src="pfp.png" alt="Profile" class="profile-icon">
    </a>
</header>