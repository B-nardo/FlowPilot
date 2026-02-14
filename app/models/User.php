<?php

class User {

    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, c.subscription_status 
            FROM users u
            JOIN companies c ON u.company_id = c.id
            WHERE u.email = :email
            LIMIT 1
        ");

        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        

        if (!$user) {
            
            return false;
            
        }

        // Account inactive
        if ($user['status'] !== 'active') {
            return false;
        }

        // Company suspended
        if ($user['subscription_status'] === 'suspended') {
            return false;
        }

        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }
}
