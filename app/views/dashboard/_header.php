    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0"> Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>! <span class="badge bg-light text-dark ms-2"> <?= ucfirst($_SESSION['user_role']); ?> </span> </p>
        </div>
        <div class="d-flex gap-2"> <a href="<?= BASE_URL; ?>/task/create" class="btn btn-outline-primary"> <i class="bi bi-plus-circle"></i> New Task </a> <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> New Lead </a> </div>
    </div> 