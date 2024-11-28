<?php
include_once 'includes/header.php';
include_once 'includes/nav.php';

$connection = $db->get_connection();

if (isset($_GET['delete'])) {
    $post_id = intval($_GET['delete']); 
    $query = "DELETE FROM posts WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    
   
    
    mysqli_stmt_close($stmt);
}

if (isset($_POST['apply'])) {
    $bulk_option = $_POST['bulk_options'];

    if ($bulk_option == 'clone' && !empty($_POST['post_ids'])) {
        foreach ($_POST['post_ids'] as $post_id) {
            $post_id = intval($post_id);
            
            $query = "SELECT * FROM posts WHERE post_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $post_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $post = mysqli_fetch_assoc($result);

            if ($post) {
                
                $clone_query = "INSERT INTO posts (post_title, post_content, post_user, post_image, post_date, post_views_count) VALUES (?, ?, ?, ?, NOW(), ?)";
                $clone_stmt = mysqli_prepare($connection, $clone_query);
                mysqli_stmt_bind_param($clone_stmt, "ssssi", $post['post_title'], $post['post_content'], $post['post_user'], $post['post_image'], $post['post_views_count']);
                mysqli_stmt_execute($clone_stmt);
                
               

                mysqli_stmt_close($clone_stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Posts</h1>

                
                <form method="post">
                    <select class="form-control" name="bulk_options" id="bulk_options">
                        <option value="">Select Options</option>
                        <option value="clone">Clone</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" name="apply" class="btn btn-success">Apply</button>
                    <br><br>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select_all"> Select</th>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Username</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Content</th>
                                <th>Comments</th>
                                <th>Views</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                            $query = "SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.post_user = users.user_id"; 
                            $select_posts = mysqli_query($connection, $query);

                            if (!$select_posts) {
                                die("QUERY FAILED: " . mysqli_error($connection));
                            }

                            while ($row = mysqli_fetch_assoc($select_posts)) {
                                $post_id = $row['post_id'];
                                $post_title = htmlspecialchars($row['post_title']);
                                $username = htmlspecialchars($row['username']);
                                $post_date = htmlspecialchars($row['post_date']);
                                $post_image = htmlspecialchars($row['post_image']);
                                $post_content = $row['post_content'];
                                $post_views_count = htmlspecialchars($row['post_views_count']);

                              
                                $comment_count_query = "SELECT COUNT(*) as count FROM comments WHERE post_id = $post_id";
                                $comment_count_result = mysqli_query($connection, $comment_count_query);
                                $comment_count = mysqli_fetch_assoc($comment_count_result)['count'];

                                echo "<tr>";
                                echo "<td><input type='checkbox' name='post_ids[]' value='$post_id'></td>";
                                echo "<td>$post_id</td>"; 
                                echo "<td>$post_title</td>";
                                echo "<td>" . (!empty($username) ? $username : 'N/A') . "</td>";
                                echo "<td>$post_date</td>";
                                echo "<td><img src='../images/$post_image' alt='$post_title' style='width: 100px;'></td>";
                                echo "<td>$post_content</td>";
                                echo "<td><a href='post_comments.php?id=$post_id'>$comment_count</a></td>";
                                echo "<td><a href='posts.php?reset=$post_id'>$post_views_count</a></td>";
                                echo "<td><a href='view_post.php?id=$post_id' class='btn btn-info'>View</a></td>";
                                echo "<td><a href='edit_post.php?edit=$post_id' class='btn btn-primary'>Edit</a></td>";
                                echo "<td><a href='posts.php?delete=$post_id' class='btn btn-danger'>Delete</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   
    document.getElementById('select_all').onclick = function() {
        var checkboxes = document.getElementsByName('post_ids[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    };
</script>

<?php include_once 'includes/footer.php'; ?>
