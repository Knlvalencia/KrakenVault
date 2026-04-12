<header class="kraken-header">
    <div class="nav-group">
        <button class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <img src="logo.png" alt="logo" class="logo">
        <nav class="nav-menu">
            <a href="documentarchive.php" class="<?php echo ($activePage == 'archive') ? 'active' : ''; ?>">Document Archive</a>
            <a href="activitylog.php" class="<?php echo ($activePage == 'activity') ? 'active' : ''; ?>">Activity Log</a>
            <a href="usermanagement.php" class="<?php echo ($activePage == 'users') ? 'active' : ''; ?>">User Management</a>
        </nav>
    </div>
    <a href="userprofile.php" class="profile-area">
        <img src="pfp.png" alt="Profile" class="profile-icon">
    </a>
</header>