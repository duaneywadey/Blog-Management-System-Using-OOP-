<?php 

session_start();
require_once('dbcon.php');
require_once('./classes/Class.User.php');
require_once('./classes/Class.Post.php');
require_once('./classes/Class.Friend.php');

$user = new User($pdo);
$post = new Post($pdo);
$friend = new Friend($pdo);