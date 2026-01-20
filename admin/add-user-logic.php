<?php
require 'config/database.php';

//created table users
//get form to sent to database when add user is clicked
if(isset($_POST['submit'])) {
	$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$createpassword= filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
	$avatar = $_FILES['avatar'];

	
	//validate input 
	if(!$firstname) {
		$_SESSION['add-user'] = "Please enter your first name bro!";
	} elseif(!$lastname) {
		$_SESSION['add-user'] = "Please enter your last name bro!";
	}elseif(!$username) {
		$_SESSION['add-user'] = "Please enter your username bro!";
	}elseif(!$email) {
		$_SESSION['add-user'] = "Please enter a valid email bro!";
	}elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
		$_SESSION['add-user'] = "Password is too short bro!";
	}elseif(!$avatar['name']) {
		$_SESSION['add-user'] = "U need to add a Pfp bro!";
	}else {
		//check if passwords are matching
		if($createpassword !== $confirmpassword) {
			$_SESSION['add-user'] = "Your passwords don't match bruh! ";
		} else{
			//if they match then hash them
			$hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
			
			//ok now we check if the username or email already exists
			$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' ";
			$user_check_result = mysqli_query($connection, $user_check_query);
			if (mysqli_num_rows($user_check_result) > 0) {
				$_SESSION['add-user'] = "That Username or Email already exist bro!";
			}else{
				//cheking the avatar
				//rename avatar with current timestamp
				$time = time();
				$avatar_name = $time . $avatar['name'];
				$avatar_tmp_name = $avatar['tmp_name'];
				$avatar_destination_path = '../images/' . $avatar_name;
				
				//make sure file is an image
				$allowed_files = ['png', 'jpg', 'jpeg'];
				$extention = explode('.', $avatar_name);
				$extention = end($extention);
				if(in_array($extention, $allowed_files)) {
					//make sure the file is not too large (1mb+)
					if($avatar['size'] < 1000000){
						//upload avatar
						move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
					}else {
						$_SESSION['add-user'] = "Your image size is too big bro! Not more than 1mb";
					}
				}else {
					$_SESSION['add-user'] = "We only allow .png, .jpg or jpeg file extensions bro!";

				}
			}
		}
	}

	//redirect to add user page if there are any problems
	if(isset($_SESSION['add-user'])) {
		//re-set the data back into the form
		$_SESSION['add-user-data'] = $_POST;
		header('location: ' . ROOT_URL . '/admin/add-user.php');
		die();
	} else {
		//proceed to insert data into the database
		$insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
		$insert_user_result = mysqli_query($connection, $insert_user_query);
		
		if(!mysqli_errno($connection)) {
			//redirect to login with success message
			$_SESSION['add-user-success'] = "$firstname $lastname just joined the family bro!";
			header('location: ' . ROOT_URL . 'admin/manage-users.php');
			die();

		}
	}
	
} else{
	//if the button was not cliked then go back to add-user page
	header ('location: ' . ROOT_URL . 'admin/add-user.php');
	die();
}
