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

if(isset($_GET["id"]) && !empty($_GET['id'])) {
	$post_id = $_GET['id'];
	$postDetails = $post->getPostById($post_id);
	$allComments = $post->viewAllComments($post_id);
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
			</div>
			<div class="col-md-4 mt-4">
				<div class="card" style="height: 500px; overflow-y: scroll;">
					<div class="card-header">
						<div class="card-title"><h2>All Comments</h2></div>
					</div>
					<div class="card-body">
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
						<div class="comment">
							<h4>Ivan</h4>
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate enim pariatur quidem id excepturi ad aliquid molestias ratione, facilis error libero laboriosam ut nisi odio, fugit esse iste officiis saepe.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>