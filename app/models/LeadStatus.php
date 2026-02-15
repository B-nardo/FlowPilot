<?php

class LeadStatus 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll($companyId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM lead_statuses
            WHERE company_id = :company_id
            ORDER BY position ASC
        ");

        $stmt->execute(['company_id' => $companyId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findById($id, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM lead_statuses
            WHERE id = :id
            AND company_id = :company_id
        ");

        $stmt->execute([
            'id' => $id,
            'company_id' => $companyId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


public function requiresReason($statusId, $companyId)
{
    $stmt = $this->db->prepare("
        SELECT requires_reason 
        FROM lead_statuses 
        WHERE id = :id AND company_id = :company_id
    ");
    
    $stmt->execute([
        'id' => $statusId,
        'company_id' => $companyId
    ]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (bool)$result['requires_reason'] : false;
}
    

    public function getActiveStatuses() {
        $stmt = $this->db->query("SELECT * FROM lead_statuses ORDER BY position ASC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}