<?php

class Task
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /* ===========================
       CREATE
    ============================ */

    public function create($data, $companyId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO tasks 
            (company_id, lead_id, assigned_user_id, title, description, due_date, status)
            VALUES
            (:company_id, :lead_id, :assigned_user_id, :title, :description, :due_date, :status)
        ");

        return $stmt->execute([
            'company_id'       => $companyId,
            'lead_id'          => $data['lead_id'],
            'assigned_user_id' => $data['assigned_user_id'],
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'due_date'         => $data['due_date'],
            'status'           => $data['status'] ?? 'pending'
        ]);
    }

    /* ===========================
       READ
    ============================ */

    public function getAll($companyId, $userId = null)
    {
        $sql = "
            SELECT t.*, 
                   l.company_name, 
                   l.contact_name,
                   u.name as assigned_to
            FROM tasks t
            JOIN leads l ON t.lead_id = l.id
            JOIN users u ON t.assigned_user_id = u.id
            WHERE t.company_id = :company_id
        ";

        if ($userId) {
            $sql .= " AND t.assigned_user_id = :user_id ";
        }

        $sql .= " ORDER BY t.due_date ASC";

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT t.*, 
                   l.company_name, 
                   l.contact_name,
                   u.name as assigned_to
            FROM tasks t
            JOIN leads l ON t.lead_id = l.id
            JOIN users u ON t.assigned_user_id = u.id
            WHERE t.id = :id
            AND t.company_id = :company_id
        ");

        $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByLead($leadId, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT t.*, u.name as assigned_to
            FROM tasks t
            JOIN users u ON t.assigned_user_id = u.id
            WHERE t.lead_id = :lead_id
            AND t.company_id = :company_id
            ORDER BY t.due_date ASC
        ");

        $stmt->execute([
            'lead_id'    => $leadId,
            'company_id' => $companyId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcoming($companyId, $userId = null, $limit = 10)
    {
        $sql = "
            SELECT t.*, 
                   l.company_name, 
                   l.contact_name,
                   u.name as assigned_to
            FROM tasks t
            JOIN leads l ON t.lead_id = l.id
            JOIN users u ON t.assigned_user_id = u.id
            WHERE t.company_id = :company_id
            AND t.status != 'completed'
        ";

        if ($userId) {
            $sql .= " AND t.assigned_user_id = :user_id ";
        }

        $sql .= "
            ORDER BY t.due_date ASC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':company_id', $companyId, PDO::PARAM_INT);
        if ($userId) {
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDueToday($companyId, $userId = null)
    {
        $sql = "
        SELECT t.*, 
               l.company_name, 
               l.contact_name,
               u.name as assigned_to
        FROM tasks t
        JOIN leads l ON t.lead_id = l.id
        JOIN users u ON t.assigned_user_id = u.id
        WHERE t.company_id = :company_id
        AND t.status != 'completed'
        AND DATE(t.due_date) = CURDATE()
    ";

        if ($userId) {
            $sql .= " AND t.assigned_user_id = :user_id ";
        }

        $sql .= " ORDER BY t.due_date ASC";

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================
       UPDATE
    ============================ */

    public function update($id, $data, $companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks SET
                title = :title,
                description = :description,
                due_date = :due_date,
                assigned_user_id = :assigned_user_id
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'               => $id,
            'company_id'       => $companyId,
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'due_date'         => $data['due_date'],
            'assigned_user_id' => $data['assigned_user_id']
        ]);
    }

    public function markComplete($id, $companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks SET
                status = 'completed',
                completed_at = NOW()
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);
    }

    public function markPending($id, $companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks SET
                status = 'pending',
                completed_at = NULL
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);
    }

    /* ===========================
       DELETE
    ============================ */

    public function delete($id, $companyId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM tasks
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);
    }

    /* ===========================
       UTILITY
    ============================ */

    public function updateOverdue($companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks SET
                status = 'overdue'
            WHERE company_id = :company_id
            AND status = 'pending'
            AND due_date < NOW()
        ");

        return $stmt->execute(['company_id' => $companyId]);
    }

    public function getTaskStats($companyId, $userId = null)
    {
        $sql = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'overdue' THEN 1 ELSE 0 END) as overdue
            FROM tasks
            WHERE company_id = :company_id
        ";

        if ($userId) {
            $sql .= " AND assigned_user_id = :user_id";
        }

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
