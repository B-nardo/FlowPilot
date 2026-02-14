<?php
class Controller {
    public function model($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }

public function view($view, $data = [], $layout = 'app')
{
    extract($data);

    ob_start();
    require_once "../app/views/$view.php";
    $content = ob_get_clean();

    if ($layout === 'auth') {
        require_once "../app/views/layouts/auth_layout.php";
    } else {
        require_once "../app/views/layouts/app_layout.php";
    }
}


        // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Redirect helper
    public function redirect($path) {
        header('Location: ' . BASE_URL . '/' . $path);
        exit;
    }

protected function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }
}

    
}


