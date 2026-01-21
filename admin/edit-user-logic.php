<?php
if(isset($_POST['submit'])) {
	//get updated form data
	$id = filter_var($_POST['id'],  FILTER_SANITIZE_NUMBER_INT);
	$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$is_admin = filter_var($_POST['userrole'],  FILTER_SANITIZE_NUMBER_INT);
	
	
}