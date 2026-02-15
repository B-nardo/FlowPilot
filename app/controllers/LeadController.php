<?php

class LeadController extends Controller
{
    private $leadModel;
    private $statusModel;
    private $logModel;
    private $noteModel;
    private $taskModel;

    public function __construct()
    {
        $this->requireLogin();

        $this->leadModel   = $this->model('Lead');
        $this->statusModel = $this->model('LeadStatus');
        $this->logModel    = $this->model('ActivityLog');
        $this->noteModel   = $this->model('LeadNote');
        $this->taskModel   = $this->model('Task');
    }

    public function index()
    {

            $filterUserId = null;
        if ($_SESSION['user_role'] === 'staff') {
            $filterUserId = $this->userId();
        }
        $leads = $this->leadModel->getAll($this->companyId(), $filterUserId);


        $grouped = [];
        foreach ($leads as $lead) {
            $grouped[$lead['status_name']][] = $lead;
        }
        $totalLeadCount = count($leads);



        $this->view('lead/index', [
            'groupedLeads' => $grouped,
            'totalLeadCount' => $totalLeadCount

        ]);
    }



        public function show($id)
    {
        $lead = $this->leadModel->getById($id, $this->companyId());

        if (!$lead) {
            die("Lead not found");
        }

        // Staff can only view their own leads
        if ($_SESSION['user_role'] === 'staff' && $lead['assigned_user_id'] != $this->userId()) {
            die("Access denied");
        }

        $notes = $this->noteModel->getByLead($id, $this->companyId());
        $tasks = $this->taskModel->getByLead($id, $this->companyId());



        // Note: Using parent's view() method here
        $this->view('lead/show', [
            'lead'  => $lead,
            'notes' => $notes,
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        $this->requireRole(['super_admin','admin', 'manager', 'staff']);

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
                'estimated_value'  => floatval($_POST['estimated_value'] ?? 0),
                'source'           => trim($_POST['source'] ?? '')
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

        $statuses = $this->statusModel->getAll($this->companyId());

        $this->view('lead/create', [
            'statuses' => $statuses
        ]);
    }

public function edit($id)
{
    $this->requireRole(['super_admin','admin', 'manager', 'staff']);

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
            'estimated_value'  => floatval($_POST['estimated_value'] ?? 0),
            'source'           => !empty($_POST['source']) ? trim($_POST['source']) : null
        ];

        // Check if status requires a loss reason
        $requiresReason = $this->statusModel->requiresReason($statusId, $this->companyId());
        
        if ($requiresReason) {
            $lossReason = trim($_POST['loss_reason'] ?? '');
            
            if (empty($lossReason)) {
                // Store error in session and redirect back
                $_SESSION['error'] = 'Loss reason is required for this status';
                $this->redirect('lead/edit/' . $id);
                return;
            }
            
            $data['loss_reason'] = $lossReason;
        } else {
            // Clear loss_reason if moving to a non-loss status
            $data['loss_reason'] = null;
        }

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



    public function addNote($leadId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('lead/show/' . $leadId);
        }

        if (!$this->validateCsrf()) {
            die("Invalid CSRF");
        }

        $lead = $this->leadModel->getById($leadId, $this->companyId());

        if (!$lead) {
            die("Lead not found");
        }

        $note = trim($_POST['note']);

        if (empty($note)) {
            die("Note cannot be empty");
        }

        $this->noteModel->create(
            $leadId,
            $this->companyId(),
            $this->userId(),
            $note
        );

        $this->logModel->log(
            $this->companyId(),
            'lead_note',
            $leadId,
            'added_note',
            $this->userId()
        );

        $this->regenerateCsrf();
        $this->redirect('lead/show/' . $leadId);
    }

    public function addTask($leadId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('lead/show/' . $leadId);
        }

        if (!$this->validateCsrf()) {
            die("Invalid CSRF");
        }

        $lead = $this->leadModel->getById($leadId, $this->companyId());

        if (!$lead) {
            die("Lead not found");
        }

        $data = [
            'lead_id'          => $leadId,
            'assigned_user_id' => $this->userId(),
            'title'            => trim($_POST['title']),
            'description'      => trim($_POST['description'] ?? ''),
            'due_date'         => $_POST['due_date'],
            'status'           => 'pending'
        ];

        $this->taskModel->create($data, $this->companyId());

        $this->regenerateCsrf();
        $this->redirect('lead/show/' . $leadId);
    }

    public function deleteNote($noteId)
    {
        $this->requireRole(['admin', 'manager']);


        $note = $this->noteModel->getById($noteId, $this->companyId());

        if (!$note) {
            die("Note not found");
        }

        $leadId = $note['lead_id'];


        $this->noteModel->delete($noteId, $this->companyId());


        $this->logModel->log(
            $this->companyId(),
            'lead_note',
            $leadId,
            'deleted_note',
            $this->userId()
        );

        $_SESSION['success'] = "Note deleted successfully";
        $this->redirect('lead/show/' . $leadId);
    }
}
