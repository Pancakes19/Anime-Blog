<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
require 'config/database.php';

if(isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if(!$title) {
        $_SESSION['add-category'] = "Enter the category title bro!";
    } elseif(!$description){
        $_SESSION['add-category'] = "Enter the category's description bro!";        
    }

    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        exit();
    }

    $stmt = $connection->prepare(
        "INSERT INTO categories (title, description) VALUES (?, ?)"
    );

    $stmt->bind_param("ss", $title, $description);

    if($stmt->execute()){
        $stmt->close();
        $_SESSION['add-category-success'] = "$title added successfully";
        header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        exit();
    } else {
        $stmt->close();
        $_SESSION['add-category'] = "Couldn't add category.";
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        exit();
    }
}