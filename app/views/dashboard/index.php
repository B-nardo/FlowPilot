<!-- RECENT LEADS -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Recent Leads</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recentLeads)): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Value</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLeads as $lead): ?>
                                <tr>
                                    <td><?= htmlspecialchars($lead['company_name']) ?></td>
                                    <td><?= htmlspecialchars($lead['contact_name']) ?></td>
                                    <td><?= htmlspecialchars($lead['email']) ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= htmlspecialchars($lead['status_name']) ?>
                                        </span>
                                    </td>
                                    <td>$<?= number_format($lead['estimated_value'], 2) ?></td>
                                    <td><?= date('M d, Y', strtotime($lead['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No recent leads found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>