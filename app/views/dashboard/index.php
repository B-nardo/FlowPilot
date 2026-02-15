<div class="container-fluid mt-4">

    <?php require APPROOT . '/views/dashboard/_header.php'; ?>

    <?php require APPROOT . '/views/dashboard/_kpi_cards.php'; ?>

    <?php require APPROOT . '/views/dashboard/_tasks_due_alert.php'; ?>

    <?php require APPROOT . '/views/dashboard/_pipeline_overview.php'; ?>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <?php require APPROOT . '/views/dashboard/_recent_leads.php'; ?>
        </div>

        <div class="col-lg-4 mb-4">
            <?php require APPROOT . '/views/dashboard/_upcoming_tasks.php'; ?>
            <?php require APPROOT . '/views/dashboard/_quick_stats.php'; ?>
        </div>
    </div>

</div>

<?php require APPROOT . '/views/dashboard/_styles.php'; ?>
