<?php 
require_once('config/load-classes.php');

if (isset($_POST['acceptFriendRequest'])) {
  $friends_id = $_POST['friends_id'];
  $friend->acceptAFriendRequest($friends_id);
}

if (isset($_POST['deleteFriendRequest'])) {
  $friends_id = $_POST['friends_id'];
  $friend->rejectAFriendRequest($friends_id);
}

?>

<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
              <?php 
                $allFriends = $friend->viewFriendRequestsByUser($_SESSION['user_id']); 
                if(!empty($allFriends)) {
                  foreach ($allFriends as $column) {
              ?>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Date Sent</th>
                    <th scope="col">Accept</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $column['friend_name']; ?></td>
                        <td><?php echo date("D, d M Y H:i:s", strtotime($column['date_added'])); ?></td>
                        <td>
                          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <input type="hidden" value="<?php echo $column['add_friend_id']; ?>" name="friends_id">
                            <button type="submit" class="btn btn-primary" name="acceptFriendRequest">Accept</button>
                          </form>
                        </td>
                        <td>
                          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <input type="hidden" value="<?php echo $column['add_friend_id']; ?>" name="friends_id">
                            <button type="submit" class="btn btn-danger" value="Delete" name="deleteFriendRequest"><i class="fa fa-trash" aria-hidden="true"></i></button>
                          </form>
                        </td>
                      </tr>
                    <?php }} else {
                      echo "<p class='text-center'>All your friend requests will appear here</p>"; 
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>