<?php
require 'config/database.php';

if(isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	
	//fetch user from database
	$query = "SELECT * FROM users WHERE id=$id";
	$result = mysqli_query($connection, $query);
	$user = mysqli_fetch_assoc($result);
	
	//making sure we got back only one userif
	if(mysqli_num_rows($result) == 1) {
		$avatar_name = $user['avatar'];
		$avatar_path = '../images' . $avatar_name;
		
		//delete image if it exists
		if ($avatar_path) {
			unlink($avatar_path);			
		}
	}
}