<?php
require 'database.php'; // only if needed

$timeout_duration = 2700; // 45 minutes

// Use correct session key
if (!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL); // redirect to homepage
    exit();
}

// If session expired → destroy and redirect
if (isset($_SESSION['LAST_ACTIVITY']) &&
   (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

    session_unset();
    session_destroy();
    header('location: ' . ROOT_URL); // redirect to homepage
    exit();
}

// Update activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();
