<?php

namespace App\Controllers;

use App\Core\Controller;

class Pages extends Controller {
    public function __construct() {
        // If logged in, redirect to dashboard
        if (isLoggedIn()) {
            if ($_SESSION['user_role'] == 'admin') {
                redirect('admins/dashboard');
            } elseif ($_SESSION['user_role'] == 'sponsor') {
                redirect('sponsors/dashboard');
            } else {
                redirect('students/dashboard');
            }
        }
    }

    public function index() {
        $data = [
            'title' => 'Welcome to IOI Scholarship System'
        ];

        $this->view('pages/index', $data);
    }
}
