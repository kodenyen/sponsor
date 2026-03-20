<?php

namespace App\Controllers;

use App\Core\Controller;

class Sponsors extends Controller {
    public function __construct() {
        $this->sponsorModel = $this->model('Sponsor');
        $this->userModel = $this->model('User');
        $this->adminModel = $this->model('Admin'); // For forms
    }

    public function access() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $user = $this->userModel->getUserByToken($token);
            
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_role'] = $user->role;
                redirect('sponsors/dashboard');
            } else {
                flash('login_err', 'Invalid or expired access link', 'alert alert-danger');
                redirect('users/login');
            }
        } else {
            redirect('users/login');
        }
    }

    public function dashboard() {
        if (!isLoggedIn() || $_SESSION['user_role'] != 'sponsor') {
            redirect('users/login');
        }

        $students = $this->sponsorModel->getAssignedStudents($_SESSION['user_id']);
        $forms = $this->adminModel->getForms();
        
        $data = [
            'students' => $students,
            'forms' => $forms
        ];
        $this->view('sponsors/dashboard', $data);
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $_POST['student_id'],
                'content' => trim($_POST['content'])
            ];

            if ($this->sponsorModel->sendMessage($data)) {
                flash('sponsor_message', 'Message submitted and awaiting admin approval.');
                redirect('sponsors/dashboard');
            }
        }
    }

    public function submitForm() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Convert dynamic fields to content
            $content = "Submitted via Form ID: " . $_POST['form_id'] . "\n\n";
            
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'field_') === 0) {
                    $content .= "• " . ucwords(str_replace('_', ' ', $key)) . ": " . $value . "\n";
                }
            }

            // Handle file uploads in form if any
            if (!empty($_FILES)) {
                foreach ($_FILES as $key => $file) {
                    if ($file['name']) {
                        $path = $this->uploadFile($file, 'form_uploads');
                        $content .= "• Attached File: " . URLROOT . "/uploads/" . $path . "\n";
                    }
                }
            }

            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $_POST['student_id'],
                'content' => $content
            ];

            if ($this->sponsorModel->sendMessage($data)) {
                flash('sponsor_message', 'Form submitted and awaiting admin approval.');
                redirect('sponsors/dashboard');
            }
        }
    }

    private function uploadFile($file, $folder) {
        $targetDir = APPROOT . '/../public/uploads/' . $folder . '/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $filename = time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetDir . $filename)) {
            return $folder . '/' . $filename;
        }
        return false;
    }
}
