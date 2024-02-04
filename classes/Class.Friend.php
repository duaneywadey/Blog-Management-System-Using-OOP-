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

	public function viewAllUsers() {
		try {
			$sql = "SELECT * FROM users";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}
?>