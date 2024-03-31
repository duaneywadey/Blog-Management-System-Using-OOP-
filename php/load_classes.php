<?php 

session_start();
require_once('dbcon.php');
require_once('classes/Users.php');
require_once('classes/Posts.php');
require_once('classes/Friends.php');

$user = new User($pdo);
$post = new Post($pdo);
$friend = new Friend($pdo);