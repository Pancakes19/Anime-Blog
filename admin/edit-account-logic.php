<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
require 'config/database.php';

if(isset($_POST['submit'])) {
	//get updated form data
	$id = filter_var($_POST['id'],  FILTER_SANITIZE_NUMBER_INT);
	$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

	
	//check for valid imput
	if(!$firstname) {
		$_SESSION['edit-user'] = "please enter your firstname bro";
	} elseif(!$lastname) {
		$_SESSION['edit-user'] = "Please enter your lastname bro!";
	}elseif(!$username) {
		$_SESSION['edit-user'] = "Please enter your username bro!";
	}elseif(!$email) {
		$_SESSION['edit-user'] = "Please enter your email bro!";
	}else {
		//update users table
		$query = "UPDATE users SET firstname= '$firstname', lastname='$lastname', username='$username', email='$email', is_admin=0 WHERE id=$id LIMIT 1";
		$result = mysqli_query($connection, $query);
		
		if(mysqli_errno($connection)) {
			$_SESSION['edit-user'] = "Failed to update user.";
		}else{
			$_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully";
		}
	}
}

header('location: ' . ROOT_URL . 'admin/edit-account.php');
die();
