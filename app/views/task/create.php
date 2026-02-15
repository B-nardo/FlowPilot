<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Create New Task</h2>
        <a href="<?= BASE_URL; ?>/task" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Tasks
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL; ?>/task/create">
                
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Task Title *</label>
                        <input type="text" name="title" class="form-control" 
                               placeholder="Follow up with customer" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Lead *</label>
                        <select name="lead_id" class="form-select" required>
                            <option value="">-- Select Lead --</option>
                            <?php foreach ($leads as $lead): ?>
                                <option value="<?= $lead['id']; ?>">
                                    <?= htmlspecialchars($lead['company_name']); ?> - 
                                    <?= htmlspecialchars($lead['contact_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="Additional details about this task..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Due Date *</label>
                        <input type="datetime-local" name="due_date" class="form-control" required>
                    </div>

                    <?php if (!empty($users)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Assign To</label>
                        <select name="assigned_user_id" class="form-select">
                            <option value="<?= $_SESSION['user_id']; ?>">Myself</option>
                            <?php foreach ($users as $user): ?>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <option value="<?= $user['id']; ?>">
                                        <?= htmlspecialchars($user['name']); ?> 
                                        (<?= ucfirst($user['role']); ?>)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Create Task
                    </button>
                    <a href="<?= BASE_URL; ?>/task" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>