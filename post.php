<?php
include_once "includes/db.php";
include_once "includes/header.php";
include_once "functions2.php"; 


if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $connection = $db->get_connection();
    incrementPostViews($connection, $post_id);
    $select_post_query = getPostById($connection, $post_id);

    if (!$select_post_query) {
        die("QUERY FAILED: " . mysqli_error($connection));
    }
    $post = mysqli_fetch_assoc($select_post_query);
    if ($post) {
        $post_title = htmlspecialchars($post['post_title']);
        $post_author = htmlspecialchars($post['post_user']);
        $post_date = htmlspecialchars($post['post_date']);
        $post_image = htmlspecialchars($post['post_image']);
        $post_content = $post['post_content'];
        $post_views_count = htmlspecialchars($post['post_views_count']);
        $post_likes = htmlspecialchars($post['likes']);
    } else {
        echo "<h2>No post found</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid post ID</h2>";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
    $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
    $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
    $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']); 
    if (!submitComment($connection, $post_id, $comment_author, $comment_email, $comment_content)) {
        die("QUERY FAILED: " . mysqli_error($connection));
    } else {
        header("Location: post.php?id=$post_id");
        exit;
    }
}
if (isset($_POST['liked'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_POST['user_id']);
    handleLike($connection, $post_id, $user_id);
    exit();
}
if (isset($_POST['unliked'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_POST['user_id']);
    handleUnlike($connection, $post_id, $user_id);
    exit();
}
include_once "includes/nav.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1><?php echo $post_title; ?></h1>
            <p class="lead">by <a href="#"><?php echo $post_author; ?></a></p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <p><span class="glyphicon glyphicon-eye-open"></span> Views: <?php echo $post_views_count; ?></p>
            <p><span class="glyphicon glyphicon-thumbs-up"></span> Likes: <span id="like-count"><?php echo $post_likes; ?></span></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content; ?></p>
            <hr>
            <div class="row">
                <p class="pull-right"><a class="like" href="#" data-id="<?php echo $post_id; ?>"> <span class="glyphicon glyphicon-thumbs-up"></span> Like</a></p>
            </div>
            <div class="row">
                <p class="pull-right"><a class="unlike" href="#" data-id="<?php echo $post_id; ?>"> <span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a></p>
            </div>
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post">
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
            <div class="comments">
                <h4>Comments:</h4>
                <?php
                $select_comments_query = fetchComments($connection, $post_id);
                if (!$select_comments_query) {
                    die("QUERY FAILED: " . mysqli_error($connection));
                }
                if (mysqli_num_rows($select_comments_query) > 0) {
                    while ($comment = mysqli_fetch_assoc($select_comments_query)): ?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo htmlspecialchars($comment['comment_author']); ?>
                                    <small><?php echo htmlspecialchars($comment['comment_date']); ?></small>
                                </h4>
                                <?php echo htmlspecialchars($comment['comment_content']); ?>
                            </div>
                        </div>
                        <hr>
                    <?php endwhile;
                } else {
                    echo "<p>No comments yet.</p>";
                }
                ?>
            </div>
        </div>
        <?php include_once "includes/sidebar.php"; ?>
    </div>
</div>
<?php include "includes/footer.php"; ?>
<script>
    $(document).ready(function() {
        var post_id = <?php echo $post_id; ?>;
        var user_id = 21; 
        $('.like').click(function(e) {
            e.preventDefault(); 
            $.ajax({
                url: "/cms/post.php?id=<?php echo $post_id; ?>",
                type: 'POST',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                },
                success: function() {
                    
                    var currentLikes = parseInt($('#like-count').text());
                    $('#like-count').text(currentLikes + 1);
                }
            });
        });
        $('.unlike').click(function(e) {
            e.preventDefault(); 
            $.ajax({
                url: "/cms/post.php?id=<?php echo $post_id; ?>",
                type: 'POST',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                },
                success: function() {
                    var currentLikes = parseInt($('#like-count').text());
                    $('#like-count').text(currentLikes - 1);
                }
            });
        });
    });
</script>
