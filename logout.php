<?php 

require_once('config/dbcon.php');
require_once('classes/Class.User.php');

$user = new User($conn);
$user->logout();


