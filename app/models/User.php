<?php

class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE email = :email 
            AND status = 'active'
            LIMIT 1
        ");

        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users 
            (company_id, name, email, password_hash, role, status)
            VALUES
            (:company_id, :name, :email, :password_hash, :role, :status)
        ");

        return $stmt->execute([
            'company_id'    => $data['company_id'],
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password_hash' => $data['password_hash'],
            'role'          => $data['role'] ?? 'staff',
            'status'        => $data['status'] ?? 'active'
        ]);
    }

    public function getAll($companyId)
    {
        $stmt = $this->db->prepare("
            SELECT id, name, email, role, status, last_login, created_at
            FROM users
            WHERE company_id = :company_id
            ORDER BY created_at DESC
        ");

        $stmt->execute(['company_id' => $companyId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $companyId)
    {
        $stmt = $this->db->prepare("
            SELECT id, name, email, role, status, last_login, created_at
            FROM users
            WHERE id = :id
            AND company_id = :company_id
        ");

        $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data, $companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET
                name = :name,
                email = :email,
                role = :role,
                status = :status
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId,
            'name'       => $data['name'],
            'email'      => $data['email'],
            'role'       => $data['role'],
            'status'     => $data['status']
        ]);
    }

    public function updatePassword($id, $newPasswordHash, $companyId)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET
                password_hash = :password_hash
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'            => $id,
            'company_id'    => $companyId,
            'password_hash' => $newPasswordHash
        ]);
    }

    public function updateLastLogin($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE users SET
                last_login = NOW()
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $userId]);
    }

    public function delete($id, $companyId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM users
            WHERE id = :id
            AND company_id = :company_id
        ");

        return $stmt->execute([
            'id'         => $id,
            'company_id' => $companyId
        ]);
    }
}