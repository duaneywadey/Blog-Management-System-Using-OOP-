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
      <div class="row">
        <?php

        // Select those users you're already friends with
        $allConfirmedFriends = $friend->viewFriendsByUser($_SESSION['user_id']);
        $userIdsConfirmedFriends = array_column($allConfirmedFriends, 'user_id');
        $uniqueUserIdsConfirmedFriends = array_unique($userIdsConfirmedFriends);

        // Select those users who sent friend requests
        $allConfirmedFriendRequests = $friend->viewFriendRequestsByUser($_SESSION['user_id']);
        $userIdsConfirmedFriendRequests = array_column($allConfirmedFriendRequests, 'user_id');
        $uniqueUserIdsConfirmedFriendRequests = array_unique($userIdsConfirmedFriendRequests);


        foreach ($friend->viewAllUsers($_SESSION['user_id']) as $column) { 
          ?>
          <div class="col-md-4 mt-4">
            <div class="card">
              <div class="card-body"><h2><?php echo $column['username']; ?></h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                  <input type="hidden" name="friend_id" value='<?php echo $column['id']; ?>'>
                  <?php if(in_array($column['id'], $uniqueUserIdsConfirmedFriends)) { ?>
                    <input type="submit" class="btn btn-light" value="Already a friend!" name="addNewFriend" disabled>
                  <?php } else {?>
                    <input type="submit" class="btn btn-primary" value="Add Friend" name="addNewFriend">
                  <?php } ?>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
  </html>