<?php

class Lead
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

    public function create($data, $companyId, $userId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO leads 
            (company_id, assigned_user_id, created_by,
             company_name, contact_name, email, phone,
             status_id, estimated_value)
            VALUES
            (:company_id, :assigned_user_id, :created_by,
             :company_name, :contact_name, :email, :phone,
             :status_id, :estimated_value)
        ");

        $stmt->execute([
            'company_id'       => $companyId,
            'assigned_user_id' => $data['assigned_user_id'],
            'created_by'       => $userId,
            'company_name'     => $data['company_name'],
            'contact_name'     => $data['contact_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'status_id'        => $data['status_id'],
              'source'           => $data['source'] ?? null,
            'estimated_value'  => $data['estimated_value'] ?? 0
            
        ]);

        return $this->db->lastInsertId();
    }

    /* ===========================
       READ ALL
    ============================ */

    public function getAll($companyId)
    {
        $stmt = $this->db->prepare("
            SELECT l.*, ls.name AS status_name
            FROM leads l
            JOIN lead_statuses ls ON l.status_id = ls.id
            WHERE l.company_id = :company_id
            ORDER BY l.created_at DESC
        ");

        $stmt->execute(['company_id' => $companyId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT l.*, ls.name AS status_name
            FROM leads l
            JOIN lead_statuses ls ON l.status_id = ls.id
            WHERE l.id = :id
            AND l.company_id = :company_id
        ");

        $stmt->execute([
            'id' => $id,
            'company_id' => $companyId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data, $companyId)
{
    $stmt = $this->db->prepare("
        UPDATE leads SET
            company_name = :company_name,
            contact_name = :contact_name,
            email = :email,
            phone = :phone,
            status_id = :status_id,
            estimated_value = :estimated_value
        WHERE id = :id
        AND company_id = :company_id
    ");

    return $stmt->execute([
        'id'               => $id,
        'company_id'       => $companyId,
        'company_name'     => $data['company_name'],
        'contact_name'     => $data['contact_name'],
        'email'            => $data['email'],
        'phone'            => $data['phone'],
        'status_id'        => $data['status_id'],
        'estimated_value'  => $data['estimated_value']
    ]);
}

    /* ===========================
       DELETE
    ============================ */

    public function delete($id, $companyId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM leads
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id' => $id,
            'company_id' => $companyId
        ]);
    }

    /* ===========================
       DASHBOARD METHODS
    ============================ */

    public function countByStatus($companyId, $userId = null)
    {
        $sql = "
            SELECT ls.name, COUNT(l.id) as total
            FROM lead_statuses ls
            LEFT JOIN leads l 
                ON l.status_id = ls.id 
                AND l.company_id = :company_id
        ";

        if ($userId) {
            $sql .= " AND l.assigned_user_id = :user_id ";
        }

        $sql .= "
            WHERE ls.company_id = :company_id
            GROUP BY ls.id
            ORDER BY ls.position ASC
        ";

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function countClosedWon($companyId, $userId = null)
    {
        $sql = "
            SELECT COUNT(l.id)
            FROM leads l
            JOIN lead_statuses ls ON l.status_id = ls.id
            WHERE l.company_id = :company_id
            AND ls.is_closed = 1
        ";

        if ($userId) {
            $sql .= " AND l.assigned_user_id = :user_id ";
        }

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetchColumn() ?? 0;
    }

    public function getPipelineValue($companyId, $userId = null)
    {
        $sql = "
            SELECT SUM(estimated_value)
            FROM leads
            WHERE company_id = :company_id
        ";

        if ($userId) {
            $sql .= " AND assigned_user_id = :user_id ";
        }

        $stmt = $this->db->prepare($sql);

        $params = ['company_id' => $companyId];

        if ($userId) {
            $params['user_id'] = $userId;
        }

        $stmt->execute($params);

        return $stmt->fetchColumn() ?? 0;
    }

    public function getRecentLeads($companyId, $userId = null, $limit = 10)
{
    $sql = "
        SELECT l.*, ls.name AS status_name
        FROM leads l
        JOIN lead_statuses ls ON l.status_id = ls.id
        WHERE l.company_id = :company_id
    ";

    if ($userId) {
        $sql .= " AND l.assigned_user_id = :user_id ";
    }

    $sql .= "
        ORDER BY l.created_at DESC
        LIMIT :limit
    ";

    $stmt = $this->db->prepare($sql);
    
    $params = ['company_id' => $companyId];
    
    if ($userId) {
        $params['user_id'] = $userId;
    }
    
    $stmt->bindValue(':company_id', $companyId, PDO::PARAM_INT);
    if ($userId) {
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
