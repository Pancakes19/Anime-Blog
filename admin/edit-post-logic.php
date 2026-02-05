<?php 
require 'config/database.php';

// make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate input
    if (!$title) {
        $_SESSION['edit-post'] = "enter post title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "enter post body";
    } else {

        // unlink old image if new one is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;

            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            // rename image with timestamp
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // allowed file extensions
            $allowed_files = ['jpg', 'png', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if (in_array($extension, $allowed_files)) {
                if ($thumbnail['size'] < 2000000) {
                    // upload image
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "file size too large";
                }
            } else {
                $_SESSION['edit-post'] = "file should be png, jpg, jpeg";
            }
        }
    }
	
	//redirect back (with for data) to add-post page if there is any problem
	if(isset($_SESSION['edit-post'])) {
		$_SESSION['edit-post-data'] = $_POST;
		header('location: ' . ROOT_URL . 'admin/');
		die();
	} else {
		// set is_feature for all post to 0 if this post is featured
		if($is_featured == 1) {
			$zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
			$zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
		}
		
		//set thumbnail  name if a new one uploaded, else keep old thumbnail name 
		$thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
		
		$query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
		$result = mysqli_query($connection, $query);
	}
	
	if (!mysqli_errno($connection)) {
		$_SESSION['edit-post-success'] = "Post updated successfully";
	}
}

header('location: ' . ROOT_URL . 'admin/');
die();
	
