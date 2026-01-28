<?php
include 'partials/header.php'; 

if(isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	//fetching categories from db
	$query = "SELECT * FROM categories WHERE id=$id";
	$result = mysqli_query($connection, $query);
	
} else{
	header('location: ' . ROOT_URL . 'admin/manage-categories.php');
	die();
}


?>



<section class="form__section">
<div class="container form__section-container">
    <h2>Edit Category</h2>
    <form action="">
        <input type="text" placeholder="Title">
        <textarea rows="4" placeholder="Description">
        </textarea>
        
        <button type="submit" class="btn">Update Category</button>
    </form>
</div>
</section>

<?php
include '../partials/footer.php';
?>