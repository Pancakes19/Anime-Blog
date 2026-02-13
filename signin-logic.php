<?php
require 'config/bootstrap.php';
require 'config/database.php';

if(isset($_POST['submit'])) {
	// get form data
	$username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	if(!$username_email){
		$_SESSION['signin'] = "Enter your username or email broskii";
	} elseif (!$password){
		$_SESSION['signin'] = "Enter your password broskii";
	} else{
		//get user from database
		$fetch_user_query = "SELECT * FROM users WHERE username=? OR email=?";
		$stmt = mysqli_prepare($connection, $fetch_user_query);
		mysqli_stmt_bind_param($stmt, "ss", $username_email, $username_email);
		mysqli_stmt_execute($stmt);
		$fetch_user_result = mysqli_stmt_get_result($stmt);
		
		if(mysqli_num_rows($fetch_user_result) == 1) {
			// Convert the record to an associative array
			$user_record = mysqli_fetch_assoc($fetch_user_result);
			$db_password = $user_record['password'];
			
			// Compare form password with database password
			if(password_verify($password, $db_password)) {

			// 🔐 Prevent session fixation
			session_regenerate_id(true);

			// 👤 Store user ID
			$_SESSION['user-id'] = $user_record['id'];

			// 🕒 Start inactivity timer (45 minutes)
			$_SESSION['LAST_ACTIVITY'] = time();

			// 👑 If admin
			if($user_record['is_admin'] == 1) {
				$_SESSION['user_is_admin'] = true;
			}

			// 🚀 Redirect
			header('location: ' . ROOT_URL . 'admin/');
			die();
			} else { 
				$_SESSION['signin'] = "I think something is wrong bruh!";
			}
		} else {
			$_SESSION['signin'] = "That user does not exist bruh!";
		}
	}
	
	// If any problem happens, redirect to the signin page
	if(isset($_SESSION['signin'])) {
		$_SESSION['signin-data'] = $_POST;
		header('location: ' . ROOT_URL . 'signin.php');
		die();
	}
	
} else {
	header('location: ' . ROOT_URL . 'signin.php');
	die();
}