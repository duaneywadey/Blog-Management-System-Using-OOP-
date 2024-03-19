<?php
// For debugging
// require_once('../config/dbcon.php');

class Post {
	
	protected $pdo;

	public function __construct($pdo) {
		try {
			$this->pdo = $pdo;
		} 
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function createPost($user, $title, $description) {
		try {
			$sql = "INSERT INTO posts (user,title,description) VALUES(?,?,?)";
			$stmt = $this->pdo->prepare($sql);
			$db_execute = $stmt->execute([$user, $title, $description]);
			return true;
		} 
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}


	public function deletePost($post_id) {
		try {
			$sql = "DELETE FROM posts WHERE id=?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$post_id]);
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}

	}

	public function getPostById($post_id)
	{
		try {
			$sql = "SELECT 
						users.username AS username, 
						posts.id AS post_id, 
						posts.title AS title, 
						posts.description AS description, 
						posts.date_created AS date_created 
					FROM posts 
					JOIN users ON users.id = posts.user 
					WHERE posts.id=? ORDER BY date_created DESC";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$post_id]);
			return $stmt->fetch();
		}
		catch (PDOException $e) 
		{
			die($e->getMessage());
		}
	}
	public function editPost($title, $description, $post_id) {
		try {
			$sql = "UPDATE posts SET title=?, description=? WHERE id=?";
			$stmt = $this->pdo->prepare($sql);
			$db_execute = $stmt->execute([$title, $description, $post_id]);
			return true;
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function viewAllPosts() {
		try {
			$sql = "
			SELECT users.username AS username, posts.id AS post_id, posts.title AS title, posts.description AS description, posts.date_created AS date_created FROM posts JOIN users ON users.id = posts.user ORDER BY date_created DESC;
			";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function viewAllPostsByFriends($user) {
		try {
			$sql = "
			SELECT 
				users.id AS user_id,
				users.username AS username, 
				posts.id AS post_id, 
				posts.title AS title, 
				posts.description AS description, 
				posts.date_created AS date_created
			FROM posts
			JOIN users ON users.id = posts.user
			JOIN friends ON posts.user = friends.friend_id
			WHERE friends.friend_id IN (
				SELECT friend_id FROM friends WHERE user = ?
			);
			ORDER BY date_created DESC
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user]);

			return $stmt->fetchAll();

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}



	public function viewPostsByUser($user) {
		try {
			$sql = "
					SELECT * FROM posts 
					WHERE user=? 
					ORDER BY date_created DESC
					";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$user]);

			return $stmt->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function fetchAllComments($post_id) {
		try {
			$sql = "SELECT
						comments.user_id AS user_id,
						users.username AS username, 
						comments.description AS description, 
						comments.date_created, 
						comments.id AS comment_id 
					FROM comments 
					JOIN posts on comments.post_id = posts.id 
					JOIN users on comments.user_id = users.id WHERE posts.id=?
					";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$post_id]);
			return $stmt->fetchAll();

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function writeAComment($post_id, $user_id, $description) {
		try {
			$sql = "INSERT INTO comments(post_id, user_id, description) VALUES (?,?,?)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$post_id, $user_id, $description]);

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function deleteAComment($comment_id) {
		try {
			$sql = "DELETE FROM comments WHERE id=?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$comment_id]);
			

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

}
// $obj = new Post($pdo);
// $allPosts = $obj->fetchAllComments(3);
// print_r($allPosts);




