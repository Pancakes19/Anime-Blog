<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
require 'config/database.php';

if(isset($_POST['submit'])) {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = $_POST['createpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $is_admin = isset($_POST['userrole']) ? 1 : 0;
    $avatar = $_FILES['avatar'];

    // Validate input
    if(!$firstname) {
        $_SESSION['add-user'] = "Please enter your first name bro!";
    } elseif(!$lastname) {
        $_SESSION['add-user'] = "Please enter your last name bro!";
    } elseif(!$username) {
        $_SESSION['add-user'] = "Please enter your username bro!";
    } elseif(!$email) {
        $_SESSION['add-user'] = "Please enter a valid email bro!";
    } elseif(strlen($createpassword) < 8) {
        $_SESSION['add-user'] = "Password must be at least 8 characters bro!";
    } elseif($createpassword !== $confirmpassword) {
        $_SESSION['add-user'] = "Your passwords don't match bruh!";
    } elseif(!$avatar['name']) {
        $_SESSION['add-user'] = "You need to add a Pfp bro!";
    }

    // Redirect back if validation fails
    if(isset($_SESSION['add-user'])) {
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        exit();
    }

    // Check if username or email already exists (SAFE)
    $stmt = $connection->prepare(
        "SELECT id FROM users WHERE username = ? OR email = ?"
    );

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $stmt->close();
        $_SESSION['add-user'] = "That Username or Email already exists bro!";
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        exit();
    }

    $stmt->close();

    // Handle avatar upload
    $time = time();
    $avatar_name = $time . '_' . basename($avatar['name']);
    $avatar_tmp_name = $avatar['tmp_name'];
    $avatar_destination_path = '../images/' . $avatar_name;

    $allowed_files = ['png', 'jpg', 'jpeg'];
    $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));

    if(!in_array($extension, $allowed_files)) {
        $_SESSION['add-user'] = "Only .png, .jpg or .jpeg allowed bro!";
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        exit();
    }

    if($avatar['size'] > 1000000) {
        $_SESSION['add-user'] = "Image must be less than 1MB bro!";
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        exit();
    }

    // Hash password
    $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

    // Insert user securely
    $stmt = $connection->prepare(
        "INSERT INTO users 
        (firstname, lastname, username, email, password, avatar, is_admin) 
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssssi",
        $firstname,
        $lastname,
        $username,
        $email,
        $hashed_password,
        $avatar_name,
        $is_admin
    );

    if($stmt->execute()) {

        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);

        $_SESSION['add-user-success'] = "$firstname $lastname just joined the family bro!";
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        exit();

    } else {
        $_SESSION['add-user'] = "Something went wrong bro!";
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        exit();
    }

    $stmt->close();

} else {
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    exit();
}
