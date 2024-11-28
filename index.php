<?php
session_start();
include_once "includes/db.php";
include_once "includes/header.php";
include_once "functions2.php"; 


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    handle_logout(); 
}

include_once "includes/nav.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <?php
            
            echo display_welcome_message();

            $per_page = 5;
            list($page_1, $page) = get_pagination($per_page);

            $connection = $db->get_connection();
            $count = fetch_post_count($connection, $per_page);
            $select_all_posts_query = fetch_posts($connection, $page_1, $per_page);

            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = htmlspecialchars($row['post_title']);
                $post_author = htmlspecialchars($row['post_user']);
                $post_date = htmlspecialchars($row['post_date']);
                $post_image = htmlspecialchars($row['post_image']);
                $post_content = $row['post_content'];
                $post_id = $row['post_id'];
            ?>
                <h2>
                    <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <h3>Post Content:</h3>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php } ?>

            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>
        </div>

        <?php include_once "includes/sidebar.php"; ?>
    </div>
</div>

<ul class="pager">
    <?php
    echo generate_pagination_links($count, $page);
    ?>
</ul>

<?php include "includes/footer.php"; ?>
