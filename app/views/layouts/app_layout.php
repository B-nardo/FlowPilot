<?php
// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/auth/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.css">
</head>
<body>

<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
        <h4 class="mb-4">FlowPilot</h4>

        <ul class="nav nav-pills flex-column">

            <li class="nav-item mb-2">
                <a href="<?= BASE_URL ?>/dashboard" class="nav-link text-white">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= BASE_URL ?>/leads" class="nav-link text-white">
                    Leads
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= BASE_URL ?>/tasks" class="nav-link text-white">
                    Tasks
                </a>
            </li>

            <?php if($_SESSION['user_role'] === 'admin'): ?>
            <li class="nav-item mb-2">
                <a href="<?= BASE_URL ?>/users" class="nav-link text-white">
                    Users
                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item mt-4">
                <a href="<?= BASE_URL ?>/auth/logout" class="nav-link text-danger">
                    Logout
                </a>
            </li>

        </ul>
    </div>

    <!-- Page Content -->
    <div class="flex-fill p-4 bg-light">
        <?= $content ?>
    </div>

</div>

</body>
</html>
