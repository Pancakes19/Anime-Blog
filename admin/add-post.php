<?php
include 'partials/header.php';
?>



<section class="form__section">
<div class="container form__section-container">
    <h2>Add Post</h2>
    <div class="alert__message error">
        <p>Sign In failed. Try again Broskii</p>
    </div>
    <form action="" enctype="multipart/form-data" method="POST">
        <input type="text" placeholder="Title">
        <select>
            <option value="1">Anime</option>
        </select>
        <textarea rows="10" placeholder="Body"></textarea>
        <div class="form__control inline">
            <input type="checkbox" id="is_featured" checked>
            <label for="is_featured" >Featured</label>
        </div>
        <div class="form__control">
            <label for="thumbnail">Add thumbnail</label>
            <input type="file" id="thumbnail">
        </div>
        <button type="submit" class="btn">Add post</button>
    </form>
</div>
</section>

<?php
include '../partials/footer.php';
?>