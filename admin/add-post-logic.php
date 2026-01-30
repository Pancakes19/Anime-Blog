<?php 
require 'config/database.php';

if(isset($_POST['submit'])){
	$author_id = $_SESSION['user-id'];
	$title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
	$is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
	$thumbnail = $_FILES['thumbnail'];
	
	//set is_featured to 0 if unchecked 
	$is_featured = $is_featured == 1 ?: 0;
	
	//validate form
	
}









