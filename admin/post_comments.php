<?php
include_once 'includes/header.php';
include_once 'includes/nav.php';


if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    
    $connection = $db->get_connection();

    
    $query = "SELECT comments.*, posts.post_title 
              FROM comments 
              JOIN posts ON comments.post_id = posts.post_id 
              WHERE posts.post_id = ?";
    $stmt = execute_query($connection, $query, "i", [$post_id]);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("QUERY FAILED: " . mysqli_error($connection));
    }
    ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments for Post ID: <?php echo $post_id; ?>
                    </h1>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($comment = mysqli_fetch_assoc($result)) {
                                render_comment_row($comment);
                            }
                        } else {
                            echo "<tr><td colspan='9'>No comments found for this post.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    echo "<div class='alert alert-danger'>No post ID provided.</div>";
}

include_once 'includes/footer.php';
