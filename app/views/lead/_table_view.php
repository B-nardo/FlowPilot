    <!-- TABLE VIEW (Default) -->
        <div class="card border-0 shadow-sm">
            <!-- Card Header with Filters -->
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" 
                                   placeholder="Search leads by company, contact, or email...">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary" onclick="exportTableToCSV()">
                                <i class="bi bi-download"></i> Export CSV
                            </button>
                            <button class="btn btn-outline-secondary" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <?php if (!empty($groupedLeads)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle" id="leadsTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="ps-4">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Value</th>
                                    <th>Source</th>
                                    <th class="text-center pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groupedLeads as $statusName => $leads): ?>
                                    <?php foreach ($leads as $lead): ?>
                                        <tr class="hover-lift-sm">
                                            <td class="ps-4">
                                                <input type="checkbox" class="form-check-input lead-checkbox">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <span class="text-primary fw-bold">
                                                            <?= strtoupper(substr($lead['company_name'], 0, 1)) ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-dark">
                                                            <?= htmlspecialchars($lead['company_name']) ?>
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar3"></i>
                                                            <?= date('M d, Y', strtotime($lead['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-medium"><?= htmlspecialchars($lead['contact_name']) ?></div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= htmlspecialchars($lead['email']) ?>" 
                                                   class="text-decoration-none text-muted">
                                                    <i class="bi bi-envelope"></i>
                                                    <small><?= htmlspecialchars($lead['email']) ?></small>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($lead['phone']): ?>
                                                    <a href="tel:<?= htmlspecialchars($lead['phone']) ?>" 
                                                       class="text-decoration-none text-muted">
                                                        <i class="bi bi-telephone"></i>
                                                        <small><?= htmlspecialchars($lead['phone']) ?></small>
                                                    </a>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-75 rounded-pill">
                                                    <?= htmlspecialchars($statusName) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-success">
                                                    $<?= number_format($lead['estimated_value'], 0) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($lead['source']): ?>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-tag"></i>
                                                        <?= htmlspecialchars($lead['source']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>" 
                                                       class="btn btn-outline-primary" 
                                                       data-bs-toggle="tooltip" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>" 
                                                       class="btn btn-outline-warning"
                                                       data-bs-toggle="tooltip" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL; ?>/lead/delete/<?= $lead['id']; ?>" 
                                                       class="btn btn-outline-danger"
                                                       data-bs-toggle="tooltip" title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($lead['company_name']) ?>?');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-3">No leads found</h5>
                        <p class="text-muted mb-4">Start building your pipeline by creating your first lead</p>
                        <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create Your First Lead
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
