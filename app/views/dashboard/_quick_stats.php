<!-- QUICK STATS -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0"> <i class="bi bi-graph-up"></i> Quick Stats </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <p class="text-muted mb-0 small text-uppercase">Active Leads</p>
                            <h4 class="mb-0 fw-bold"><?= $totalLeads - $closedWon ?></h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle"> <i class="bi bi-lightning-charge-fill text-warning fs-4"></i> </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <p class="text-muted mb-0 small text-uppercase">Avg. Deal Size</p>
                            <h4 class="mb-0 fw-bold"> $<?= $totalLeads > 0 ? number_format($pipelineValue / $totalLeads, 0) : 0 ?> </h4>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle"> <i class="bi bi-graph-up text-success fs-4"></i> </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <p class="text-muted mb-0 small text-uppercase">Win Rate</p>
                            <h4 class="mb-0 fw-bold text-success"><?= $conversionRate ?>%</h4>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle"> <i class="bi bi-bullseye text-info fs-4"></i> </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0 small text-uppercase">Total Tasks</p>
                            <h4 class="mb-0 fw-bold"><?= $taskStats['total'] ?? 0 ?></h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle"> <i class="bi bi-check2-square text-primary fs-4"></i> </div>
                    </div>
                </div>
            </div>