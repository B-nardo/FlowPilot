    <!-- TASKS DUE TODAY - Prominent Alert --> 
    <?php if (!empty($tasksDueToday)): ?> 
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" role="alert">
                    <div class="flex-shrink-0 me-3"> <i class="bi bi-exclamation-triangle-fill fs-3"></i> </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1"> <?= count($tasksDueToday) ?> Task<?= count($tasksDueToday) > 1 ? 's' : '' ?> Due Today </h5>
                        <p class="mb-2 small">You have tasks that need attention today</p>
                        <div class="d-flex flex-wrap gap-2"> <?php foreach (array_slice($tasksDueToday, 0, 3) as $task): ?> <span class="badge bg-white text-dark border"> <?= htmlspecialchars($task['title']) ?> </span> <?php endforeach; ?> <?php if (count($tasksDueToday) > 3): ?> <span class="badge bg-white text-dark border"> +<?= count($tasksDueToday) - 3 ?> more </span> <?php endif; ?> </div>
                    </div>
                    <div class="flex-shrink-0"> <a href="<?= BASE_URL; ?>/task" class="btn btn-warning"> View Tasks <i class="bi bi-arrow-right"></i> </a> </div>
                </div>
            </div>
        </div> 
        <?php endif; ?> 