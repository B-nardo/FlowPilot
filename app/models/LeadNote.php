<?php

class LeadNote
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create($leadId, $companyId, $userId, $note)
    {
        $stmt = $this->db->prepare("
            INSERT INTO lead_notes 
            (lead_id, company_id, user_id, note)
            VALUES
            (:lead_id, :company_id, :user_id, :note)
        ");

        return $stmt->execute([
            'lead_id'    => $leadId,
            'company_id' => $companyId,
            'user_id'    => $userId,
            'note'       => $note
        ]);
    }

    public function getByLead($leadId, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT ln.*, u.name as user_name
            FROM lead_notes ln
            JOIN users u ON ln.user_id = u.id
            WHERE ln.lead_id = :lead_id
            AND ln.company_id = :company_id
            ORDER BY ln.created_at DESC
        ");

        $stmt->execute([
            'lead_id'    => $leadId,
            'company_id' => $companyId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM lead_notes
            WHERE id = :id
            AND company_id = :company_id
        ");

        $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $companyId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM lead_notes
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);
    }
}