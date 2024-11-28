<?php
include_once 'includes/header.php'; 
include_once 'includes/nav.php'; 

$connection = $db->get_connection();

if (isset($_GET['edit'])) {
    $post_id = intval($_GET['edit']);
    
    
    $post = fetch_post($connection, $post_id);
    if (!$post) {
        die("No post found.");
    }
}

if (isset($_POST['update'])) {
    $post_image = $_FILES['post_image']['name'] ? $_FILES['post_image']['name'] : $post['post_image'];
    
    
    if ($_FILES['post_image']['name']) {
        move_uploaded_file($_FILES['post_image']['tmp_name'], "../images/$post_image");
    }

    
    $post_data = [
        'post_user' => $_POST['post_user'],
        'post_title' => $_POST['post_title'],
        'post_image' => $post_image,
        'post_tags' => $_POST['post_tags'],
        'post_category_id' => $_POST['post_category_id'],
        'post_status' => $_POST['post_status'],
        'post_comment_count' => intval($_POST['post_comment_count']),
        'post_date' => $_POST['post_date']
    ];

    
    if (update_post($connection, $post_id, $post_data)) {
        echo "<script>alert('Post updated successfully.'); window.location.href='posts.php';</script>";
    } else {
        die("QUERY FAILED: " . mysqli_error($connection));
    }
}


$users = fetch_all_users($connection);
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Post</h1>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="users">Users</label>
                        <select name="post_user" class="form-control" required>
                            <?php 
                            $current_user_id = $post['post_user'];
                            foreach ($users as $user) {
                                $user_id = $user['user_id'];
                                $username = htmlspecialchars($user['username']);
                                $selected = ($user_id == $current_user_id) ? 'selected' : '';
                                echo "<option value='$user_id' $selected>$username</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input class="form-control" type="text" name="post_title" value="<?php echo htmlspecialchars($post['post_title']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="post_image">Image</label>
                        <input type="file" name="post_image">
                        <img src="../images/<?php echo htmlspecialchars($post['post_image']); ?>" style="width:100px;">
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Tags</label>
                        <input class="form-control" type="text" name="post_tags" value="<?php echo htmlspecialchars($post['post_tags']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="post_category_id">Category</label>
                        <input class="form-control" type="text" name="post_category_id" value="<?php echo htmlspecialchars($post['post_category_id']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="post_status">Status</label>
                        <input class="form-control" type="text" name="post_status" value="<?php echo htmlspecialchars($post['post_status']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="post_comment_count">Comments Count</label>
                        <input class="form-control" type="number" name="post_comment_count" value="<?php echo htmlspecialchars($post['post_comment_count']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="post_date">Date</label>
                        <input class="form-control" type="date" name="post_date" value="<?php echo htmlspecialchars($post['post_date']); ?>" required>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="update" value="Update Post">
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
