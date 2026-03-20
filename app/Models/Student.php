<?php

namespace App\Models;

use App\Core\Database;

class Student {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get student profile
    public function getProfile($user_id) {
        $this->db->query('SELECT u.name, u.email, sp.* FROM users u 
                          JOIN student_profiles sp ON u.id = sp.user_id 
                          WHERE u.id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    // Update profile
    public function updateProfile($data) {
        $this->db->query('UPDATE student_profiles SET 
                          surname = :surname, 
                          age = :age, 
                          class = :class, 
                          about = :about,
                          profile_photo = :profile_photo,
                          banner_image = :banner_image,
                          result_files = :result_files
                          WHERE user_id = :user_id');
        
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':class', $data['class']);
        $this->db->bind(':about', $data['about']);
        $this->db->bind(':profile_photo', $data['profile_photo']);
        $this->db->bind(':banner_image', $data['banner_image']);
        $this->db->bind(':result_files', $data['result_files']);
        $this->db->bind(':user_id', $data['user_id']);
        
        return $this->db->execute();
    }

    // Get approved messages
    public function getApprovedMessages($user_id) {
        $this->db->query('SELECT m.*, u.name as sender_name FROM messages m 
                          JOIN users u ON m.sender_id = u.id 
                          WHERE m.receiver_id = :user_id AND m.status = "approved" 
                          ORDER BY m.created_at DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Send Reply
    public function sendReply($data) {
        $this->db->query('INSERT INTO messages (sender_id, receiver_id, content, type, status) 
                          VALUES (:sender_id, :receiver_id, :content, "student_to_sponsor", "pending")');
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':receiver_id', $data['receiver_id']);
        $this->db->bind(':content', $data['content']);
        return $this->db->execute();
    }
}
