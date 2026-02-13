<?php
require '../config/bootstrap.php';
require '../session-timout.php';
require 'config/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Debug: Check if ID is valid
    if(empty($id) || $id <= 0) {
        $_SESSION['delete-post'] = "Invalid post ID: " . $_GET['id'];
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
    
    // Get post from db in order to delete post pic from img folder
    $query = "SELECT * FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($connection, $query);
    
    // Check for query errors
    if(!$result) {
        $_SESSION['delete-post'] = "Database error: " . mysqli_error($connection);
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
    
    // Make sure only 1 record is returned
    if(mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;
        
        // Delete thumbnail file if it exists
        if($thumbnail_name && file_exists($thumbnail_path)) {
            if(!unlink($thumbnail_path)) {
                $_SESSION['delete-post'] = "Could not delete thumbnail file";
            }
        }
        
        // Delete post from db
        $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
        $delete_post_result = mysqli_query($connection, $delete_post_query);
        
        if(!$delete_post_result) {
            $_SESSION['delete-post'] = "Delete failed: " . mysqli_error($connection);
        } elseif(mysqli_affected_rows($connection) > 0) {
            $_SESSION['delete-post-success'] = "Post deleted successfully!";
        } else {
            $_SESSION['delete-post'] = "No post was deleted";
        }
    } else {
        $_SESSION['delete-post'] = "Post not found with ID: $id";
    }
} else {
    $_SESSION['delete-post'] = "No ID provided";
}

header('location: ' . ROOT_URL . 'admin/');
die();