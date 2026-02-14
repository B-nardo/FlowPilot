<?php

class LeadController extends Controller
{
    private $leadModel;
    private $statusModel;
    private $logModel;

    public function __construct()
    {
        $this->requireLogin();

        $this->leadModel   = $this->model('Lead');
        $this->statusModel = $this->model('LeadStatus');
        $this->logModel    = $this->model('ActivityLog');
    }

    public function index()
    {
        $leads = $this->leadModel->getAll($this->companyId());

        $grouped = [];
        foreach ($leads as $lead) {
            $grouped[$lead['status_name']][] = $lead;
        }

        $this->view('lead/index', [
            'groupedLeads' => $grouped
        ]);
    }

public function create()
{
    $this->requireRole(['admin','manager','staff']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!$this->validateCsrf()) {
            die("Invalid CSRF");
        }

        $statusId = (int) $_POST['status_id'];

        $status = $this->statusModel
            ->findById($statusId, $this->companyId());

        if (!$status) {
            die("Invalid status selection");
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            die("Invalid email format");
        }

        $data = [
            'company_name'     => trim($_POST['company_name']),
            'contact_name'     => trim($_POST['contact_name']),
            'email'            => $email,
            'phone'            => trim($_POST['phone']),
            'status_id'        => $statusId,
            'assigned_user_id' => $this->userId(),
            'estimated_value'  => floatval($_POST['estimated_value'] ?? 0)
        ];

        $leadId = $this->leadModel
            ->create($data, $this->companyId(), $this->userId());

        $this->logModel->log(
            $this->companyId(),
            'lead',
            $leadId,
            'created',
            $this->userId()
        );

        $this->regenerateCsrf();
        $this->redirect('lead');
    }

    // ✅ ADD THIS: Get statuses and pass to view
    $statuses = $this->statusModel->getAll($this->companyId());
    
    $this->view('lead/create', [
        'statuses' => $statuses
    ]);
}

    public function edit($id)
    {
        $this->requireRole(['admin', 'manager', 'staff']);

        $lead = $this->leadModel->getById($id, $this->companyId());

        if (!$lead) {
            die("Lead not found");
        }

        // Check if staff can only edit their own leads
        if ($_SESSION['user_role'] === 'staff' && $lead['assigned_user_id'] != $this->userId()) {
            die("Access denied");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCsrf()) {
                die("Invalid CSRF");
            }

            $statusId = (int) $_POST['status_id'];

            $status = $this->statusModel->findById($statusId, $this->companyId());

            if (!$status) {
                die("Invalid status selection");
            }

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if (!$email) {
                die("Invalid email format");
            }

            $data = [
                'company_name'     => trim($_POST['company_name']),
                'contact_name'     => trim($_POST['contact_name']),
                'email'            => $email,
                'phone'            => trim($_POST['phone']),
                'status_id'        => $statusId,
                'estimated_value'  => floatval($_POST['estimated_value'] ?? 0)
            ];

            $this->leadModel->update($id, $data, $this->companyId());

            $this->logModel->log(
                $this->companyId(),
                'lead',
                $id,
                'updated',
                $this->userId()
            );

            $this->regenerateCsrf();
            $this->redirect('lead');
        }

        $statuses = $this->statusModel->getAll($this->companyId());

        $this->view('lead/edit', [
            'lead' => $lead,
            'statuses' => $statuses
        ]);
    }

    public function delete($id)
    {
        $this->requireRole(['admin', 'manager']);

        $lead = $this->leadModel
            ->getById($id, $this->companyId());

        if (!$lead) {
            die("Lead not found");
        }

        $this->leadModel
            ->delete($id, $this->companyId());

        $this->logModel->log(
            $this->companyId(),
            'lead',
            $id,
            'deleted',
            $this->userId()
        );

        $this->redirect('lead');
    }
}
