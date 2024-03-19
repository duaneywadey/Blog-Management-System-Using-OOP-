<?php 
require_once('config/load-classes.php');

if (isset($_POST['addNewFriend'])) {
  $user = $_SESSION['user_id'];
  $friend_id = $_POST['friend_id'];
  $friend->addAFriend($user, $friend_id);
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
        <div class="col-md-6">
          <div class="card mt-4">
            <div class="card-header">
              <h2>Friend Requests</h2>
            </div>
            <div class="card-body">
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>