<?php
session_start();
if(isset($_POST["username"]) && $_POST['username'] != '') {
	$username = $_POST["username"];
}
if(isset($_POST["password"]) && $_POST['password'] != '') {
	$password = $_POST["password"];
}
if($username == 'ananta' && $password == "mouli") {
	$_SESSION['user'] = 'ananta';
	$_SESSION['msg'] = "Logged in successfully";
	$_SESSION['status'] = "success";
	header("location:index.php");
} else {
	$_SESSION['msg'] = "Error in logging";
	$_SESSION['status'] = "error";
	header("location:index.php");
}
?>