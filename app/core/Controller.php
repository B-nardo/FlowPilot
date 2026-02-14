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

        require_once "../app/views/layouts/{$layout}_layout.php";
    }

    protected function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }
    }

        public function redirect($path) {
        header('Location: ' . BASE_URL . '/' . $path);
        exit;
    }

    protected function requireRole(array $roles)
    {
        if (!isset($_SESSION['user_role']) || 
            !in_array($_SESSION['user_role'], $roles)) {

            http_response_code(403);
            die("Unauthorized access.");
        }
    }

    protected function validateCsrf()
    {
        return isset($_POST['csrf_token'], $_SESSION['csrf_token']) &&
            hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }

    protected function regenerateCsrf()
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    protected function companyId()
    {
        return $_SESSION['company_id'];
    }

    protected function userId()
    {
        return $_SESSION['user_id'];
    }
}
