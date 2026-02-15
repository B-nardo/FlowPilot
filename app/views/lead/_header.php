    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-people-fill text-primary"></i> Leads
            </h2>
            <p class="text-muted mb-0">
                Manage your sales pipeline • 
                <span class="text-primary fw-semibold">
                    <?= $totalLeadCount ?> total leads
                </span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <!-- View Toggle -->
            <div class="btn-group shadow-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="tableViewBtn">
                    <i class="bi bi-list-ul"></i> List
                </button>
                <button type="button" class="btn btn-outline-secondary" id="kanbanViewBtn">
                    <i class="bi bi-kanban"></i> Board
                </button>
            </div>
            
            <a href="<?= BASE_URL; ?>/lead/create" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i> New Lead
            </a>
        </div>
    </div>