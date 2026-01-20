<?php
require 'config/database.php';


if(isset($_POST['submit'])) {
	// get form database
	$username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	if(!$username_email){
		$_SESSION['signin'] = "Enter your username or email broskii";
	} elseif (!$password){
		$_SESSION['signin'] = "Enter your password broskii";
	} else{
		//get user from database
		$fetch_user_query = "SELECT * FROM users WHERE username= '$username_email' OR email='$username_email' ";
		$fetch_user_result = mysqli_query($connection, $fetch_user_query);
		
		if(mysqli_num_rows($fetch_user_result) ==1) {
			//convert the record to an associative array
			$user_record = mysqli_fetch_assoc($fetch_user_result);
			$db_password = $user_record['password'];
			//compare form passwordwith database password
			if(password_verify($password, $db_password)) {
				//set session for access control
				$_SESSION['user-id'] = $user_record['id'];
				//set session if user is an admin
				if($user_record['is_admin'] == 1) {
					$_SESSION['user_is_admin'] = true;
				}
				
				//log normal admin in
				header('location: ' . ROOT_URL . 'admin/');
			} else { 
				$_SESSION['signin'] = "I think something is wrong bruh!";
			}
		} else {
			$_SESSION['signin'] = "That user does not exist bruh!";
		}
	}
	
	//if any problem happens rediret to the signin
	if(isset($_SESSION['signin'])) {
		$_SESSION['signin-data'] = $_POST;
		header('location: ' . ROOT_URL . 'signin.php');
		die();
	}
	
} else {
	header('location: ' . ROOT_URL . 'signin.php');
	die();
}