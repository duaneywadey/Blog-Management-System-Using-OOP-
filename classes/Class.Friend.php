<?php 

class Friend {
	protected $pdo;

	public function __construct($pdo) {
		try {
			$this->pdo = $pdo;
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}


	public function viewAllUsers($user) {
		try {
			$sql = "SELECT * FROM users WHERE NOT id=?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user]);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function addAFriend($user, $friend_id) {
		try {

			$sql = "SELECT * FROM friends WHERE user = ? AND friend_id = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user, $friend_id]);
			$howMany = $stmt->rowCount();
			if($howMany > 0) {
				echo "<script>alert('You already added this person.');</script>";
			}
			else {
				$stmt->closeCursor();
				$sql = "INSERT INTO friends(user, friend_id) VALUES(?,?)";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([$user, $friend_id]);
			}
			
		}
		catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function viewFriendRequestsByUser($user) {
		try {
			$sql = "SELECT 
						users.username AS friend_name, 
						friends.date_added AS date_added 
					FROM users 
					JOIN friends 
						ON users.id = friends.friend_id 
					WHERE user = ?
					AND
					is_accepted = 0
					";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user]);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function viewFriendsByUser($user) {
		try {
			$sql = "SELECT 
						users.username AS friend_name, 
						friends.date_added AS date_added 
					FROM users 
					JOIN friends 
						ON users.id = friends.friend_id 
					WHERE user = ?
					AND
					is_accepted = 1
					";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user]);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			die($e->getMessage());
		}

	}

}
?>