<?php

namespace App\Models;

use App\Core\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // Login User
    public function login($email, $password) {
        $row = $this->findUserByEmail($email);
        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    // Get User by Token
    public function getUserByToken($token) {
        $this->db->query('SELECT u.* FROM users u 
                          JOIN sponsor_tokens st ON u.id = st.sponsor_id 
                          WHERE st.token = :token AND (st.expires_at IS NULL OR st.expires_at > CURRENT_TIMESTAMP)');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }
}
