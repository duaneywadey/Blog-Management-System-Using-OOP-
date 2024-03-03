<?php
require_once('config/load-classes.php');

if (!$user->isLoggedIn()) 
{
  $user->redirect('login.php');
}

if(isset($_POST['createPost'])) {
  $user = $_SESSION['user_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $is_successful = $post->createPost($user, $title, $description);

  if($is_successful === true) {
    echo "<script>alert('Record saved'); window.location.href='index.php'; </script>";
    exit();
  }
  else {
    echo "Error";
  }
}


if(isset($_POST['deleteBtn'])) {
  $post_id = $_POST['post_id'];
  $is_successful = $post->deletePost($post_id);

  if($is_successful === true) {
    echo "Deleted successfully";
  }
  else {
    echo "Error";
  }
}

?>
<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <?php include('includes/navbar.php'); ?>
    <div class="container">
    	<div class="row mt-4">
    		<div class="col-md-6">
    			<div class="card">
    				<div class="card-header">
    					<div class="card-title"><h3>Your Profile</h3></div>
    				</div>
    				<div class="card-body">
    					<h5>Name: <?php echo $_SESSION['username']; ?></h5>
    					<h5>Email: <?php echo $_SESSION['email']; ?></h5>
    				</div>
    			</div>
          <div class="card shadow-sm mb-5 mt-4 bg-body rounded">
            <div class="card-header"><h2>All Posts:</h2></div>
            <div class="card-body">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <?php foreach ($post->viewPostsByUser($_SESSION['user_id']) as $column) { ?>
                  <input type="hidden" value="<?php echo $column['id']; ?>" name="post_id">
                  <a href="post-edit.php?id=<?php echo $column['id']; ?>" class="btn btn-primary float-end" style="margin-left: 4px;">Edit</a>
                  <input type="submit" class="btn btn-danger float-end" value="Delete" name="deleteBtn">
                </form>
                <h4 class="mt-4"><?php echo $column['title']; ?></h4>
                <small><i><?php echo date("D, d M Y H:i:s", strtotime($column['date_created'])); ?></i></small>
                <p><?php echo $column['description']; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <div class="card-title"><h3>All Friends</h3></div>
            </div>
            
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Friend Name</th>
                    <th scope="col">Date Added</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($friend->viewFriendsByUser($_SESSION['user_id']) as $column) { ?>
                    <tr>
                      <td><?php echo $column['friend_name']; ?></td>
                      <td><?php echo date("D, d M Y H:i:s", strtotime($column['date_added'])); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>