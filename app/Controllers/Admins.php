<?php

namespace App\Controllers;

use App\Core\Controller;

class Admins extends Controller {
    public function __construct() {
        if (!isLoggedIn() || $_SESSION['user_role'] != 'admin') {
            redirect('users/login');
        }
        $this->adminModel = $this->model('Admin');
    }

    public function dashboard() {
        $counts = $this->adminModel->getCounts();
        $data = [
            'counts' => $counts
        ];
        $this->view('admins/dashboard', $data);
    }

    public function sponsors() {
        $sponsors = $this->adminModel->getSponsors();
        $students = $this->adminModel->getStudents();
        
        $data = [
            'sponsors' => $sponsors,
            'students' => $students
        ];
        
        $this->view('admins/sponsors', $data);
    }

    public function addSponsor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'role' => 'sponsor'
            ];

            if ($this->adminModel->addUser($data)) {
                flash('sponsor_message', 'Sponsor added successfully');
                redirect('admins/sponsors');
            }
        }
    }

    public function generateToken($id) {
        $token = bin2hex(random_bytes(16));
        if ($this->adminModel->updateSponsorToken($id, $token)) {
            flash('sponsor_message', 'Access link generated');
            redirect('admins/sponsors');
        }
    }

    public function assignStudent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sponsor_id = $_POST['sponsor_id'];
            $student_id = $_POST['student_id'];
            
            if ($this->adminModel->assignStudent($sponsor_id, $student_id)) {
                flash('sponsor_message', 'Student assigned');
                redirect('admins/sponsors');
            }
        }
    }

    public function removeAssignment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sponsor_id = $_POST['sponsor_id'];
            $student_id = $_POST['student_id'];
            
            if ($this->adminModel->removeAssignment($sponsor_id, $student_id)) {
                flash('sponsor_message', 'Assignment removed');
                redirect('admins/sponsors');
            }
        }
    }

    public function students() {
        $students = $this->adminModel->getStudents();
        $data = ['students' => $students];
        $this->view('admins/students', $data);
    }

    public function addStudent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'role' => 'student'
            ];

            $user_id = $this->adminModel->addUser($userData);
            if ($user_id) {
                $this->adminModel->createStudentProfile($user_id, trim($_POST['surname']));
                flash('student_message', 'Student added successfully');
                redirect('admins/students');
            }
        }
    }

    public function messages() {
        $messages = $this->adminModel->getPendingMessages();
        $data = ['messages' => $messages];
        $this->view('admins/messages', $data);
    }

    public function approveMessage($id) {
        if ($this->adminModel->updateMessageStatus($id, 'approved')) {
            flash('message_success', 'Message approved');
            redirect('admins/messages');
        }
    }

    public function rejectMessage($id) {
        if ($this->adminModel->updateMessageStatus($id, 'rejected')) {
            flash('message_success', 'Message rejected');
            redirect('admins/messages');
        }
    }

    public function forms() {
        $forms = $this->adminModel->getForms();
        $data = ['forms' => $forms];
        $this->view('admins/forms', $data);
    }

    public function addForm() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = [];
            foreach($_POST['field_labels'] as $i => $label) {
                $fields[] = [
                    'label' => trim($label),
                    'type' => $_POST['field_types'][$i]
                ];
            }

            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'target_role' => $_POST['target_role'],
                'fields' => $fields
            ];

            if ($this->adminModel->addForm($data)) {
                flash('form_message', 'Form created successfully');
                redirect('admins/forms');
            }
        }
    }
}
