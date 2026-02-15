<?php

class UserController extends Controller
{
    private $logModel;

    private $userModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->requireRole(['super_admin', 'admin']);
        $this->logModel    = $this->model('ActivityLog');
        $this->userModel   = $this->model('User');
    }

    public function index()
    {
        $users = $this->userModel->getAll($this->companyId());

        // Group users by role
        $grouped = [];
        foreach ($users as $user) {
            $grouped[$user['role']][] = $user;
        }

        // Count total users
        $totalUserCount = count($users);

        $this->view('user/index', [
            'groupedUsers' => $grouped,
            'totalUserCount' => $totalUserCount
        ]);
    }

    public function create()
    {
        $this->requireRole(['super_admin', 'admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCsrf()) {
                die("Invalid CSRF");
            }

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if (!$email) {
                $_SESSION['error'] = "Invalid email format";
                $this->redirect('user/create');
                return;
            }

            // Check if email already exists
            if ($this->userModel->emailExists($email, $this->companyId())) {
                $_SESSION['error'] = "Email already exists";
                $this->redirect('user/create');
                return;
            }

            $data = [
                'name'  => trim($_POST['name']),
                'email'     => $email,
                'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'full_name' => trim($_POST['full_name']),
                'role'      => $_POST['role']
            ];

            $userId = $this->userModel->create($data, $this->companyId());

            $this->logModel->log(
                $this->companyId(),
                'user',
                $userId,
                'created',
                $this->userId()
            );

            $_SESSION['success'] = "User created successfully";
            $this->regenerateCsrf();
            $this->redirect('user');
        }

        $this->view('user/create');
    }

    public function edit($id)
    {
        $this->requireRole(['super_admin', 'admin']);

        $user = $this->userModel->getById($id, $this->companyId());

        if (!$user) {
            die("User not found");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCsrf()) {
                die("Invalid CSRF");
            }

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if (!$email) {
                $_SESSION['error'] = "Invalid email format";
                $this->redirect('user/edit/' . $id);
                return;
            }

            $data = [
                'username'  => trim($_POST['username']),
                'email'     => $email,
                'full_name' => trim($_POST['full_name']),
                'role'      => $_POST['role']
            ];

            $data['roleIcons'] = [
                'super_admin' => 'bi-shield-fill-check',
                'admin' => 'bi-star-fill',
                'manager' => 'bi-person-badge',
                'staff' => 'bi-person'
            ];

            $data['roleBadges'] = [
                'super_admin' => 'danger',
                'admin' => 'warning',
                'manager' => 'info',
                'staff' => 'secondary'
            ];

            $data['roleLabels'] = [
                'super_admin' => 'Super Admin',
                'admin' => 'Admin',
                'manager' => 'Manager',
                'staff' => 'Staff'
            ];

            // Only update password if provided
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $this->userModel->update($id, $data, $this->companyId());

            $this->logModel->log(
                $this->companyId(),
                'user',
                $id,
                'updated',
                $this->userId()
            );

            $_SESSION['success'] = "User updated successfully";
            $this->regenerateCsrf();
            $this->redirect('user');
        }

        $this->view('user/edit', [
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $this->requireRole(['super_admin', 'admin']);

        $user = $this->userModel->getById($id, $this->companyId());

        if (!$user) {
            die("User not found");
        }

        // Prevent deleting yourself
        if ($id == $this->userId()) {
            $_SESSION['error'] = "You cannot delete your own account";
            $this->redirect('user');
            return;
        }

        $this->userModel->delete($id, $this->companyId());

        $this->logModel->log(
            $this->companyId(),
            'user',
            $id,
            'deleted',
            $this->userId()
        );

        $_SESSION['success'] = "User deleted successfully";
        $this->redirect('user');
    }
}
