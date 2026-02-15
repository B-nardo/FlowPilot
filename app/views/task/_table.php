    <!-- Tasks Table -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header -->
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="taskSearch" class="form-control border-0 bg-light" 
                               placeholder="Search tasks...">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary" onclick="exportTasksCSV()">
                            <i class="bi bi-download"></i> Export
                        </button>
                        <button class="btn btn-outline-secondary" id="bulkComplete" style="display:none;">
                            <i class="bi bi-check-all"></i> Mark Complete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <?php if (!empty($tasks)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" id="tasksTable">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-4" width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAllTasks">
                                </th>
                                <th>Task</th>
                                <th>Lead</th>
                                <th>Assigned To</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr class="task-row <?= $task['status'] === 'completed' ? 'table-success bg-opacity-10' : '' ?>" 
                                    data-status="<?= $task['status'] ?>">
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input task-checkbox" 
                                               data-task-id="<?= $task['id'] ?>"
                                               <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                                    </td>
                                    <td>
                                        <div class="<?= $task['status'] === 'completed' ? 'text-decoration-line-through text-muted' : 'fw-semibold text-dark' ?>">
                                            <?= htmlspecialchars($task['title']) ?>
                                        </div>
                                        <?php if ($task['description']): ?>
                                            <small class="text-muted d-block mt-1">
                                                <?= htmlspecialchars(substr($task['description'], 0, 80)) ?>
                                                <?= strlen($task['description']) > 80 ? '...' : '' ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-primary fw-bold small">
                                                    <?= strtoupper(substr($task['company_name'], 0, 1)) ?>
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium"><?= htmlspecialchars($task['company_name']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($task['contact_name']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-person"></i>
                                            <?= htmlspecialchars($task['assigned_to']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $dueDate = strtotime($task['due_date']);
                                        $today = strtotime('today');
                                        $isOverdue = $dueDate < $today && $task['status'] !== 'completed';
                                        $daysUntil = floor(($dueDate - $today) / 86400);
                                        ?>
                                        <div class="<?= $isOverdue ? 'text-danger fw-semibold' : '' ?>">
                                            <?= date('M d, Y', $dueDate) ?>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            <?= date('g:i A', $dueDate) ?>
                                        </small>
                                        <?php if (!$isOverdue && $task['status'] !== 'completed'): ?>
                                            <br><small class="text-muted">
                                                <?= $daysUntil === 0 ? 'Today' : ($daysUntil === 1 ? 'Tomorrow' : "In $daysUntil days") ?>
                                            </small>
                                        <?php elseif ($isOverdue): ?>
                                            <br><small class="text-danger">
                                                <i class="bi bi-exclamation-circle"></i>
                                                <?= abs($daysUntil) ?> day(s) overdue
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-<?= $task['status'] === 'completed' ? 'success' : ($task['status'] === 'overdue' ? 'danger' : 'warning') ?>">
                                            <i class="bi bi-<?= $task['status'] === 'completed' ? 'check-circle' : ($task['status'] === 'overdue' ? 'exclamation-triangle' : 'clock') ?>"></i>
                                            <?= ucfirst($task['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL; ?>/task/toggleComplete/<?= $task['id']; ?>" 
                                               class="btn btn-outline-<?= $task['status'] === 'completed' ? 'warning' : 'success' ?>"
                                               data-bs-toggle="tooltip"
                                               title="<?= $task['status'] === 'completed' ? 'Mark Pending' : 'Mark Complete' ?>">
                                                <i class="bi bi-<?= $task['status'] === 'completed' ? 'arrow-counterclockwise' : 'check' ?>"></i>
                                            </a>
                                            <a href="<?= BASE_URL; ?>/task/edit/<?= $task['id']; ?>" 
                                               class="btn btn-outline-primary"
                                               data-bs-toggle="tooltip" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if (in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
                                                <a href="<?= BASE_URL; ?>/task/delete/<?= $task['id']; ?>" 
                                                   class="btn btn-outline-danger"
                                                   data-bs-toggle="tooltip" title="Delete"
                                                   onclick="return confirm('Delete this task?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check2-square display-1 text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No tasks found</h5>
                    <p class="text-muted mb-4">Stay organized by creating your first task</p>
                    <a href="<?= BASE_URL; ?>/task/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Your First Task
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>