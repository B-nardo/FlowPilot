<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-people text-primary"></i> User Management
            </h2>
            <p class="text-muted mb-0">Manage your team members (<?= $totalUserCount; ?> total)</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL; ?>/user/create" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Add New User
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Users Grouped by Role -->


    <?php foreach ($groupedUsers as $role => $usersInRole): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi <?= $roleIcons[$role] ?? 'bi-person' ?> text-<?= $roleBadges[$role] ?? 'secondary' ?>"></i>
                    <?= $roleLabels[$role] ?? ucfirst($role) ?>
                    <span class="badge bg-<?= $roleBadges[$role] ?? 'secondary' ?> ms-2"><?= count($usersInRole) ?></span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($usersInRole)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p class="mb-0">No users in this role.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Last Login</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usersInRole as $user): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($user['name']) ?></strong>
                                            <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                                <span class="badge bg-success ms-1">You</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <i class="bi bi-envelope"></i>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </td>
                                        <td>
                                            <?php if (isset($user['status']) && $user['status']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('M d, Y', strtotime($user['last_login'])) ?>
                                            </small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= BASE_URL ?>/user/edit/<?= $user['id'] ?>"
                                                    class="btn btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <a href="<?= BASE_URL ?>/user/delete/<?= $user['id'] ?>"
                                                        class="btn btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($groupedUsers)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">No users found</h5>
                <p class="text-muted mb-4">Get started by adding your first user</p>
                <a href="<?= BASE_URL; ?>/user/create" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Add New User
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.05);
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
</style>