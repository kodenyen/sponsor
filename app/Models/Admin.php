<?php

namespace App\Models;

use App\Core\Database;

class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get counts for dashboard
    public function getCounts() {
        $counts = [];
        
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'sponsor'");
        $counts['sponsors'] = $this->db->single()->count;
        
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
        $counts['students'] = $this->db->single()->count;
        
        $this->db->query("SELECT COUNT(*) as count FROM messages WHERE status = 'pending'");
        $counts['pending_messages'] = $this->db->single()->count;
        
        return $counts;
    }

    // Get all sponsors
    public function getSponsors() {
        $this->db->query("SELECT u.*, st.token FROM users u 
                          LEFT JOIN sponsor_tokens st ON u.id = st.sponsor_id 
                          WHERE u.role = 'sponsor' 
                          ORDER BY u.created_at DESC");
        return $this->db->resultSet();
    }

    // Get all students
    public function getStudents() {
        $this->db->query("SELECT u.*, sp.surname, sp.class FROM users u 
                          LEFT JOIN student_profiles sp ON u.id = sp.user_id 
                          WHERE u.role = 'student' 
                          ORDER BY u.created_at DESC");
        return $this->db->resultSet();
    }

    // Add User
    public function addUser($data) {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Create student profile
    public function createStudentProfile($user_id, $surname) {
        $this->db->query('INSERT INTO student_profiles (user_id, surname) VALUES (:user_id, :surname)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':surname', $surname);
        return $this->db->execute();
    }

    // Generate/Update Sponsor Token
    public function updateSponsorToken($sponsor_id, $token) {
        $this->db->query('SELECT id FROM sponsor_tokens WHERE sponsor_id = :sponsor_id');
        $this->db->bind(':sponsor_id', $sponsor_id);
        
        if ($this->db->single()) {
            $this->db->query('UPDATE sponsor_tokens SET token = :token WHERE sponsor_id = :sponsor_id');
        } else {
            $this->db->query('INSERT INTO sponsor_tokens (sponsor_id, token) VALUES (:sponsor_id, :token)');
        }
        
        $this->db->bind(':sponsor_id', $sponsor_id);
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    // Get assignments for a sponsor
    public function getSponsorAssignments($sponsor_id) {
        $this->db->query('SELECT u.name, u.id FROM users u 
                          JOIN assignments a ON u.id = a.student_id 
                          WHERE a.sponsor_id = :sponsor_id');
        $this->db->bind(':sponsor_id', $sponsor_id);
        return $this->db->resultSet();
    }

    // Assign student
    public function assignStudent($sponsor_id, $student_id) {
        $this->db->query('INSERT INTO assignments (sponsor_id, student_id) VALUES (:sponsor_id, :student_id)');
        $this->db->bind(':sponsor_id', $sponsor_id);
        $this->db->bind(':student_id', $student_id);
        return $this->db->execute();
    }

    // Remove assignment
    public function removeAssignment($sponsor_id, $student_id) {
        $this->db->query('DELETE FROM assignments WHERE sponsor_id = :sponsor_id AND student_id = :student_id');
        $this->db->bind(':sponsor_id', $sponsor_id);
        $this->db->bind(':student_id', $student_id);
        return $this->db->execute();
    }

    // Message Moderation
    public function getPendingMessages() {
        $this->db->query('SELECT m.*, u1.name as sender_name, u2.name as receiver_name FROM messages m 
                          JOIN users u1 ON m.sender_id = u1.id 
                          JOIN users u2 ON m.receiver_id = u2.id 
                          WHERE m.status = "pending" 
                          ORDER BY m.created_at DESC');
        return $this->db->resultSet();
    }

    public function updateMessageStatus($id, $status) {
        $this->db->query('UPDATE messages SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Forms
    public function getForms() {
        $this->db->query('SELECT * FROM forms ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function addForm($data) {
        $this->db->query('INSERT INTO forms (title, description, target_role, fields) VALUES (:title, :description, :target_role, :fields)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':target_role', $data['target_role']);
        $this->db->bind(':fields', json_encode($data['fields']));
        return $this->db->execute();
    }
}
