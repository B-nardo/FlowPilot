<?php

class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {

        if ($this->isLoggedIn()) {
            
            $this->redirect('dashboard');
        }

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // CSRF validation
            if (!isset($_POST['csrf_token']) || 
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Invalid CSRF token');
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = trim($_POST['password']);

            if (!$email || empty($password)) {
                $data['error'] = 'Valid email and password required.';
                return $this->view('auth/login', $data, 'auth');
            }

            $user = $this->userModel->login($email, $password);

            if ($user) {

                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['company_id'] = $user['company_id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];

                header("Location: " . BASE_URL . "/dashboard");
                exit;
            }

            $data['error'] = "Invalid credentials or account inactive.";
        }

        // Generate CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->view('auth/login', $data, 'auth');
    }

    public function logout() {

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }

    public function index() {
        $this->login();
    }
}
