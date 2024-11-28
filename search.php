<?php
include_once "includes/db.php"; 
include_once "functions2.php"; 
include_once "includes/header.php";
include_once "includes/nav.php";
?>

<div class="container">
    <div class="row">
       
        <div class="col-md-8">

            <?php
            $searched_posts = []; 
            $searched_titles = []; 
            if (isset($_POST['submit'])) {
                $search = htmlspecialchars($_POST['search']);
                $connection = $db->get_connection();
                $searched_posts = searchPostsByTags($connection, $search);
                foreach ($searched_posts as $post) {
                    $searched_titles[] = $post['post_title'];
                }
                if (!empty($searched_posts)) {
                    foreach ($searched_posts as $post) {
                        ?>
                        <h2><a href="#"><?php echo $post['post_title']; ?></a></h2>
                        <p class="lead">by <a href="#"><?php echo $post['post_author']; ?></a></p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post['post_date']; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post['post_image']; ?>" alt="">
                        <hr>
                        <p><?php echo $post['post_content']; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                        <?php
                    }
                } else {
                    echo "<h2>No Results Found for '$search'</h2>";
                }
            } else {
                echo "<h2>Please enter a search term.</h2>";
            }
            $query = "SELECT * FROM posts";
            $all_posts_query = mysqli_query($connection, $query);
            $all_posts = mysqli_fetch_all($all_posts_query, MYSQLI_ASSOC); 

            foreach ($all_posts as $post) {
                if (in_array($post['post_title'], $searched_titles)) {
                    continue; 
                }
                ?>
                <h2><a href="#"><?php echo $post['post_title']; ?></a></h2>
                <p class="lead">by <a href="#"><?php echo $post['post_author']; ?></a></p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post['post_image']; ?>" alt="">
                <hr>
                <p><?php echo $post['post_content']; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php
            }
            ?>

            <ul class="pager">
                <li class="previous"><a href="#">&larr; Older</a></li>
                <li class="next"><a href="#">Newer &rarr;</a></li>
            </ul>
        </div>

        <?php include "includes/sidebar.php"; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
