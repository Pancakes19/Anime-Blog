<?php
include 'partials/header.php';

if(isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	$query = "SELECT * FROM users WHERE id=$id";
	$result = mysqli_query($connection, $query);
	$user = mysqli_fetch_assoc($result);
} else {
	header('location: ' . ROOT_URL . 'admin/manage-users.php');
	die();
}
?>

<section class="dashboard">
	
	
        <aside>
          
        </aside>
        <main>
          <section class="form__section">
          <div class="container form__section-container">
    <h2>Edit my details</h2>
    <form action="<?= ROOT_URL ?>admin/edit-logic.php" method="POST">
        <input type="hidden" value="<?= $user['id'] ?>" name="id" >
        <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name">
        <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name">
        <input type="text" value="<?= $user['username'] ?>" name="username" placeholder="Username">
        <input type="email" value="<?= $user['email'] ?>" name="email" placeholder="Email">

        <button type="submit" name="submit" class="btn">Update</button>
    </form>
    
        </section>
        </main>
      </div>
    </section>





<?php
include 'partials/footer.php'
?>