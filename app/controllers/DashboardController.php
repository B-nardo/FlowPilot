<?php

class DashboardController extends Controller
{
    private $leadModel;
    private $taskModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->leadModel = $this->model('Lead');
        $this->taskModel = $this->model('Task');
    }

    public function index()
    {
        $companyId = $_SESSION['company_id'];
        $userId    = $_SESSION['user_id'];
        $role      = $_SESSION['user_role'];

        // Role-aware filtering
        $filterUserId = null;
        if ($role === 'staff') {
            $filterUserId = $userId;
        }

        $this->taskModel->updateOverdue($companyId);

        $statusCounts = $this->leadModel->countByStatus($companyId, $filterUserId);
        $recentLeads  = $this->leadModel->getRecentLeads($companyId, $filterUserId);
        $pipelineValue = $this->leadModel->getPipelineValue($companyId, $filterUserId);
        $upcomingTasks = $this->taskModel->getUpcoming($companyId, $filterUserId, 5);
        $leadsThisMonth = $this->leadModel->countThisMonth($companyId, $filterUserId);
        $tasksDueToday = $this->taskModel->getDueToday($companyId, $filterUserId);
        $taskStats     = $this->taskModel->getTaskStats($companyId, $filterUserId);

        // KPI Calculations
        $totalLeads = array_sum($statusCounts);

        $closedWonCount = $this->leadModel->countClosedWon($companyId, $filterUserId);

        $conversionRate = $totalLeads > 0
            ? round(($closedWonCount / $totalLeads) * 100, 1)
            : 0;

        $data = [
            'totalLeads'     => $totalLeads,
            'closedWon'      => $closedWonCount,
            'conversionRate' => $conversionRate,
            'pipelineValue'  => $pipelineValue,
            'statusCounts'   => $statusCounts,
            'recentLeads'    => $recentLeads,
            'upcomingTasks'  => $upcomingTasks,
            'tasksDueToday'  => $tasksDueToday,
            'taskStats'      => $taskStats,
            'leadsThisMonth' => $leadsThisMonth,
        ];

        $data['statusColors'] = [
            'New' => 'primary',
            'Contacted' => 'info',
            'Qualified' => 'warning',
            'Proposal' => 'secondary',
            'Negotiation' => 'warning',
            'Won' => 'success',
            'Lost' => 'danger'
        ];




        $this->view('dashboard/index', $data);
    }
}
