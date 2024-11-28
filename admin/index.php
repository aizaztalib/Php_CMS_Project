<?php 

include_once 'includes/header.php'; 
include_once 'functions.php'; 
$connection = $db->get_connection();


$count_user = handle_user_online($connection);


include_once 'includes/nav.php'; 
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome To Dashboard
                    <small><?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : 'Guest'; ?></small>
                </h1>
                
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a></li>
                    <li class="active"><i class="fa fa-file"></i> Blank Page</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <?php
           
            $post_count = count_records($connection, "SELECT * FROM posts");
            $comments_count = count_records($connection, "SELECT * FROM comments");
            $users_count = count_records($connection, "SELECT * FROM users");
            $categories_count = count_records($connection, "SELECT * FROM categories");
            $post_published_count = count_records($connection, "SELECT * FROM posts WHERE post_status = 'published'");
            $post_draft_count = count_records($connection, "SELECT * FROM posts WHERE post_status = 'draft'");
            $unapproved_comment_count = count_records($connection, "SELECT * FROM comments WHERE comment_status = 'unapproved'");
            ?>

            <?php render_panel('Posts', $post_count, 'posts.php', 'fa-file-text', 'panel-primary'); ?>
            <?php render_panel('Comments', $comments_count, 'comments.php', 'fa-comments', 'panel-green'); ?>
            <?php render_panel('Users', $users_count, 'view_all_users.php', 'fa-user', 'panel-yellow'); ?>
            <?php render_panel('Categories', $categories_count, 'categories.php', 'fa-list', 'panel-red'); ?>
        </div>

        <div class="row">
            <script type="text/javascript">
                google.charts.load('current', { 'packages': ['bar'] });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],
                        <?php
                        $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Unapproved Comments', 'Comments', 'Users', 'Categories'];
                        $element_count = [$post_count, $post_published_count, $post_draft_count, $unapproved_comment_count, $comments_count, $users_count, $categories_count];

                        foreach ($element_text as $index => $text) {
                            echo "['$text', {$element_count[$index]}],";
                        }
                        ?>
                    ]);

                    var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            </script>

            <div id="columnchart_material" style="width: auto; height: 500px;"></div>
        </div>
    </div>
 
</div>


<?php include_once 'includes/footer.php'; ?>
