<?php
include 'partials/header.php';

//fetch featured post from database
$featured_query = "SELECT *FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

?>



	<?php if(mysqli_num_rows($featured_result) ==1) : ?>
      <!--=======================Begining of Featured post=================-->

      <section class="featured">
        <div class="container featured__container">
          <div class="post__thumbnail">
            <img src="./images/<?= $featured['thumbnail'] ?>" >
          </div>
          <div class="post__info">
		  <?php
			//fetch cats
			$category_id = $featured['category_id'];
			$category_query = "SELECT * FROM categories WHERE id=$category_id";
			$category_result = mysqli_query($connection, $category_query);
			$category = mysqli_fetch_assoc($category_result);
		  
		  ?>
            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title']?></a>
            <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
            <p class="post__body">
              <?= substr($featured['body'], 0, 300) ?>....
            </p>
            <div class="post__author">
              <div class="post__author-avatar">
                <img src="./images/cat.jpg">
              </div>
              <div class="post_author-info">
                <h5>By: Quinton Khuwiseb</h5>
                <small>28 February 2024 - 19:23</small>
              </div>
            </div>
          </div>
        </div>
      </section>
	  <?php endif ?>
          <!--=======================End of featured post=============================-->

  <section class="posts">
    <div class="container posts__container">
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/akaza.jpg">
        </div>
        <div class="post__info">
          <a href="category-post.html" class="category__button">MCU</a>
          <h3 class="post__title">
            <a href="post.html">rughlerkgjoierdgjoiordj</a>
          </h3>
          <p class="post__body">
            rueijfeoirdjgpoeidsjviopedskjgvpoiedskjv
            ioedskljvoiedskljzvoipesdkl;jzvoid 
          </p>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="./images/sista.jpg">
            </div>
            <div class="post_author-info">
                  <h5>By: Quinton Khuwiseb</h5>
                  <small>19 August 2024 - 19:23</small>
                </div>
            

            </div>
          </div>
        </article>
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/akaza.jpg">
        </div>
        <div class="post__info">
          <a href="category-post.html" class="category__button">MCU</a>
          <h3 class="post__title">
            <a href="post.html">rughlerkgjoierdgjoiordj</a>
          </h3>
          <p class="post__body">
            rueijfeoirdjgpoeidsjviopedskjgvpoiedskjv
            ioedskljvoiedskljzvoipesdkl;jzvoid 
          </p>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="./images/sista.jpg">
            </div>
            <div class="post_author-info">
                  <h5>By: Quinton Khuwiseb</h5>
                  <small>19 August 2024 - 19:23</small>
                </div>
            

            </div>
          </div>
        </article>
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/akaza.jpg">
        </div>
        <div class="post__info">
          <a href="" class="category__button">MCU</a>
          <h3 class="post__title">
            <a href="post.html">rughlerkgjoierdgjoiordj</a>
          </h3>
          <p class="post__body">
            rueijfeoirdjgpoeidsjviopedskjgvpoiedskjv
            ioedskljvoiedskljzvoipesdkl;jzvoid 
          </p>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="./images/sista.jpg">
            </div>
            <div class="post_author-info">
                  <h5>By: Quinton Khuwiseb</h5>
                  <small>19 August 2024 - 19:23</small>
                </div>
            

            

            

            </div>
          </div>
        </article>
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/akaza.jpg">
        </div>
        <div class="post__info">
          <a href="" class="category__button">MCU</a>
          <h3 class="post__title">
            <a href="post.html">rughlerkgjoierdgjoiordj</a>
          </h3>
          <p class="post__body">
            rueijfeoirdjgpoeidsjviopedskjgvpoiedskjv
            ioedskljvoiedskljzvoipesdkl;jzvoid 
          </p>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="./images/sista.jpg">
            </div>
            <div class="post_author-info">
                  <h5>By: Quinton Khuwiseb</h5>
                  <small>19 August 2024 - 19:23</small>
                </div>
            

            </div>
          </div>
        </article>
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/akaza.jpg">
        </div>
        <div class="post__info">
          <a href="" class="category__button">MCU</a>
          <h3 class="post__title">
            <a href="post.html">rughlerkgjoierdgjoiordj</a>
          </h3>
          <p class="post__body">
            rueijfeoirdjgpoeidsjviopedskjgvpoiedskjv
            ioedskljvoiedskljzvoipesdkl;jzvoid 
          </p>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="./images/sista.jpg">
            </div>
            <div class="post_author-info">
                  <h5>By: Quinton Khuwiseb</h5>
                  <small>19 August 2024 - 19:23</small>
                </div>
            

            </div>
          </div>
        </article>
    </div>
  </section>
  <!--==================end of general post======================-->


  <section class="category__buttons">
    <div class="container category__buttons-container">
      <a href="" class="category__button">Anime</a>
      <a href="" class="category__button">Marvel</a>
    </div>
  </section>

<!--================end of category buttons-->



<?php
include 'partials/footer.php';
?>