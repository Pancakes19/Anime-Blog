<?php
require '../config/bootstrap.php';
require 'config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];
    
    // Initialize thumbnail_name
    $thumbnail_name = null;
    
    // Validate input
    if (!$title) {
        $_SESSION['edit-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Enter post body";
    } else {
        // Unlink old image if new one is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_name && file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }
            
            // Rename image with timestamp
            $time = time();
            $thumbnail_name = $time . '_' . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;
            
            // Allowed file extensions
            $allowed_files = ['jpg', 'png', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = strtolower(end($extension));
            
            if (in_array($extension, $allowed_files)) {
                if ($thumbnail['size'] < 2000000) {
                    // Upload image
                    if(!move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path)) {
                        $_SESSION['edit-post'] = "Failed to upload thumbnail";
                    }
                } else {
                    $_SESSION['edit-post'] = "File size too large (max 2MB)";
                }
            } else {
                $_SESSION['edit-post'] = "File should be png, jpg, or jpeg";
            }
        }
    }
    
    // Redirect back (with form data) to edit-post page if there is any problem
    if(isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    } else {
        // Set is_featured for all posts to 0 if this post is featured
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
            
            if(!$zero_all_is_featured_result) {
                $_SESSION['edit-post'] = "Error updating featured posts: " . mysqli_error($connection);
                header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
                die();
            }
        }
        
        // Set thumbnail name if a new one uploaded, else keep old thumbnail name 
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        
        // Update query
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if (!$result) {
            $_SESSION['edit-post'] = "Update failed: " . mysqli_error($connection);
            header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
            die();
        } elseif (mysqli_affected_rows($connection) >= 0) {
            $_SESSION['edit-post-success'] = "Post updated successfully";
        } else {
            $_SESSION['edit-post'] = "No changes made to post";
        }
    }
} else {
    $_SESSION['edit-post'] = "Unauthorized access";
}

header('location: ' . ROOT_URL . 'admin/');
die();