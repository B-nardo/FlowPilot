<?php

class ActivityLog
{

    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }
    public function log($companyId, $entityType, $entityId, $action, $userId, $metadata = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs
            (company_id, entity_type, entity_id, action, performed_by, metadata)
            VALUES
            (:company_id, :entity_type, :entity_id, :action, :performed_by, :metadata)
        ");

        $stmt->execute([
            'company_id'  => $companyId,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'action'      => $action,
            'performed_by'=> $userId,
            'metadata'    => $metadata ? json_encode($metadata) : null
        ]);
    }
}
