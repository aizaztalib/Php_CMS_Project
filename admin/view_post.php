<?php
include_once '../includes/db.php'; 
include_once '../includes/header.php'; 
include_once '../includes/nav.php'; 

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); 

    $connection = $db->get_connection();

    
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
        
        ?>
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <?php
                    
                    $post_title = htmlspecialchars($post['post_title']);
                    $post_author = htmlspecialchars($post['post_author']);
                    $post_date = htmlspecialchars($post['post_date']);
                    $post_image = htmlspecialchars($post['post_image']);
                    $post_content = htmlspecialchars($post['post_content']);
                    ?>
                    
                
                    <h2>
                        <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="#"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="../images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                </div>
            </div> 
        </div> 
        
        <?php
    } else {
        echo "<p>Post not found.</p>";
    }
} else {
    echo "<p>No post ID provided.</p>";
}

include_once '../includes/footer.php'; 
?>
