<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
require 'config/database.php';

if (isset($_POST['submit'])) {

    // Get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Validate input
    if (!$firstname) {
        $_SESSION['edit-user'] = "Please enter your firstname bro";
    } elseif (!$lastname) {
        $_SESSION['edit-user'] = "Please enter your lastname bro!";
    } elseif (!$username) {
        $_SESSION['edit-user'] = "Please enter your username bro!";
    } elseif (!$email) {
        $_SESSION['edit-user'] = "Please enter your email bro!";
    } else {

        // Prepared statement for updating user
        $stmt = mysqli_prepare(
            $connection,
            "UPDATE users 
             SET firstname = ?, 
                 lastname = ?, 
                 username = ?, 
                 email = ?, 
                 is_admin = ? 
             WHERE id = ? 
             LIMIT 1"
        );

        if (!$stmt) {
            $_SESSION['edit-user'] = "Prepare failed: " . mysqli_error($connection);
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssii",
            $firstname,
            $lastname,
            $username,
            $email,
            $is_admin,
            $id
        );

        if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['edit-user'] = "Execution failed: " . mysqli_stmt_error($stmt);
        } else {
            $_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully";
        }

        mysqli_stmt_close($stmt);
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();
