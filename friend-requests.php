<?php 
require_once('config/load-classes.php');
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
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Date Sent</th>
                    <th scope="col">Accept</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <?php 
                $allFriends = $friend->viewFriendRequestsByUser($_SESSION['user_id']); 
                if(!empty($allFriends)) {
                  foreach ($allFriends as $column) {
                    ?>
                    <tbody>
                      <tr>
                        <td><?php echo $column['friend_name']; ?></td>
                        <td><?php echo date("D, d M Y H:i:s", strtotime($column['date_added'])); ?></td>
                        <td>
                          <form action="#">
                            <input type="submit" class="btn btn-primary" value="Accept">
                          </form>
                        </td>
                        <td>
                          <form action="#">
                            <button type="submit" class="btn btn-danger" value="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                          </form>
                        </td>
                      </tr>
                    <?php }} else {
                      echo "<p class='text-center'>You may add some new friends!</p>"; 
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