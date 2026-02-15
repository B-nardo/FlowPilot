        <!-- PIPELINE BY STATUS -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"> <i class="bi bi-funnel"></i> Pipeline Overview </h5> <a href="<?= BASE_URL; ?>/lead" class="btn btn-sm btn-outline-secondary"> Manage Pipeline </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3"> <?php
                                                foreach ($statusCounts as $status => $total): $color = 'secondary';
                                                    foreach ($statusColors as $key => $value) {
                                                        if (stripos($status, $key) !== false) {
                                                            $color = $value;
                                                            break;
                                                        }
                                                    }
                                                    $percentage = $totalLeads > 0 ? round(($total / $totalLeads) * 100) : 0; ?> <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <div class="card border-0 bg-<?= $color ?> bg-opacity-10 h-100 hover-lift">
                                        <div class="card-body text-center py-3">
                                            <div class="badge bg-<?= $color ?> mb-2 px-3 py-2 text-white"> <?= htmlspecialchars($status) ?> </div>
                                            <h2 class="mb-0 fw-bold text-<?= $color ?>"><?= $total ?></h2> <small class="text-muted"><?= $percentage ?>% of pipeline</small>
                                        </div>
                                    </div>
                                </div> <?php endforeach; ?> </div>
                    </div>
                </div>
            </div>
        </div>