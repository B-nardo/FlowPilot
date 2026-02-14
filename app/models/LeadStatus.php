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
        return $stmt->fetchAll();
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

        return $stmt->fetch();
    }
}
