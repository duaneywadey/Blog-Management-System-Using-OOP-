<?php 
require_once('config/load-classes.php');

if ($_POST['addNewFriend']) {
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
      <div class="row">
        <?php $allUsers = $friend->viewAllUsers(); ?>
        <?php foreach ($allUsers as $column) { ?>
          <div class="col-md-4 mt-4">
            <div class="card">
              <div class="card-header"></div>
              <div class="card-body"><h2><?php echo $column['username']; ?></h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                  <input type="hidden" name="friend_id" value='<?php echo $column['id']; ?>'>
                  <input type="submit" class="btn btn-primary" value="Add Friend" name="addNewFriend">
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
  </html>