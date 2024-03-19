<?php 
require_once('config/load-classes.php');

if (!$user->isLoggedIn()) {
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
  }else {
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
      <div class="row">
        <h3 class="mt-4 text-success">Hello there, <?php echo ucwords($_SESSION['username']); ?>!</h3>
        <div class="col-md-4 mt-4">
          <div class="card shadow-sm p-3 mb-5 bg-body rounded">
            <div class="card-body">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Title</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" name="createPost">
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8 mt-4">
          <?php 
            $friendPosts = $post->viewAllPostsByFriends($_SESSION['user_id']);

            if (!empty($friendPosts)) {
              foreach ($friendPosts as $column) { 
          ?>
            <div class="card shadow-sm p-3 mb-5 bg-body rounded">
              <div class="card-body">
                <h3 class="text-secondary"><?php echo $column['username']; ?></h3>
                <small><i><?php echo date("D, d M Y H:i:s", strtotime($column['date_created'])); ?></i></small>
                <h4 class="mt-4"><?php echo $column['title']; ?></h4>
                <p><?php echo $column['description']; ?></p>
                <a href="post-view.php?id=<?php echo $column['post_id']; ?>">View Comments</a>
              </div>
            </div>
          <?php }} else {
              echo "<p class='text-center'>You may add some new friends to see blog posts here!</p>";
            }
          ?>
        </div>
      </div>
    </div>
  </body>
  </html>