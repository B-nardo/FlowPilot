<div class="container-fluid mt-4">

    <?php require APPROOT . '/views/lead/_header.php'; ?>

    <?php require APPROOT . '/views/lead/_success_alert.php'; ?>

    <div id="tableView">
        <?php require APPROOT . '/views/lead/_table_view.php'; ?>
    </div>

    <div id="kanbanView" style="display:none;">
        <?php require APPROOT . '/views/lead/_kanban_view.php'; ?>
    </div>

</div>

<?php require APPROOT . '/views/lead/_styles.php'; ?>
<?php require APPROOT . '/views/lead/_scripts.php'; ?>
