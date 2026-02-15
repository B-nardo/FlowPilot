    <!-- KPI CARDS - Row 1 -->
    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Total Leads</p>
                            <h3 class="mb-0 fw-bold"><?= $totalLeads ?></h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3"> <i class="bi bi-people-fill text-primary fs-4"></i> </div>
                    </div>
                    <div class="mt-3"> <a href="<?= BASE_URL; ?>/lead" class="text-decoration-none small"> View all leads <i class="bi bi-arrow-right"></i> </a> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">This Month</p>
                            <h3 class="mb-0 fw-bold"><?= $leadsThisMonth ?></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-3"> <i class="bi bi-calendar-month text-info fs-4"></i> </div>
                    </div>
                    <div class="mt-3"> <small class="text-muted"> <?= date('F Y') ?> </small> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Closed Won</p>
                            <h3 class="mb-0 fw-bold text-success"><?= $closedWon ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3"> <i class="bi bi-trophy-fill text-success fs-4"></i> </div>
                    </div>
                    <div class="mt-3"> <small class="text-success fw-semibold"> <?= $conversionRate ?>% conversion rate </small> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase">Pipeline Value</p>
                            <h3 class="mb-0 fw-bold text-warning">$<?= number_format($pipelineValue, 0) ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3"> <i class="bi bi-cash-stack text-warning fs-4"></i> </div>
                    </div>
                    <div class="mt-3"> <small class="text-muted"> Avg: $<?= $totalLeads > 0 ? number_format($pipelineValue / $totalLeads, 0) : 0 ?> per lead </small> </div>
                </div>
            </div>
        </div>
    </div> 