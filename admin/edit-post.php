<?php
require '../config/bootstrap.php';
require '../config/session-timout.php';
include 'partials/header.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch cats from db
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);

// Get edit-post data from session if available
$title = $_SESSION['edit-post-data']['title'] ?? '';
$body = $_SESSION['edit-post-data']['body'] ?? '';

// Fetch post data from db if id is set 
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Validate ID is not empty
    if(empty($id) || $id <= 0) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
    
    $query = "SELECT * FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Database error: " . mysqli_error($connection));
    }
    
    $post = mysqli_fetch_assoc($result);
    
    // If post not found, redirect
    if(!$post) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
    
    // Use session data if available (after failed submission)
    if($title || $body) {
        $post['title'] = $title;
        $post['body'] = $body;
    }
} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// Display error message if exists
if(isset($_SESSION['edit-post'])) {
    echo '<div class="alert__message error"><p>' . $_SESSION['edit-post'] . '</p></div>';
    unset($_SESSION['edit-post']);
}

// Clear edit-post-data from session
unset($_SESSION['edit-post-data']);
?>
<section class="form__section">
<div class="container form__section-container">
    <h2>Edit Post</h2>
    <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?= $post['id'] ?>" >
        <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>" >
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Title">
        <select name="category_id">
            <?php 
            // Reset categories query pointer
            mysqli_data_seek($categories, 0);
            while ($category = mysqli_fetch_assoc($categories)) : 
            ?>
            <option value="<?= $category['id'] ?>" <?= ($post['category_id'] == $category['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['title']) ?>
            </option>
            <?php endwhile ?>       
        </select>
        <textarea rows="10" name="body" placeholder="Body"><?= htmlspecialchars($post['body']) ?></textarea>
        <div class="form__control inline">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?>>
            <label for="is_featured">Featured</label>
        </div>
        <div class="form__control">
            <label for="thumbnail">Change thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail">
        </div>
        <button type="submit" name="submit" class="btn">Update post</button>
    </form>
</div>
</section>
<?php
include '../partials/footer.php';
?>