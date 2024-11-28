<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/nav.php'; ?>
<?php include_once 'functions.php'; ?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome To Dashboard
                    <small>Author</small>
                </h1>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response To</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Unapprove</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $connection = $db->get_connection();
                        $comments = fetch_comments($connection);

                        if (count($comments) > 0) {
                            foreach ($comments as $comment) {
                                render_comment_row($comment);
                            }
                        } else {
                            echo "<tr><td colspan='10'>No comments found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                
                handle_comment_action($connection);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
