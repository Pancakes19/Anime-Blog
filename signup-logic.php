<?php
require 'config/bootstrap.php';
require 'config/database.php';

if(isset($_POST['submit'])) {

    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Validate Input
    if(!$firstname) {
        $_SESSION['signup'] = "Please enter your first name bro!";
    } elseif(!$lastname) {
        $_SESSION['signup'] = "Please enter your last name bro!";
    } elseif(!$username) {
        $_SESSION['signup'] = "Please enter your username bro!";
    } elseif(!$email) {
        $_SESSION['signup'] = "Please enter a valid email bro!";
    } elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password is too short bro!";
    } elseif(!$avatar['name']) {
        $_SESSION['signup'] = "U need to add a Pfp bro!";
    } else {

        // Check if passwords match
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Your passwords don't match bruh!";
        } else {

            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exists
            $check_query = "SELECT id FROM users WHERE username = ? OR email = ?";
            $stmt = mysqli_prepare($connection, $check_query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) > 0) {
                $_SESSION['signup'] = "That Username or Email already exist bro!";
                mysqli_stmt_close($stmt);
            } else {

                mysqli_stmt_close($stmt);

                // Avatar handling
                $time = time();
                $avatar_name = $time . '_' . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));

                if(in_array($extension, $allowed_files)) {

                    if($avatar['size'] < 1000000) {

                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);

                        // Insert user into database
                        $insert_query = "INSERT INTO users 
                        (firstname, lastname, username, email, password, avatar, is_admin) 
                        VALUES (?, ?, ?, ?, ?, ?, 0)";

                        $stmt = mysqli_prepare($connection, $insert_query);

                        mysqli_stmt_bind_param(
                            $stmt,
                            "ssssss",
                            $firstname,
                            $lastname,
                            $username,
                            $email,
                            $hashed_password,
                            $avatar_name
                        );

                        mysqli_stmt_execute($stmt);

                        if(mysqli_stmt_errno($stmt) == 0) {
                            $_SESSION['signup-success'] = "Registration successful. Please Log in bro!";
                            header('location: ' . ROOT_URL . 'signin.php');
                            die();
                        }

                        mysqli_stmt_close($stmt);

                    } else {
                        $_SESSION['signup'] = "Your image size is too big bro! Not more than 1mb";
                    }

                } else {
                    $_SESSION['signup'] = "We only allow .png, .jpg or .jpeg files bro!";
                }
            }
        }
    }

    // Redirect back if there was an error
    if(isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
