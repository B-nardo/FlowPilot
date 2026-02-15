    <!-- KANBAN VIEW (Hidden by default) -->
        <div class="row g-4">
            <?php foreach ($groupedLeads as $statusName => $leads): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-gradient-primary text-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">
                                    <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                                    <?= htmlspecialchars($statusName); ?>
                                </h6>
                                <span class="badge bg-white text-primary fw-bold">
                                    <?= count($leads); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-2 kanban-column">
                            <?php if (!empty($leads)): ?>
                                <?php foreach ($leads as $lead): ?>
                                    <div class="card mb-2 border-0 shadow-sm hover-lift">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0">
                                                    <span class="text-primary fw-bold small">
                                                        <?= strtoupper(substr($lead['company_name'], 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 min-width-0">
                                                    <h6 class="mb-0 fw-semibold text-truncate">
                                                        <?= htmlspecialchars($lead['company_name']); ?>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($lead['contact_name']); ?>
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted d-block text-truncate">
                                                    <i class="bi bi-envelope"></i>
                                                    <?= htmlspecialchars($lead['email']); ?>
                                                </small>
                                                <?php if ($lead['source']): ?>
                                                    <small class="badge bg-light text-dark border mt-1">
                                                        <?= htmlspecialchars($lead['source']); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-bold text-success">
                                                    $<?= number_format($lead['estimated_value'], 0); ?>
                                                </span>
                                                <small class="text-muted">
                                                    <?= date('M d', strtotime($lead['created_at'])); ?>
                                                </small>
                                            </div>
                                            
                                            <div class="d-grid gap-1">
                                                <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox text-muted fs-3"></i>
                                    <p class="text-muted small mb-0 mt-2">No leads</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
