<?php

class User {

	protected $pdo;

	public function __construct($pdo) {
		try {
			$this->pdo = $pdo;
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function register($uname, $email, $pass) {
		try {
			// For checking duplicate username/email
			$sql = "SELECT COUNT(*) FROM users WHERE username = ? OR email= ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$uname, $email]);
			$count = $stmt->fetchColumn();
			$stmt->closeCursor();

			if($count > 0) {
				return "Username already exists. Choose a different username.";
			}

			// Insert if no duplicates
			$passHash = password_hash($pass, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users(username, email, password) VALUES(?,?,?)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$uname, $email, $passHash]);
			return true;
		}

		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function usernameValidate($uname) {

		if(empty($uname)) {
			return 'Email is blank';
		}

		else if (strlen($uname) > 64) {
			return 'Email is too long';
		}
		else {
			$uname = strip_tags($uname);
		}
	}

	public function emailValidate($email)
	{
		if (empty($email)) {
			return 'Email is blank';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email';
		} elseif (strlen($email) > 64) {
			return 'Email is too long';
		} else {
			$email = strip_tags($email);
		}
	}


	public function passwordValidate($pass, $pass2) {

		if(empty($pass) || empty($pass2)) {
			return "Password is blank";
		} else if (strlen($pass) < 6) {
			return "Password is too short";
		} elseif ($pass !== $pass2) {
			return "Passwords don't match";
		}
	}


	public function login($uname, $pass) {
		try {
			$sql = "
					SELECT 
						id, 
						username, 
						email, 
						password 
					FROM users 
					WHERE username = ? OR email = ?
					";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$uname, $pass]);

        	// If info is found
			if($stmt->rowCount() == 1) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$uid = $row['id'];
				$uname = $row['username'];
				$email = $row['email'];
				$passHash = $row['password'];

				if(password_verify($pass, $passHash)) {
					$_SESSION['user_id'] = $uid;
					$_SESSION['username'] = $uname;
					$_SESSION['email'] = $email;
					$_SESSION['userLoginStatus'] = 1;
					return true;
				}
				else {
					return 'Wrong password';
				}
			}
			else {
				return 'Wrong username/email';
			}
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}


	public function isLoggedIn() {
		//Return true if session has been set, false if it hasn't
		if(isset($_SESSION['userLoginStatus'])) {
			return true;
		} 
		else {
			return false;
		}
	}

	public function redirect($url) {
		header("Location: $url");
	}
	public function logout() {
		session_start();
		$_SESSION = array();
		session_destroy();
		$this->redirect('index.php');
	}
}

?>