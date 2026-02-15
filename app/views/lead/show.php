<div class="container-fluid mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>/lead">Leads</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($lead['company_name']); ?></li>
                </ol>
            </nav>
            <h2 class="mb-1">
                <div class="avatar-md bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2">
                    <span class="text-primary fw-bold fs-5">
                        <?= strtoupper(substr($lead['company_name'], 0, 1)) ?>
                    </span>
                </div>
                <?= htmlspecialchars($lead['company_name']); ?>
            </h2>
            <p class="text-muted mb-0">
                <span class="badge bg-info bg-opacity-75 rounded-pill">
                    <?= htmlspecialchars($lead['status_name']); ?>
                </span>
                <?php if ($lead['source']): ?>
                    <span class="badge bg-light text-dark border ms-1">
                        <?= htmlspecialchars($lead['source']); ?>
                    </span>
                <?php endif; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Lead
            </a>
            <a href="<?= BASE_URL; ?>/lead" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Leads
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            
            <!-- Lead Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle text-primary"></i> Contact Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Contact Name</small>
                                    <strong><?= htmlspecialchars($lead['contact_name']); ?></strong>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-envelope text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <a href="mailto:<?= htmlspecialchars($lead['email']); ?>" class="text-decoration-none">
                                        <strong><?= htmlspecialchars($lead['email']); ?></strong>
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-telephone text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <?php if ($lead['phone']): ?>
                                        <a href="tel:<?= htmlspecialchars($lead['phone']); ?>" class="text-decoration-none">
                                            <strong><?= htmlspecialchars($lead['phone']); ?></strong>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Not provided</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-currency-dollar text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Estimated Value</small>
                                    <strong class="text-success fs-5">$<?= number_format($lead['estimated_value'], 2); ?></strong>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-tag text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Source</small>
                                    <strong><?= htmlspecialchars($lead['source'] ?? 'Not specified'); ?></strong>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="bg-secondary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-calendar-plus text-secondary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Created</small>
                                    <strong><?= date('M d, Y g:i A', strtotime($lead['created_at'])); ?></strong>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                                                    <div>
                                    <small class="text-muted d-block">Loss Reason</small>
                                    <?php if ($lead['phone']): ?>
                                            <strong class="text-muted"><?= htmlspecialchars($lead['loss_reason']); ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">Not provided</span>
                                    <?php endif; ?>
                                </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text text-primary"></i> Notes & Activity
                    </h5>
                </div>
                <div class="card-body p-4">

                    <!-- Add Note Form -->
                    <form method="POST" action="<?= BASE_URL; ?>/lead/addNote/<?= $lead['id']; ?>" class="mb-4">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Add a Note</label>
                            <textarea name="note" class="form-control" rows="3" required
                                      placeholder="Enter your note here..." style="resize: none;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add Note
                        </button>
                    </form>

                    <!-- Notes List -->
                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">Activity Timeline</h6>

                    <?php if (!empty($notes)): ?>
                        <div class="timeline">
                            <?php foreach ($notes as $note): ?>
                                <div class="timeline-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <span class="text-primary fw-bold small">
                                                        <?= strtoupper(substr($note['user_name'], 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong><?= htmlspecialchars($note['user_name']); ?></strong>
                                                    <small class="text-muted ms-2">
                                                        <i class="bi bi-clock"></i>
                                                        <?= date('M d, Y g:i A', strtotime($note['created_at'])); ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <p class="mb-0 ms-5"><?= nl2br(htmlspecialchars($note['note'])); ?></p>
                                        </div>
                                        
                                        <?php if (in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
                                            <a href="<?= BASE_URL; ?>/lead/deleteNote/<?= $note['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger ms-2"
                                               onclick="return confirm('Delete this note?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-chat-left-dots fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No notes yet. Add the first note above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            
            <!-- Tasks Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-check2-square text-success"></i> Tasks
                        </h5>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="bi bi-plus-circle"></i> Add
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($tasks)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($tasks as $task): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($task['title']); ?></h6>
                                            <?php if ($task['description']): ?>
                                                <p class="mb-2 text-muted small">
                                                    <?= htmlspecialchars(substr($task['description'], 0, 60)); ?>
                                                    <?= strlen($task['description']) > 60 ? '...' : '' ?>
                                                </p>
                                            <?php endif; ?>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-person"></i>
                                                    <?= htmlspecialchars($task['assigned_to']); ?>
                                                </small>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i>
                                                    <?= date('M d, Y', strtotime($task['due_date'])); ?>
                                                </small>
                                            </div>
                                        </div>
                                        <span class="badge rounded-pill bg-<?= $task['status'] === 'completed' ? 'success' : ($task['status'] === 'overdue' ? 'danger' : 'warning'); ?> ms-2">
                                            <?= ucfirst($task['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 px-3">
                            <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted small mb-0">No tasks yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="mailto:<?= htmlspecialchars($lead['email']); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-envelope"></i> Send Email
                        </a>
                        <?php if ($lead['phone']): ?>
                            <a href="tel:<?= htmlspecialchars($lead['phone']); ?>" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-telephone"></i> Call
                            </a>
                        <?php endif; ?>
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="bi bi-plus-circle"></i> Create Task
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= BASE_URL; ?>/lead/addTask/<?= $lead['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Follow up with lead" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="Additional details..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="due_date" class="form-control" required>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Add Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 36px;
    height: 36px;
    font-size: 14px;
}

.avatar-md {
    width: 48px;
    height: 48px;
    font-size: 20px;
}

.timeline-item:last-child {
    border-bottom: none !important;
}
</style>