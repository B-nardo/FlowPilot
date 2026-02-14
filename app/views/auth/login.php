<div class="card mx-auto" style="max-width:400px;">
    <div class="card-body">
        <h4 class="mb-4 text-center">Login</h4>

        <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <input type="hidden" name="csrf_token"
                   value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Email"
                       required>
            </div>

            <div class="mb-3">
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>
    </div>
</div>
