<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Leads</h2>
        <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary">
            + Add Lead
        </a>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Kanban Board View -->
    <div class="row">
        <?php foreach ($groupedLeads as $statusName => $leads): ?>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <?= htmlspecialchars($statusName); ?>
                            <span class="badge bg-light text-dark float-end">
                                <?= count($leads); ?>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                        <?php foreach ($leads as $lead): ?>
                            <div class="card mb-2">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-1">
                                        <?= htmlspecialchars($lead['company_name']); ?>
                                    </h6>
                                    <p class="card-text small text-muted mb-2">
                                        <?= htmlspecialchars($lead['contact_name']); ?>
                                    </p>
                                    <p class="small mb-2">
                                        <i class="bi bi-envelope"></i> 
                                        <?= htmlspecialchars($lead['email']); ?>
                                    </p>
                                    <p class="small mb-2">
                                        <strong>Value:</strong> 
                                        $<?= number_format($lead['estimated_value'], 2); ?>
                                    </p>
                                    <div class="d-flex gap-1">
                                        <a href="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>" 
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <a href="<?= BASE_URL; ?>/lead/delete/<?= $lead['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this lead?');">
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>