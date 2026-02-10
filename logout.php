<?php
require 'config/bootstrap.php';
require 'config/constants.php';

// Clear all session variables
$_SESSION = array();

// Delete the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to home
header('location: ' . ROOT_URL);
die();