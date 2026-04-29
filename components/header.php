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
    <div class="header-right">
        <span class="header-welcome">
            Welcome, <strong><?= htmlspecialchars($_SESSION['officer_name'] ?? 'User') ?></strong>
        </span>
        <a href="userprofile.php" class="profile-area">
            <?php
                $headerPfp = !empty($_SESSION['profile_picture'])
                    ? 'uploads/profiles/' . htmlspecialchars($_SESSION['profile_picture'])
                    : 'pfp.png';
            ?>
            <img src="<?= $headerPfp ?>" alt="Profile" class="profile-icon" id="headerProfileIcon">
        </a>
        <a href="logout.php" class="logout-btn" title="Logout">
            <span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</header>