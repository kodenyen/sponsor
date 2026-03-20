<?php

namespace App\Controllers;

use App\Core\Controller;

class Students extends Controller {
    public function __construct() {
        if (!isLoggedIn() || $_SESSION['user_role'] != 'student') {
            redirect('users/login');
        }
        $this->studentModel = $this->model('Student');
    }

    public function dashboard() {
        $profile = $this->studentModel->getProfile($_SESSION['user_id']);
        $messages = $this->studentModel->getApprovedMessages($_SESSION['user_id']);
        
        $data = [
            'profile' => $profile,
            'messages' => $messages
        ];
        
        $this->view('students/dashboard', $data);
    }

    public function editProfile() {
        $profile = $this->studentModel->getProfile($_SESSION['user_id']);
        $data = ['profile' => $profile];
        $this->view('students/edit_profile', $data);
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $profile = $this->studentModel->getProfile($_SESSION['user_id']);
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'surname' => trim($_POST['surname']),
                'age' => trim($_POST['age']),
                'class' => trim($_POST['class']),
                'about' => trim($_POST['about']),
                'profile_photo' => $profile->profile_photo,
                'banner_image' => $profile->banner_image,
                'result_files' => $profile->result_files
            ];

            // Handle Image Uploads
            if (!empty($_FILES['profile_photo']['name'])) {
                $data['profile_photo'] = $this->uploadFile($_FILES['profile_photo'], 'profile_photos');
            }
            if (!empty($_FILES['banner_image']['name'])) {
                $data['banner_image'] = $this->uploadFile($_FILES['banner_image'], 'banner_images');
            }

            // Handle PDF Multi-upload
            if (!empty($_FILES['result_files']['name'][0])) {
                $files = [];
                foreach($_FILES['result_files']['tmp_name'] as $key => $tmp_name) {
                    $file = [
                        'name' => $_FILES['result_files']['name'][$key],
                        'tmp_name' => $tmp_name,
                        'size' => $_FILES['result_files']['size'][$key],
                        'error' => $_FILES['result_files']['error'][$key]
                    ];
                    $uploadedPath = $this->uploadFile($file, 'results');
                    if($uploadedPath) $files[] = $uploadedPath;
                }
                $existing = json_decode($profile->result_files) ?? [];
                $data['result_files'] = json_encode(array_merge($existing, $files));
            }

            if ($this->studentModel->updateProfile($data)) {
                flash('student_message', 'Profile updated successfully');
                redirect('students/dashboard');
            }
        }
    }

    private function uploadFile($file, $folder) {
        $targetDir = APPROOT . '/../public/uploads/' . $folder . '/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $filename = time() . '_' . basename($file['name']);
        $targetPath = $targetDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $folder . '/' . $filename;
        }
        return false;
    }

    public function reply() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $_POST['sponsor_id'],
                'content' => trim($_POST['content'])
            ];

            if ($this->studentModel->sendReply($data)) {
                flash('student_message', 'Reply submitted and awaiting admin approval.');
                redirect('students/dashboard');
            }
        }
    }
}
