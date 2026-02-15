<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Task</h2>
        <a href="<?= BASE_URL; ?>/task" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Tasks
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL; ?>/task/edit/<?= $task['id']; ?>">
                
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Task Title *</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($task['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Due Date *</label>
                        <input type="datetime-local" name="due_date" class="form-control" 
                               value="<?= date('Y-m-d\TH:i', strtotime($task['due_date'])); ?>" required>
                    </div>

                    <?php if (!empty($users)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Assigned To</label>
                        <select name="assigned_user_id" class="form-select">
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id']; ?>"
                                    <?= $task['assigned_user_id'] == $user['id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($user['name']); ?> 
                                    (<?= ucfirst($user['role']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Task
                    </button>
                    <a href="<?= BASE_URL; ?>/task" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>