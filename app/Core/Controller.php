<?php

namespace App\Core;

/*
 * Base Controller
 * Loads the models and views
 */
class Controller {
    // Load model
    public function model($model) {
        // Require model file
        require_once APPROOT . '/Models/' . $model . '.php';
        
        // Instantiate model
        $modelClass = "\\App\\Models\\" . $model;
        return new $modelClass();
    }

    // Load view
    public function view($view, $data = []) {
        // Check for view file
        if (file_exists(APPROOT . '/Views/' . $view . '.php')) {
            require_once APPROOT . '/Views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
}
