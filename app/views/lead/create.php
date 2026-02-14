

<div class="container mt-4">
    <h2>Create Lead</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL; ?>/lead/create">
                
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Company Name *</label>
                        <input type="text" name="company_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Contact Name *</label>
                        <input type="text" name="contact_name" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status *</label>
                        <select name="status_id" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status['id']; ?>">
                                    <?= htmlspecialchars($status['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    
                        <div class="col-md-6 mb-3">
        <label>Lead Source</label>
        <select name="source" class="form-select">
            <option value="">-- Select Source --</option>
            <option value="Website">Website</option>
            <option value="Facebook">Facebook</option>
            <option value="LinkedIn">LinkedIn</option>
            <option value="Google Ads">Google Ads</option>
            <option value="Referral">Referral</option>
            <option value="Cold Call">Cold Call</option>
            <option value="Email Campaign">Email Campaign</option>
            <option value="Trade Show">Trade Show</option>
            <option value="Other">Other</option>
        </select>
    </div>
                </div>

                <div class="row">
                    

                    <div class="col-md-6 mb-3">
                        <label>Estimated Value</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="estimated_value" class="form-control" 
                                   step="0.01" min="0" value="0">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Save Lead</button>
                <a href="<?= BASE_URL; ?>/lead" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>
</div>