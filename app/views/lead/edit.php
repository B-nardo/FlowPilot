<div class="container mt-4">
    <h2>Edit Lead</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>">
                
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Company Name *</label>
                        <input type="text" name="company_name" class="form-control" 
                               value="<?= htmlspecialchars($lead['company_name']); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Contact Name *</label>
                        <input type="text" name="contact_name" class="form-control" 
                               value="<?= htmlspecialchars($lead['contact_name']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= htmlspecialchars($lead['email']); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" 
                               value="<?= htmlspecialchars($lead['phone']); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status *</label>
                        <select name="status_id" class="form-select" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status['id']; ?>"
                                    <?= ($lead['status_id'] == $status['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($status['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Estimated Value</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="estimated_value" class="form-control" 
                                   step="0.01" min="0" 
                                   value="<?= htmlspecialchars($lead['estimated_value']); ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Lead</button>
                <a href="<?= BASE_URL; ?>/lead" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>
</div>