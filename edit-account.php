<?php
include 'partials/header.php'
?>

<section class="form__section">
      <div class="container dashboard__container">

    
    <div class="container form__section-container">
    <h2>Edit User</h2>
    <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
        <input type="hidden" value="<?= $user['id'] ?>" name="id" >
        <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name">
        <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name">
        <input type="text" value="<?= $user['username'] ?>" name="username" placeholder="Username">
        <input type="email" value="<?= $user['email'] ?>" name="email" placeholder="Email">

        <select name="userrole">
            <option value="0">Author</option>
            <option value="1">Admin</option>
        </select>
        <button type="submit" name="submit" class="btn">Update User</button>
    </form>
</div>
</div>
</section>





<?php
include 'partials/footer.php'
?>