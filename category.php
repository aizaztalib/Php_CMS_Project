<?php
include_once "includes/db.php"; 
include_once "includes/header.php";
?>

<?php include_once "includes/nav.php"; ?>

<div class="container">
    <div class="row">
        
        <div class="col-md-8">

            <h1 class="page-header">
                Posts in Category
                <small><?php echo htmlspecialchars($_GET['category']); ?></small>
            </h1>

            <?php
            if (isset($_GET['category'])) {
                $post_category_name = $_GET['category'];

                $connection = $db->get_connection(); 
                $query = "SELECT * FROM posts WHERE post_category = '$post_category_name'"; 
                $select_all_posts_query = mysqli_query($connection, $query);

                if (!$select_all_posts_query) {
                    die("Query Failed: " . mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title = htmlspecialchars($row['post_title']);
                    $post_author = htmlspecialchars($row['post_author']);
                    $post_date = htmlspecialchars($row['post_date']);
                    $post_image = htmlspecialchars($row['post_image']);
                    $post_content = htmlspecialchars($row['post_content']);
                    $post_id = $row['post_id'];
                    ?>
                    
                    <h2>
                        <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="#"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php 
                }
            } else {
                echo "<h2>No category selected</h2>";
            }
            ?>

            
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="post.php?id=<?php echo $post_id; ?>" method="post">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" name="comment_author" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="comment_email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="Comment">Your Comment</label>
                        <textarea class="form-control" name="comment_content" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr>
        </div>

        <?php include_once "includes/sidebar.php"; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
