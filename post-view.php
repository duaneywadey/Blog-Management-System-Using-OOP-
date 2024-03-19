<?php 

session_start();
require_once('config/dbcon.php');
require_once('classes/Class.User.php');
require_once('classes/Class.Post.php');

$user = new User($pdo);
$post = new Post($pdo);

if (!$user->isLoggedIn()) {
	$user->redirect('login.php');
}


// Included in the URL, to get view all comments
if(isset($_GET["id"]) && !empty($_GET['id'])) {
	$post_id = $_GET['id'];
	$postDetails = $post->getPostById($post_id);
	$allComments = $post->fetchAllComments($post_id);
}

if(isset($_POST['commentToPost'])) {
	$user = $_SESSION['user_id'];
	$description = $_POST['description'];
	$post->writeAComment($post_id, $user, $description);
	header("Location: post-view.php?id=" . $post_id);
	exit();
	
}

if(isset($_POST['deleteCommentBtn'])) {
	$comment_id = $_POST['comment_id'];
	$post->deleteAComment($comment_id);
	header("Location: post-view.php?id=" . $post_id);
	exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
	<?php include('includes/navbar.php'); ?>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mt-4">
					<div class="card-body">
						<h3 class="text-secondary"><?php echo $postDetails['username']; ?></h3>
						<small><i><?php echo date("D, d M Y H:i:s", strtotime($postDetails['date_created'])); ?></i></small>
						<h4 class="mt-4"><?php echo $postDetails['title']; ?></h4>
						<p><?php echo $postDetails['description']; ?></p>
					</div>
				</div>
				<div class="mt-4">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $post_id;?>" method="POST">
						<div class="mb-3">
							<input type="hidden" value="<?php echo $postDetails['post_id']; ?>" name="post_id">
						</div>
						<div class="mb-3">
							<label for="exampleFormControlTextarea1" class="form-label">Comment</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
						</div>
						<input type="submit" class="btn btn-primary" name="commentToPost">
					</form> 			
				</div>
			</div>
			<div class="col-md-4 mt-4">
				<div class="card" style="height: 500px; overflow-y: scroll;">
					<div class="card-header">
						<div class="card-title"><h2>All Comments</h2></div>
					</div>
					<div class="card-body">
						<?php $allComments = $post->fetchAllComments($post_id); ?>
						<?php foreach($allComments as $column) { ?>
							<div class="card mb-3">
								<div class="card-body">
									<div class="comment">
										<?php if($column['user_id'] == $_SESSION['user_id']) { ?>
										<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $post_id;?>" method="POST">
											<input type="hidden" value="<?php echo $column['comment_id']; ?>" name="comment_id">
											<input type="submit" class="btn btn-danger float-end" value="Delete" name="deleteCommentBtn">
										</form>
										<?php } ?>
										<h4><?php echo $column['username']; ?></h4>
										<small><i><?php echo date("D, d M Y H:i:s", strtotime($column['date_created'])); ?></i></small>
										<p><?php echo $column['description']; ?></p>
									</div>	
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>