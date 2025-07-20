<?php

class Create extends Controller {

    public function index() {		
	    $this->view('create/index');
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Simple validation
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Username and password are required";
                header('Location: /create');
                exit;
            }

            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match";
                header('Location: /create');
                exit;
            }

            // Check if user exists
            $db = db_connect();
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([strtolower($username)]);

            if ($stmt->fetch()) {
                $_SESSION['error'] = "Username already taken";
                header('Location: /create');
                exit;
            }

            // Create user
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([
                strtolower($username),
                password_hash($password, PASSWORD_DEFAULT)
            ]);

            // Redirect to login with success message
            $_SESSION['success'] = "Account created! Please login";
            header('Location: /login');
        }
    }
}
