    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Total Tasks</p>
                            <h3 class="mb-0 fw-bold"><?= $stats['total'] ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-list-check text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Pending</p>
                            <h3 class="mb-0 fw-bold text-warning"><?= $stats['pending'] ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-clock text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php 
                        $pendingPercentage = $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100) : 0;
                        ?>
                        <small class="text-muted"><?= $pendingPercentage ?>% of total</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Completed</p>
                            <h3 class="mb-0 fw-bold text-success"><?= $stats['completed'] ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php 
                        $completionRate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;
                        ?>
                        <small class="text-success fw-semibold">
                            <i class="bi bi-arrow-up"></i> <?= $completionRate ?>% completion rate
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Overdue</p>
                            <h3 class="mb-0 fw-bold text-danger"><?= $stats['overdue'] ?></h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php if ($stats['overdue'] > 0): ?>
                            <small class="text-danger fw-semibold">
                                <i class="bi bi-exclamation-circle"></i> Needs attention
                            </small>
                        <?php else: ?>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> All on track
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>