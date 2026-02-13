<?php
require '../config/bootstrap.php';
require '../session-timout.php';
require 'config/database.php';

if (isset($_POST['submit'])) {
	$author_id = $_SESSION['user-id'];
	$title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
	$is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
	$thumbnail = $_FILES['thumbnail'];
	
	//set is_featured to 0 if unchecked 
	$is_featured = $is_featured == 1 ? : 0;
	
	//validate form input
	if (!$title) {
		$_SESSION['add-post'] = "enter post title";
	} elseif (!$category_id) {
		$_SESSION['add-post'] = "Select post category";
	}elseif (!$body) {
		$_SESSION['add-post'] = "enter post body";
	}elseif (!$thumbnail['name']) {
		$_SESSION['add-post'] = "choose post thumbnail";
	} else {
		//rename image with timestamp
		$time = time();
		$thumbnail_name = $time . $thumbnail['name'];
		$thumbnail_tmp_name = $thumbnail['tmp_name'];
		$thumbnail_destination_path = '../images/' . $thumbnail_name;
		
		//make sure file is an image
		$allowed_files = ['jpg', 'png', 'jpeg'];
		$extension = explode('.', $thumbnail_name);
		$extension = end($extension);
		if (in_array($extension, $allowed_files)) {
			//make sure image is not too big
			if ($thumbnail['size'] < 2000000) {
				//upload pic

			} else {
				$_SESSION['add-post'] = "file size too large";
			}			
		} else {
			$_SESSION['add-post'] = "file should be png, jpg, jpeg";
		}	
	}
	
	//redirect back (with for data) to add-post page if there is any problem
	if(isset($_SESSION['add-post'])) {
		$_SESSION['add-post-data'] = $_POST;
		header('location: ' . ROOT_URL . 'admin/add-post.php');
		die();
	} else {
		// set is_feature for all post to 0 if this post is featured
		if($is_featured == 1) {
			$zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
			$zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
		}
		
		//insert post into db 
		$query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured )";
		
		$result = mysqli_query($connection, $query);
		move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
		
		if(!mysqli_errno($connection)) {
			$_SESSION['add-post-success'] = "New post added successfully bro!";
			header('location: ' . ROOT_URL . 'admin/');
			die();
		}
	}
}

header('location: ' . ROOT_URL . 'admin/add-post.php');








