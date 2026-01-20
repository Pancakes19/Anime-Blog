<?php
require 'config/constants.php';
// kill all sessions and redirect user to home page
session_destroy();
header('location: ' . ROOT_URL);
die();