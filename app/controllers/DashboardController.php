<?php

class DashboardController extends Controller
{
    private $leadModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->leadModel = $this->model('Lead');
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

        $statusCounts = $this->leadModel->countByStatus($companyId, $filterUserId);
        $recentLeads  = $this->leadModel->getRecentLeads($companyId, $filterUserId);
        $pipelineValue = $this->leadModel->getPipelineValue($companyId, $filterUserId);

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
            'recentLeads'    => $recentLeads
        ];

        $this->view('dashboard/index', $data);
    }
}
