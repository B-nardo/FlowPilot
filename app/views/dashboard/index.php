<div class="container-fluid mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</p>
        </div>
        <div>
            <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Lead
            </a>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Leads</p>
                            <h3 class="mb-0 fw-bold"><?= $totalLeads ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +12% from last month
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Closed Won</p>
                            <h3 class="mb-0 fw-bold"><?= $closedWon ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-trophy-fill text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +8% from last month
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Conversion Rate</p>
                            <h3 class="mb-0 fw-bold"><?= $conversionRate ?>%</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-graph-up-arrow text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar" 
                                 style="width: <?= $conversionRate ?>%" 
                                 aria-valuenow="<?= $conversionRate ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Pipeline Value</p>
                            <h3 class="mb-0 fw-bold">$<?= number_format($pipelineValue, 0) ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cash-stack text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            Across <?= $totalLeads ?> opportunities
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PIPELINE BY STATUS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0">Pipeline Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php 
                        $statusColors = [
                            'New' => 'primary',
                            'Contacted' => 'info',
                            'Qualified' => 'warning',
                            'Proposal' => 'purple',
                            'Negotiation' => 'orange',
                            'Won' => 'success',
                            'Lost' => 'danger'
                        ];
                        
                        foreach ($statusCounts as $status => $total): 
                            // Get color or default to secondary
                            $color = 'secondary';
                            foreach ($statusColors as $key => $value) {
                                if (stripos($status, $key) !== false) {
                                    $color = $value;
                                    break;
                                }
                            }
                        ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="card border-0 bg-<?= $color ?> bg-opacity-10 h-100">
                                    <div class="card-body text-center">
                                        <div class="badge bg-<?= $color ?> bg-opacity-100 mb-2 px-3 py-2">
                                            <?= htmlspecialchars($status) ?>
                                        </div>
                                        <h2 class="mb-0 fw-bold text-<?= $color ?>"><?= $total ?></h2>
                                        <p class="text-muted small mb-0 mt-1">leads</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="row">
        
        <!-- RECENT LEADS -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Leads</h5>
                        <a href="<?= BASE_URL; ?>/lead" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recentLeads)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Company</th>
                                        <th class="border-0">Contact</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Value</th>
                                        <th class="border-0 text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentLeads as $lead): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <span class="text-primary fw-bold">
                                                            <?= strtoupper(substr($lead['company_name'], 0, 1)) ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            <?= htmlspecialchars($lead['company_name']) ?>
                                                        </div>
                                                        <small class="text-muted">
                                                            <?= htmlspecialchars($lead['email']) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><?= htmlspecialchars($lead['contact_name']) ?></div>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($lead['phone'] ?? 'No phone') ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-75">
                                                    <?= htmlspecialchars($lead['status_name']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-success">
                                                    $<?= number_format($lead['estimated_value'], 0) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No recent leads found</p>
                            <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary btn-sm mt-2">
                                <i class="bi bi-plus-circle"></i> Create Your First Lead
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: TASKS + ACTIVITY -->
        <div class="col-lg-4 mb-4">
            
            <!-- UPCOMING TASKS -->
            <?php if (!empty($upcomingTasks)): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Upcoming Tasks</h5>
                        <span class="badge bg-warning"><?= count($upcomingTasks) ?></span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($upcomingTasks as $task): ?>
                            <div class="list-group-item border-0 px-4">
                                <div class="d-flex align-items-start">
                                    <input type="checkbox" class="form-check-input me-3 mt-1" 
                                           <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold mb-1">
                                            <?= htmlspecialchars($task['title']) ?>
                                        </div>
                                        <div class="small text-muted mb-1">
                                            <i class="bi bi-building"></i>
                                            <?= htmlspecialchars($task['company_name']) ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-<?= $task['status'] === 'overdue' ? 'danger' : 'warning' ?> badge-sm">
                                                <?= ucfirst($task['status']) ?>
                                            </span>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                <?= date('M d, g:i A', strtotime($task['due_date'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- QUICK STATS -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <p class="text-muted mb-0 small">Active Leads</p>
                            <h4 class="mb-0 fw-bold"><?= $totalLeads - $closedWon ?></h4>
                        </div>
                        <i class="bi bi-lightning-charge-fill text-warning fs-2"></i>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <p class="text-muted mb-0 small">Avg. Deal Size</p>
                            <h4 class="mb-0 fw-bold">
                                $<?= $totalLeads > 0 ? number_format($pipelineValue / $totalLeads, 0) : 0 ?>
                            </h4>
                        </div>
                        <i class="bi bi-graph-up text-success fs-2"></i>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0 small">Win Rate</p>
                            <h4 class="mb-0 fw-bold"><?= $conversionRate ?>%</h4>
                        </div>
                        <i class="bi bi-bullseye text-info fs-2"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Custom CSS for avatar -->
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}

.table tbody tr {
    transition: background-color 0.15s;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>