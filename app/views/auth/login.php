<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Logo/Brand -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle p-3 mb-3">
                        <i class="bi bi-box-seam-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2">Welcome Back</h2>
                    <p class="text-muted">Sign in to your FlowPilot account</p>
                </div>

                <!-- Login Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?= htmlspecialchars($error) ?></div>
                            </div>
                        <?php endif; ?>

                        <form method="POST">

                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control border-start-0 ps-0"
                                           placeholder="you@example.com"
                                           required
                                           autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control border-start-0 ps-0"
                                           placeholder="Enter your password"
                                           required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Sign In
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">
                        Don't have an account? 
                        <a href="<?= BASE_URL ?>/auth/register" class="text-decoration-none">
                            Sign up
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card {
        border-radius: 1rem;
    }

    .btn-primary {
        background: #6366f1;
        border-color: #6366f1;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .input-group-text {
        border-right: none;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
</style>