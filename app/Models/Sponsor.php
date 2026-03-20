<?php

namespace App\Models;

use App\Core\Database;

class Sponsor {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get assigned students
    public function getAssignedStudents($sponsor_id) {
        $this->db->query('SELECT u.*, sp.surname, sp.profile_photo, sp.banner_image FROM users u 
                          JOIN assignments a ON u.id = a.student_id 
                          LEFT JOIN student_profiles sp ON u.id = sp.user_id 
                          WHERE a.sponsor_id = :sponsor_id');
        $this->db->bind(':sponsor_id', $sponsor_id);
        return $this->db->resultSet();
    }

    // Send Message
    public function sendMessage($data) {
        $this->db->query('INSERT INTO messages (sender_id, receiver_id, content, type, status) 
                          VALUES (:sender_id, :receiver_id, :content, "sponsor_to_student", "pending")');
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':receiver_id', $data['receiver_id']);
        $this->db->bind(':content', $data['content']);
        return $this->db->execute();
    }
}
