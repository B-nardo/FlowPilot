<?php

class TaskController extends Controller
{
    private $taskModel;
    private $leadModel;
    private $userModel;
    private $logModel;

    public function __construct()
    {
        $this->requireLogin();

        $this->taskModel = $this->model('Task');
        $this->leadModel = $this->model('Lead');
        $this->userModel = $this->model('User');
        $this->logModel  = $this->model('ActivityLog');
    }

    /* ===========================
       LIST ALL TASKS
    ============================ */

    public function index()
    {
        // Update overdue tasks
        $this->taskModel->updateOverdue($this->companyId());

        // Filter by user for staff role
        $filterUserId = null;
        if ($_SESSION['user_role'] === 'staff') {
            $filterUserId = $this->userId();
        }

        $tasks = $this->taskModel->getAll($this->companyId(), $filterUserId);
        $stats = $this->taskModel->getTaskStats($this->companyId(), $filterUserId);

        $this->view('task/index', [
            'tasks' => $tasks,
            'stats' => $stats
        ]);
    }

    /* ===========================
       CREATE TASK
    ============================ */

    public function create()
    {
        $this->requireRole(['super_admin', 'admin', 'manager', 'staff']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCsrf()) {
                die("Invalid CSRF");
            }



            $leadId = (int) $_POST['lead_id'];

            // Verify lead exists and user has access
            $lead = $this->leadModel->getById($leadId, $this->companyId());

            if (!$lead) {
                die("Lead not found");
            }

            // Get assigned user (default to current user)
            $assignedUserId = (int) ($_POST['assigned_user_id'] ?? $this->userId());

            $data = [
                'lead_id'          => $leadId,
                'assigned_user_id' => $assignedUserId,
                'title'            => trim($_POST['title']),
                'description'      => trim($_POST['description'] ?? ''),
                'due_date'         => $_POST['due_date'],
                'status'           => 'pending'
            ];

            $this->taskModel->create($data, $this->companyId());

            $this->logModel->log(
                $this->companyId(),
                'task',
                $leadId,
                'created_task',
                $this->userId()
            );

            $_SESSION['success'] = "Task created successfully";
            $this->redirect('task');
        }

        $filterUserId = null;
        if ($_SESSION['user_role'] === 'staff') {
            $filterUserId = $this->userId();
        }

        // Get all leads for dropdown
        $leads = $this->leadModel->getAll($this->companyId(), $filterUserId);

        // Get all users for assignment dropdown (admins/managers only)
        $users = [];
        if (in_array($_SESSION['user_role'], ['admin', 'manager', 'super_admin'])) {
            $users = $this->userModel->getAll($this->companyId());
        }

        $this->view('task/create', [
            'leads' => $leads,
            'users' => $users
        ]);
    }

    /* ===========================
       EDIT TASK
    ============================ */

    public function edit($id)
    {
        $task = $this->taskModel->getById($id, $this->companyId());

        if (!$task) {
            die("Task not found");
        }

        // Staff can only edit their own tasks
        if ($_SESSION['user_role'] === 'staff' && $task['assigned_user_id'] != $this->userId()) {
            die("Access denied");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCsrf()) {
                die("Invalid CSRF");
            }

            $data = [
                'title'            => trim($_POST['title']),
                'description'      => trim($_POST['description'] ?? ''),
                'due_date'         => $_POST['due_date'],
                'assigned_user_id' => (int) ($_POST['assigned_user_id'] ?? $task['assigned_user_id'])
            ];

            $this->taskModel->update($id, $data, $this->companyId());

            $this->logModel->log(
                $this->companyId(),
                'task',
                $id,
                'updated_task',
                $this->userId()
            );

            $_SESSION['success'] = "Task updated successfully";
            $this->redirect('task');
        }

        // Get all users for assignment dropdown (admins/managers only)
        $users = [];
        if (in_array($_SESSION['user_role'], ['admin', 'manager', 'super_admin'])) {
            $users = $this->userModel->getAll($this->companyId());
        }

        $this->view('task/edit', [
            'task'  => $task,
            'users' => $users
        ]);
    }

    /* ===========================
       TOGGLE COMPLETE
    ============================ */

    public function toggleComplete($id)
    {
        $task = $this->taskModel->getById($id, $this->companyId());

        if (!$task) {
            die("Task not found");
        }

        // Staff can only toggle their own tasks
        if ($_SESSION['user_role'] === 'staff' && $task['assigned_user_id'] != $this->userId()) {
            die("Access denied");
        }

        if ($task['status'] === 'completed') {
            $this->taskModel->markPending($id, $this->companyId());
            $action = 'marked_pending';
        } else {
            $this->taskModel->markComplete($id, $this->companyId());
            $action = 'marked_complete';
        }

        $this->logModel->log(
            $this->companyId(),
            'task',
            $id,
            $action,
            $this->userId()
        );

        $_SESSION['success'] = "Task status updated";
        $this->redirect('task');
    }

    /* ===========================
       DELETE TASK
    ============================ */

    public function delete($id)
    {
        $this->requireRole(['admin', 'manager']);

        $task = $this->taskModel->getById($id, $this->companyId());

        if (!$task) {
            die("Task not found");
        }

        $this->taskModel->delete($id, $this->companyId());

        $this->logModel->log(
            $this->companyId(),
            'task',
            $id,
            'deleted_task',
            $this->userId()
        );

        $_SESSION['success'] = "Task deleted successfully";
        $this->redirect('task');
    }
}
