<?php 
require_once('php/load_classes.php');

$errors = array();


if ($user->isLoggedIn()) {
    $user->redirect('index.php');
}

if(isset($_POST['loginBtn'])) {
   $uname = $_POST['user'];
   $pass = $_POST['password'];
   $user->login($uname, $pass);
   $user->redirect('index.php'); 
}

?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <div class="container">
     <div class="row justify-content-center mt-4">
        <div class="col-4">
           <div class="card">
              <div class="card-header">
                 <div class="card-title"><h2>Login now!</h2></div>
             </div>
             <div class="card-body">
                 <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Username</label>
                       <input type="text" class="form-control" id="exampleInputEmail1" name="user">
                   </div>
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">Password</label>
                       <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                   </div>
                   <div class="mb-3">
                      <p>Don't have an account? Register <a href="register.php">here</a></p>
                   </div> 					
                   <input type="submit" class="btn btn-primary float-end" name="loginBtn">
               </form>
           </div>
       </div>
   </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>