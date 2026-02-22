<?php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {

        $this->userModel = $this->model('User');
        
        // Generate CSRF if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public function login()
    {

        if (isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!$this->validateCsrf()) {
                $error = "Invalid CSRF token";
                $this->view('auth/login', ['error' => $error], 'auth');
                return;
            }

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                
                // ✅ Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['company_id'] = $user['company_id'];

                // Update last login
                $this->userModel->updateLastLogin($user['id']);

                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Regenerate CSRF token
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                $this->redirect('dashboard');
                return;
            }

            $error = "Invalid email or password";
            $this->view('auth/login', ['error' => $error], 'auth');
            return;
        }

        $this->view('auth/login', [], 'auth');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('auth/login');
    }
}