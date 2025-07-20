<?php
require_once __DIR__ . '/../models/User.php';

class Login extends Controller {

    public function index() {		
	    $this->view('login/index');
    }
    
    public function verify(){
			if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
					$_SESSION['error'] = "Username and password are required";
					header('Location: /login');
					exit;
			}
			
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
			User::clearOldAttempts($username);
			if (User::isLockedOut($username)) {
				User::logAttempt($username, 'locked');
				$_SESSION['error'] = "Account locked for 60 seconds";
				header('Location: /login');
				exit;
			}
		
			$user = $this->model('User');
			$user->authenticate($username, $password); 

			$attemptStatus = isset($_SESSION['auth']) && $_SESSION['auth'] ? 'good' : 'bad';
			User::logAttempt($username, $attemptStatus);

			if ($attemptStatus === 'success') {
					header('Location: /home');
			} else {
					header('Location: /login');
			}
			exit;
    }

}
