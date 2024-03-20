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

			$sql = "SELECT * FROM friends WHERE user_who_added = ? AND user_being_added = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user, $friend_id]);
			$howMany = $stmt->rowCount();
			if($howMany > 0) {
				echo "<script>alert('You already added this person.');</script>";
			}
			else {
				$stmt->closeCursor();
				$sql = "INSERT INTO friends(user_who_added, user_being_added) VALUES(?,?)";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([$user, $friend_id]);
			}
			
		}
		catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function acceptAFriendRequest($friends_id) {
		try {
			$sql = "UPDATE 
						friends 
					SET is_accepted = 1
					WHERE id=?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$friends_id]);

		}
		catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function rejectAFriendRequest($friends_id) {
		try {
			$sql = "DELETE
					FROM 
						friends 
					WHERE id=?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$friends_id]);

		}
		catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function viewFriendRequestsByUser($user) {
		try {
			$sql = "SELECT 
						users.username AS friend_name, 
						friends.id AS add_friend_id,
						friends.user_who_added AS user_who_added,
						friends.user_being_added AS user_being_added,
						friends.date_added AS date_added 
					FROM users 
					JOIN friends 
						ON users.id = friends.user_who_added 
					WHERE friends.user_being_added = ?
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
						ON users.id = friends.user_who_added 
					WHERE user_being_added = ?
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