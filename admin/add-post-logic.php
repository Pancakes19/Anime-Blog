<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
require 'config/database.php';

date_default_timezone_set('Africa/Windhoek');

if (isset($_POST['submit'])) {

    $author_id = $_SESSION['user-id'];
    $title = trim($_POST['title']);
    $body = trim($_POST['body']);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Validate input
    if (!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose post thumbnail";
    } else {

        $time = time();
        $thumbnail_name = $time . '_' . basename($thumbnail['name']);
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_files = ['jpg', 'png', 'jpeg'];
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_files)) {
            $_SESSION['add-post'] = "File must be jpg, png, or jpeg";
        } elseif ($thumbnail['size'] > 2000000) {
            $_SESSION['add-post'] = "File size too large";
        }
    }

    // Redirect back if error
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        exit();
    }

    // If featured, reset all others
    if ($is_featured == 1) {
        $stmt = $connection->prepare("UPDATE posts SET is_featured = 0");
        $stmt->execute();
        $stmt->close();
    }

    $date_time = date('Y-m-d H:i:s');

    // Insert post securely
    $stmt = $connection->prepare(
        "INSERT INTO posts 
        (title, body, thumbnail, category_id, author_id, is_featured, date_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssiiis",
        $title,
        $body,
        $thumbnail_name,
        $category_id,
        $author_id,
        $is_featured,
        $date_time
    );

    if ($stmt->execute()) {

        move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

        $_SESSION['add-post-success'] = "New post added successfully bro!";
        header('location: ' . ROOT_URL . 'admin/');
        exit();

    } else {
        $_SESSION['add-post'] = "Couldn't add post.";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        exit();
    }

    $stmt->close();
}

header('location: ' . ROOT_URL . 'admin/add-post.php');
exit();





