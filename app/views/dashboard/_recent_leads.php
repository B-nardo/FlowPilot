        <!-- LEFT COLUMN - RECENT LEADS -->

            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"> <i class="bi bi-clock-history"></i> Recent Leads </h5> <a href="<?= BASE_URL; ?>/lead" class="btn btn-sm btn-outline-primary"> View All <i class="bi bi-arrow-right"></i> </a>
                    </div>
                </div>
                <div class="card-body p-0"> <?php if (!empty($recentLeads)): ?> <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Company</th>
                                        <th class="border-0">Contact</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Value</th>
                                        <th class="border-0 text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody> <?php foreach ($recentLeads as $lead): ?> <tr class="hover-bg">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"> <span class="text-primary fw-bold"> <?= strtoupper(substr($lead['company_name'], 0, 1)) ?> </span> </div>
                                                    <div>
                                                        <div class="fw-semibold"> <?= htmlspecialchars($lead['company_name']) ?> </div> <small class="text-muted"> <i class="bi bi-envelope"></i> <?= htmlspecialchars($lead['email']) ?> </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-medium"><?= htmlspecialchars($lead['contact_name']) ?></div> <small class="text-muted"> <i class="bi bi-telephone"></i> <?= htmlspecialchars($lead['phone'] ?? 'No phone') ?> </small>
                                            </td>
                                            <td> <span class="badge bg-info bg-opacity-75 rounded-pill"> <?= htmlspecialchars($lead['status_name']) ?> </span> </td>
                                            <td> <span class="fw-semibold text-success"> $<?= number_format($lead['estimated_value'], 0) ?> </span> </td>
                                            <td class="text-end pe-4"> <a href="<?= BASE_URL; ?>/lead/show/<?= $lead['id']; ?>" class="btn btn-sm btn-outline-primary"> <i class="bi bi-eye"></i> View </a> </td>
                                        </tr> <?php endforeach; ?> </tbody>
                            </table>
                        </div> <?php else: ?> <div class="text-center py-5"> <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No recent leads found</p> <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary mt-2"> <i class="bi bi-plus-circle"></i> Create Your First Lead </a>
                        </div> <?php endif; ?> </div>
            </div>
