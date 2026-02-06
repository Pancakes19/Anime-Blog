<?php
include 'partials/header.php'

//fetch post from db if id is setcookie
if(isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	$query = "SELECT * FROM posts WHERE id=$id";
	$result = mysqli_query($connection, $query);
	$post mysqli_fetch_assoc($result);
} else{
	header('location: ' . ROOT_URL . 'blog.php');
}
?>


<section class="singlepost">
    <div class="container singlepost__container">
      <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, voluptatum.</h2>
        <div class="post__author">
            <div class="post__author-avatar">
                <img src="./images/cat.jpg">
            </div>
            <div class="post_author-info">
                <h5>By: Quinton Khuwiseb</h5>
                <small>28 February 2024 - 19:23</small>
            </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="./images/akaza.jpg">
            </div>
            <p>
                        Akaza did not deserve to die because, beneath his monstrous exterior, he was a deeply tragic 
              figure shaped by pain, loss, and a desperate longing for strength born out of love and 
              helplessness. Before becoming a demon, Akaza was Hakuji—a young man who endured unbearable 
              suffering, losing his sick father and later his beloved fiancée, Koyuki, along with the life 
              he had built. His transformation into a demon was not born from malice but from grief and 
              despair, a result of circumstances that robbed him of everything he cared for.
            </p>
            <p>
                        Akaza did not deserve to die because, beneath his monstrous exterior, he was a deeply tragic 
              figure shaped by pain, loss, and a desperate longing for strength born out of love and 
              helplessness. Before becoming a demon, Akaza was Hakuji—a young man who endured unbearable 
              suffering, losing his sick father and later his beloved fiancée, Koyuki, along with the life 
              he had built. His transformation into a demon was not born from malice but from grief and 
              despair, a result of circumstances that robbed him of everything he cared for.
            </p>
            <p>
                        Akaza did not deserve to die because, beneath his monstrous exterior, he was a deeply tragic 
              figure shaped by pain, loss, and a desperate longing for strength born out of love and 
              helplessness. Before becoming a demon, Akaza was Hakuji—a young man who endured unbearable 
              suffering, losing his sick father and later his beloved fiancée, Koyuki, along with the life 
              he had built. His transformation into a demon was not born from malice but from grief and 
              despair, a result of circumstances that robbed him of everything he cared for.
            </p>
    </div>
</section>
<!--=======================End of Singlepost=============================-->


<?php
include 'partials/footer.php'
?>