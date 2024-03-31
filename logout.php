<?php 

require_once('php/load_classes.php');


$user = new User($conn);
$user->logout();


