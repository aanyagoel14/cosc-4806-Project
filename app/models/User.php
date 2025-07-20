<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
        
    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

    public static function logAttempt($username, $attempt) {
      $db = db_connect();
      $statement = $db->prepare("INSERT INTO login_attempts (username, attempt, time) VALUES (?, ?, NOW())");
      $statement->execute([$username, $attempt]);
    }

    public static function isLockedOut($username) {
        $db = db_connect();
        $statement = $db->prepare("SELECT COUNT(*) FROM login_attempts 
                                   WHERE username = ? AND attempt IN ('failed', 'bad') 
                                   AND time > NOW() - INTERVAL 60 SECOND");
        $statement->execute([$username]);
        $failedAttempts = $statement->fetchColumn();

        if ($failedAttempts >= 3) {
            $statement = $db->prepare("SELECT MAX(time) FROM login_attempts 
                                       WHERE username = ? AND attempt IN ('failed', 'bad')");
            $statement->execute([$username]);
            $lastFailedTime = $statement->fetchColumn();

            if ($lastFailedTime) {
                $statement = $db->prepare("SELECT TIMESTAMPDIFF(SECOND, ?, NOW()) AS seconds_passed");
                $statement->execute([$lastFailedTime]);
                $secondsPassed = $statement->fetchColumn();

                return $secondsPassed < 60;
            }
        }

        return false;
    }

    public static function clearOldAttempts($username) {
        $db = db_connect();
        $statement = $db->prepare("DELETE FROM login_attempts 
                                   WHERE username = ? AND time <= NOW() - INTERVAL 60 SECOND");
        $statement->execute([$username]);
    }

    public function authenticate($username, $password) {
        if (empty($username) || empty($password)) {
            return false;
        }
    
        $username = strtolower($username);
        self::clearOldAttempts($username);
        if (self::isLockedOut($username)) {
            error_log("User $username is locked out");
            User::logAttempt($username, 'locked');
            $_SESSION['error'] = "Too many failed login attempts. Please try again in 60 seconds.";
            return false;
        }

        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($rows && isset($rows['Password'])) {
            if (password_verify($password, $rows['Password'])) {
                $_SESSION['auth'] = 1;
                $_SESSION['username'] = ucwords($username);
                unset($_SESSION['failedAuth']);
                User::logAttempt($username, 'good'); 
                return true;
            }
        }
    
        User::logAttempt($username, 'bad');
        $_SESSION['failedAuth'] = ($_SESSION['failedAuth'] ?? 0) + 1;
        $_SESSION['error'] = "Invalid credentials";
        return false;
    }
}


