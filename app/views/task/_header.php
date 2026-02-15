    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-check2-square text-primary"></i> Tasks
            </h2>
            <p class="text-muted mb-0">
                Manage your tasks and to-dos • 
                <span class="text-primary fw-semibold"><?= $stats['total'] ?> total tasks</span>
            </p>
        </div>
        <a href="<?= BASE_URL; ?>/task/create" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> New Task
        </a>
    </div>