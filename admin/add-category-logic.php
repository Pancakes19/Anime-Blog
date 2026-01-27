<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
	//get form data 
	$title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	//checking if the nothing is entered
	if(!$title) {
		$_SESSION['add-category'] = "Enter the category title bro!";
	} elseif(!$description){
		$_SESSION['add-category'] = "Enter the category's description bro bro!";		
	}
	
	//redirect back to add category
	if(isset($_SESSION['add-category'])){
		
	}
	
}