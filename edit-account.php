<?php
include 'partials/header.php'
?>

<section class="dashboard">
	
	<?php if(isset($_SESSION['add-post-success'])) : //shows if post a post was a success?>
		 <div class="alert__message success container">
			<p>
				<?= $_SESSION['add-post-success']; 
				unset($_SESSION['add-post-success']);
				?>
			</p>
		</div>
	<?php elseif (isset($_SESSION['edit-post-success'])) : //shows if edit post was a success?>
		 <div class="alert__message success container">
			<p>
				<?= $_SESSION['edit-post-success']; 
				unset($_SESSION['edit-post-success']);
				?>
			</p>
		</div>
	<?php elseif (isset($_SESSION['edit-post'])) : //shows if edit post was not success?>
		 <div class="alert__message error container">
			<p>
				<?= $_SESSION['edit-post']; 
				unset($_SESSION['edit-post']);
				?>
			</p>
		</div>
	<?php elseif (isset($_SESSION['delete-post-success'])) : //shows if delete post was success?>
		 <div class="alert__message success container">
			<p>
				<?= $_SESSION['delete-post-success']; 
				unset($_SESSION['delete-post-success']);
				?>
			</p>
		</div>
	<?php elseif (isset($_SESSION['delete-post'])) : //shows if delete post failed?>
		 <div class="alert__message error container">
			<p>
				<?= $_SESSION['delete-post']; 
				unset($_SESSION['delete-post']);
				?>
			</p>
		</div>
	<?php endif ?>
	
      <div class="containder dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-right"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-left"></i></button>
        <aside>
          
        </aside>
        <main>
            <section class="form__section">
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
</section>
        </main>
      </div>
    </section>





<?php
include 'partials/footer.php'
?>