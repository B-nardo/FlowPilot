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
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
        }

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
            background: var(--bs-primary);
            color: white;
        }

        /* User Section */
        .sidebar-user {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
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
            background: var(--bs-primary);
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
            color: var(--bs-danger) !important;
        }

        .nav-link.logout-link:hover {
            background: rgba(248, 113, 113, 0.1);
            color: #ef4444 !important;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            display: none; /* Optional - remove if you want a top bar */
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">
        
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
            <?php if($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'super_admin'): ?>
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
</body>
</html>