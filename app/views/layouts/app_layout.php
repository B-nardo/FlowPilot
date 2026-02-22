<?php
// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/auth/login");
    exit;
}

// Get current page for active state
$currentPage = $_GET['url'] ?? 'dashboard';
$currentPage = explode('/', $currentPage)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --primary: #6366f1;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Base */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Mobile: Hide sidebar off-screen */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-brand small {
            color: #94a3b8;
            font-size: 0.75rem;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 1rem 0.75rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            background: var(--primary);
            color: white;
        }

        /* User Section */
        .sidebar-user {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
            margin-top: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 0.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: var(--sidebar-hover);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            color: #94a3b8;
            font-size: 0.75rem;
            margin: 0;
        }

        /* Logout Link */
        .nav-link.logout-link {
            color: #f87171 !important;
        }

        .nav-link.logout-link:hover {
            background: rgba(248, 113, 113, 0.1);
            color: #ef4444 !important;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.3s ease;
        }

        /* Mobile: No margin, full width */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1030;
            background: var(--primary);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .mobile-toggle:hover {
            background: #4f46e5;
            transform: scale(1.05);
        }

        @media (max-width: 991.98px) {
            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .sidebar-brand h4 {
                font-size: 1.25rem;
            }

            .sidebar .nav-link {
                padding: 0.875rem 1rem;
            }

            .main-content {
                padding-top: 4rem !important;
            }
        }

        /* Scrollbar for sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Hide scrollbar on mobile when sidebar is hidden */
        @media (max-width: 991.98px) {
            body {
                overflow-x: hidden;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Toggle Button -->
<button class="mobile-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <i class="bi bi-list fs-4"></i>
</button>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        
        <!-- Brand -->
        <div class="sidebar-brand">
            <h4>
                <i class="bi bi-box-seam-fill text-primary"></i>
                FlowPilot
            </h4>
            <small>CRM Platform</small>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav">
            
            <!-- Main Menu -->
            <div class="nav-section">
                <div class="nav-section-title">Main Menu</div>
                
                <nav class="nav flex-column">
                    <a href="<?= BASE_URL ?>/dashboard" 
                       class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?= BASE_URL ?>/lead" 
                       class="nav-link <?= $currentPage === 'lead' ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        <span>Leads</span>
                    </a>

                    <a href="<?= BASE_URL ?>/task" 
                       class="nav-link <?= $currentPage === 'task' ? 'active' : '' ?>">
                        <i class="bi bi-check2-square"></i>
                        <span>Tasks</span>
                    </a>
                </nav>
            </div>

            <!-- Admin Section -->
            <?php if(in_array($_SESSION['user_role'], ['admin', 'super_admin'])): ?>
            <div class="nav-section">
                <div class="nav-section-title">Administration</div>
                
                <nav class="nav flex-column">
                    <a href="<?= BASE_URL ?>/users" 
                       class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                        <i class="bi bi-person-gear"></i>
                        <span>Users</span>
                    </a>

                    <a href="<?= BASE_URL ?>/settings" 
                       class="nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </nav>
            </div>
            <?php endif; ?>

            <!-- Account Section -->
            <div class="nav-section">
                <nav class="nav flex-column">
                    <a href="<?= BASE_URL ?>/auth/logout" class="nav-link logout-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>

        </div>

        <!-- User Profile -->
        <div class="sidebar-user">
            <a href="#" class="user-profile">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-info">
                    <p class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></p>
                    <p class="user-role"><?= ucfirst($_SESSION['user_role'] ?? 'Staff') ?></p>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </a>
        </div>

    </div>

    <!-- Main Content -->
    <div class="main-content flex-fill p-4">
        <?= $content ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar Toggle for Mobile
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function toggleSidebar() {
    sidebar.classList.toggle('show');
    sidebarOverlay.classList.toggle('show');
    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
}

sidebarToggle.addEventListener('click', toggleSidebar);
sidebarOverlay.addEventListener('click', toggleSidebar);

// Close sidebar when clicking a link (mobile only)
if (window.innerWidth < 992) {
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (sidebar.classList.contains('show')) {
                toggleSidebar();
            }
        });
    });
}

// Handle window resize
window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }
});
</script>
</body>
</html>