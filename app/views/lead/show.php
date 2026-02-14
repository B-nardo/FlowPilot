<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= htmlspecialchars($lead['company_name']); ?></h2>
        <div>
            <a href="<?= BASE_URL; ?>/lead/edit/<?= $lead['id']; ?>" class="btn btn-warning">
                Edit Lead
            </a>
            <a href="<?= BASE_URL; ?>/lead" class="btn btn-secondary">
                Back to Leads
            </a>
        </div>
    </div>

    <!-- Lead Details Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Lead Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Contact Name:</strong> <?= htmlspecialchars($lead['contact_name']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($lead['email']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($lead['phone']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        <span class="badge bg-info">
                            <?= htmlspecialchars($lead['status_name']); ?>
                        </span>
                    </p>
                    <p><strong>Source:</strong> <?= htmlspecialchars($lead['source'] ?? 'N/A'); ?></p>
                    <p><strong>Estimated Value:</strong> $<?= number_format($lead['estimated_value'], 2); ?></p>
                    <p><strong>Created:</strong> <?= date('M d, Y g:i A', strtotime($lead['created_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Notes & Activity</h5>
        </div>
        <div class="card-body">

            <!-- Add Note Form -->
            <form method="POST" action="<?= BASE_URL; ?>/lead/addNote/<?= $lead['id']; ?>" class="mb-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <div class="mb-3">
                    <label>Add a Note</label>
                    <textarea name="note" class="form-control" rows="3" required
                        placeholder="Enter your note here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Note</button>
            </form>

            <!-- Notes List -->
            <hr>
            <h6 class="mb-3">Previous Notes</h6>

            <?php if (!empty($notes)): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <strong><?= htmlspecialchars($note['user_name']); ?></strong>
                                <small class="text-muted">
                                    <?= date('M d, Y g:i A', strtotime($note['created_at'])); ?>
                                </small>
                            </div>
                            <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($note['note'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No notes yet. Add the first note above.</p>
            <?php endif; ?>

        </div>
    </div>
</div>