<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-plus-circle text-primary"></i> Create New Lead
            </h2>
            <p class="text-muted mb-0">Add a new lead to your sales pipeline</p>
        </div>
        <a href="<?= BASE_URL; ?>/lead" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Leads
        </a>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Lead Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL; ?>/lead/create">

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
                                        placeholder="Acme Corporation" required autofocus>
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
                                        placeholder="John Doe" required>
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
                                        placeholder="john@acme.com" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" name="phone" class="form-control border-start-0"
                                        placeholder="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <!-- Status & Source -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status_id" class="form-select" required>
                                    <option value="">-- Select Status --</option>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status['id']; ?>">
                                            <?= htmlspecialchars($status['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted"><?= count($statuses) ?> statuses available</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Lead Source</label>
                                <select name="source" class="form-select">
                                    <option value="">-- Select Source --</option>
                                    <option value="Website">🌐 Website</option>
                                    <option value="Facebook">📘 Facebook</option>
                                    <option value="LinkedIn">💼 LinkedIn</option>
                                    <option value="Google Ads">🎯 Google Ads</option>
                                    <option value="Referral">👥 Referral</option>
                                    <option value="Cold Call">📞 Cold Call</option>
                                    <option value="Email Campaign">📧 Email Campaign</option>
                                    <option value="Trade Show">🎪 Trade Show</option>
                                    <option value="Other">📋 Other</option>
                                </select>
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
                                        step="0.01" min="0" value="0" placeholder="0.00">
                                </div>
                                <small class="text-muted">Expected deal value</small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-check-circle"></i> Create Lead
                            </button>
                            <a href="<?= BASE_URL; ?>/lead" class="btn btn-outline-secondary btn-lg">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Help Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-lightbulb text-warning"></i> Quick Tips
                    </h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            Enter accurate company information for better tracking
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            Add the estimated value to forecast revenue
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            Select the correct source to track ROI
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-info-circle"></i> What happens next?
                    </h6>
                    <p class="small mb-0">
                        After creating the lead, you can add notes, create tasks, and track the progress through your sales pipeline.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
    }

    .input-group-text {
        border-right: none;
    }

    .form-control {
        border-left: none;
    }

    .input-group .form-control:focus+.input-group-text,
    .input-group-text+.form-control:focus {
        border-color: #4f46e5;
    }
</style>