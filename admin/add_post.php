<?php
include_once 'includes/header.php';
include_once 'includes/nav.php';

$connection = $db->get_connection();

if (isset($_POST['submit'])) {
    $post_user = mysqli_real_escape_string($connection, $_POST['post_user']);
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $post_image = $_FILES['post_image']['name'];
    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_category_id = (int)$_POST['post_category_id'];
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
    $post_comment_count = (int)$_POST['post_comment_count'];
    $post_date = mysqli_real_escape_string($connection, $_POST['post_date']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);

    
    if (!move_uploaded_file($_FILES['post_image']['tmp_name'], "../images/$post_image")) {
        die("Failed to upload image.");
    }

    
    $query = "INSERT INTO posts (post_user, post_title, post_image, post_tags, post_category_id, post_status, post_comment_count, post_date, post_content) 
              VALUES ('$post_user', '$post_title', '$post_image', '$post_tags', $post_category_id, '$post_status', $post_comment_count, '$post_date', '$post_content')";

    $create_post_query = mysqli_query($connection, $query);

    
    if (!$create_post_query) {
        die("QUERY FAILED: " . mysqli_error($connection));
    } else {
        echo "<script>window.location.href = 'posts.php';</script>";
        exit; 
    }
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add Post</h1>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="users">Users</label>
                        <select name="post_user" id="" class="form-control" required>
                            <?php 
                            $query = "SELECT * FROM users";
                            $select_users = mysqli_query($connection, $query);
                            
                            while($row = mysqli_fetch_array($select_users)){
                                $user_id = $row['user_id'];
                                $username = htmlspecialchars($row['username']);
                                echo "<option value='$username'>$username</option>"; 
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input class="form-control" type="text" name="post_title" required>
                    </div>

                    <div class="form-group">
                        <label for="post_image">Image</label>
                        <input type="file" name="post_image" required>
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Tags</label>
                        <input class="form-control" type="text" name="post_tags" required>
                    </div>

                    <div class="form-group">
                        <label for="post_category_id">Category</label>
                        <input class="form-control" type="number" name="post_category_id" required>
                    </div>

                    <div class="form-group">
                        <label for="post_status">Status</label>
                        <input class="form-control" type="text" name="post_status" required>
                    </div>

                    <div class="form-group">
                        <label for="post_comment_count">Comments Count</label>
                        <input class="form-control" type="number" name="post_comment_count" value="0" required>
                    </div>

                    <div class="form-group">
                        <label for="post_date">Date</label>
                        <input class="form-control" type="date" name="post_date" required>
                    </div>

                    <div class="form-group">
                        <label for="post_content">Post Content</label>
                        <textarea class="form-control" id="summernote" name="post_content" cols="30" rows="10" required></textarea>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Publish Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
