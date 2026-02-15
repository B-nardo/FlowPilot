<div class="container mt-4">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-pencil text-warning"></i> Edit Lead
            </h2>
            <p class="text-muted mb-0">Update <?= htmlspecialchars($lead['company_name']); ?> information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>" class="btn btn-outline-primary">
                <i class="bi bi-eye"></i> View Lead
            </a>
            <a href="<?= BASE_URL; ?>/lead" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Leads
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Lead Information</h5>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i>
                            Last updated: <?= date('M d, Y g:i A', strtotime($lead['updated_at'] ?? $lead['created_at'])); ?>
                        </small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>">

                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                        <!-- Company & Contact -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Company Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <input type="text" name="company_name" class="form-control border-start-0"
                                        value="<?= htmlspecialchars($lead['company_name']); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Contact Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="contact_name" class="form-control border-start-0"
                                        value="<?= htmlspecialchars($lead['contact_name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0"
                                        value="<?= htmlspecialchars($lead['email']); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" name="phone" class="form-control border-start-0"
                                        value="<?= htmlspecialchars($lead['phone']); ?>">
                                </div>
                            </div>
                        </div>

                        

<!-- Status & Source -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Status <span class="text-danger">*</span>
        </label>
        <select name="status_id" id="statusSelect" class="form-select" required>
            <?php foreach ($statuses as $status): ?>
                <option value="<?= $status['id']; ?>"
                    data-requires-reason="<?= $status['requires_reason'] ?? 0; ?>"
                    <?= ($lead['status_id'] == $status['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($status['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Lead Source</label>
        <select name="source" class="form-select">
            <option value="">-- Select Source --</option>
            <?php 
            $sources = [
                'Website' => '🌐 Website',
                'Facebook' => '📘 Facebook',
                'LinkedIn' => '💼 LinkedIn',
                'Google Ads' => '🎯 Google Ads',
                'Referral' => '👥 Referral',
                'Cold Call' => '📞 Cold Call',
                'Email Campaign' => '📧 Email Campaign',
                'Trade Show' => '🎪 Trade Show',
                'Other' => '📋 Other'
            ];
            foreach ($sources as $value => $label): 
            ?>
                <option value="<?= $value ?>" 
                    <?= ($lead['source'] ?? '') === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row" id="lossReasonGroup">
    <div class="col-12 mb-3">
        <label class="form-label fw-semibold">
            Loss Reason <span class="text-danger" id="reasonRequired" style="display: none;">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-exclamation-triangle"></i>
            </span>
            <textarea 
                name="loss_reason" 
                id="lossReasonInput"
                class="form-control border-start-0" 
                rows="4"
                placeholder="Select a negative status to provide a loss reason..."
                disabled
            ><?= htmlspecialchars($lead['loss_reason'] ?? ''); ?></textarea>
        </div>
        <small class="text-muted" id="reasonHelpText">
            <i class="bi bi-info-circle"></i> 
            This field becomes required when marking a lead as lost
        </small>
    </div>
</div>

                        <!-- Estimated Value -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Estimated Value</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                    <input type="number" name="estimated_value" class="form-control"
                                        step="0.01" min="0"
                                        value="<?= htmlspecialchars($lead['estimated_value']); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                            <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>" class="btn btn-outline-secondary btn-lg">
                                Cancel
                            </a>
                            <?php if (in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
                                <a href="<?= BASE_URL; ?>/lead/delete/<?= $lead['id']; ?>" 
                                   class="btn btn-outline-danger btn-lg ms-auto"
                                   onclick="return confirm('Are you sure you want to delete this lead?');">
                                    <i class="bi bi-trash"></i> Delete Lead
                                </a>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Activity Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 fw-bold">Lead Activity</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-calendar-plus text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Created</small>
                            <strong><?= date('M d, Y', strtotime($lead['created_at'])); ?></strong>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-arrow-repeat text-info"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Last Updated</small>
                            <strong><?= date('M d, Y', strtotime($lead['updated_at'] ?? $lead['created_at'])); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info border-0">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Tip:</strong> Changes are saved immediately when you click "Save Changes"
            </div>
        </div>
    </div>

</div>

<style>
.form-control:focus, .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
}

.input-group-text {
    border-right: none;
}

.form-control {
    border-left: none;
}
</style>

<?php require APPROOT . '/views/lead/_editScript.php'; ?>