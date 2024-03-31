<?php
require_once('php/load_classes.php');

if (!$user->isLoggedIn()) {
  $user->redirect('login.php');
}

if(isset($_GET["id"]) && !empty($_GET['id'])) {
  $post_id = $_GET['id'];
  $postDetails = $post->getPostById($post_id);

}

if(isset($_POST['editBtn'])) {
  $title = $_POST['title']; 
  $description = $_POST['description'];
  $post_id = $_POST['post_id'];
  $is_successful = $post->editPost($title, $description, $post_id);

  if($is_successful) {
    echo "<script>alert('Edited sucessfully'); window.location.href='profile.php';</script>";
    exit();
  }
  else {
    echo "Edit failed";
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
      <div class="row justify-content-center">
        <div class="col-md-4 mt-4">
          <div class="card shadow-sm p-3 mb-5 bg-body rounded">
            <div class="card-body">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="mb-3">
                  <input type="hidden" value="<?php echo $postDetails['post_id']; ?>" name="post_id">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Title</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="<?php echo $postDetails['title']; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"><?php echo $postDetails['description']; ?></textarea>
                </div>
                <input type="submit" class="btn btn-primary" name="editBtn">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>