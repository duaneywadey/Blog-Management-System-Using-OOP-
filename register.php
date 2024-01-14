<?php 

session_start();
require_once('config/dbcon.php');
require_once('classes/Class.User.php');

$user = new User($pdo);

$errors = array();


if(isset($_POST['registerBtn'])) {
    
    $uname = $_POST['user'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    if($user->passwordValidate($pass, $pass2) != null) {
        $errors[]= $user->passwordValidate($pass, $pass2);
    }
    
    if ($user->emailValidate($email) != null) {
        $errors[]= $user->emailValidate($email);
    }

    if(empty($errors)) {

        if($user->register($uname, $email, $pass) === true) {
            $user->redirect('index.php');
        }
        else {
            echo "<script>alert('Error registering. Please try again. Username/email has a duplicate');</script>";
        }
    }

    else {

        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }

    }

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
                 <div class="card-title"><h2>Register here first!</h2></div>
             </div>
             <div class="card-body">
                 <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="mb-3">
                       <label for="exampleInputEmail1" class="form-label">Username</label>
                       <input type="text" name="user" class="form-control" id="exampleInputEmail1">
                   </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    </div>
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">Password</label>
                       <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                   </div> 					
                   <div class="mb-3">
                       <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                       <input type="password" name="pass2" class="form-control" id="exampleInputPassword2">
                   </div>
                   <input type="submit" class="btn btn-primary float-end" value="Submit" name="registerBtn">
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