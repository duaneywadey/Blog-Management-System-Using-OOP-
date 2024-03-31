<?php 

// For debugging
// require_once('../config/dbcon.php');


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
				echo "<script>alert('Friend request already sent!');</script>";
			}
			else {
				$stmt->closeCursor();
				$sql = "INSERT INTO friends(user_who_added, user_being_added) VALUES(?,?)";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([$user, $friend_id]);
				echo "<script>alert('Successfully added!');</script>";

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
						users.id AS user_id,
						users.username AS friend_name, 
						friends.id AS add_friend_id,
						friends.user_who_added AS user_who_added,
						friends.user_being_added AS user_being_added,
						friends.date_added AS date_added,
						friends.is_accepted AS friend_is_accepted
					FROM users 
					JOIN friends 
						ON users.id = friends.user_who_added 
					WHERE 
					friends.is_accepted = 0 AND friends.user_being_added = ?
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
			// $sql = "SELECT 
			// 			users.id AS user_id,
			// 			users.username AS friend_name, 
			// 			friends.date_added AS date_added,
			// 			friends.is_accepted AS friend_is_accepted
			// 		FROM users 
			// 		JOIN friends 
			// 			ON users.id = friends.user_who_added 
			// 			OR users.id = friends.user_being_added
			// 		WHERE
			// 			friends.is_accepted = 1 AND friends.user_being_added = ? 
			// 			OR friends.user_who_added = ?  
			// 		";

			$sql = "SELECT
						users.id AS user_id,
						users.username AS friend_name,
						friends.date_added AS date_added
					FROM users
					JOIN friends ON friends.user_who_added = users.id
					WHERE friends.user_being_added = ? AND friends.is_accepted = 1

					UNION

					SELECT
						users.id AS user_id,
						users.username AS friend_name,
						friends.date_added AS date_added

					FROM users
					JOIN friends ON friends.user_being_added = users.id
					WHERE friends.user_who_added = ? AND friends.is_accepted = 1
				";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user, $user]);
			return $stmt->fetchAll();
		}
		catch (PDOException $e){
			die($e->getMessage());
		}

	}

}

// $friend = new Friend($pdo);
// $allObjs = $friend->viewFriendsByUser(10);
// foreach ($allObjs as $column) {
// 	echo $column['friend_name'] . "\n" . $column['friend_is_accepted'] . "<br>";
// }

?>