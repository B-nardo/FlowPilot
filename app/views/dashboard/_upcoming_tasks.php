
            <!-- UPCOMING TASKS -->
            <?php if (!empty($upcomingTasks)): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-task"></i> Upcoming Tasks
                            </h5>
                            <span class="badge bg-primary rounded-pill"><?= count($upcomingTasks) ?></span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                            <?php foreach ($upcomingTasks as $task): ?>
                                <div class="list-group-item border-0 px-4 py-3 hover-bg">
                                    <div class="d-flex align-items-start justify-content-between gap-3">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold mb-1">
                                                <?= htmlspecialchars($task['title']) ?>
                                            </div>
                                            <div class="small text-muted mb-2">
                                                <i class="bi bi-building"></i>
                                                <?= htmlspecialchars($task['company_name']) ?>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="badge bg-<?= $task['status'] === 'overdue' ? 'danger' : 'warning' ?> rounded-pill">
                                                    <?= ucfirst($task['status']) ?>
                                                </span>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i>
                                                    <?= date('M d, g:i A', strtotime($task['due_date'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="<?= BASE_URL; ?>/lead/show/<?= $task['lead_id']; ?>" 
                                           class="btn btn-sm btn-outline-secondary flex-shrink-0"
                                           title="View Lead">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-2">
                        <a href="<?= BASE_URL; ?>/task" class="btn btn-sm btn-link text-decoration-none">
                            View All Tasks <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>