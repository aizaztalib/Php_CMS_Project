<?php
include_once 'includes/header.php';
include_once 'includes/nav.php';

$connection = $db->get_connection(); 


$cat_title = '';
$cat_id = 0;


insert_categories($connection);
delete_categories($connection);
edit_categories($connection, $cat_id, $cat_title);
update_categories($connection);

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome To Dashboard
                    <small>Author</small>
                </h1>

                <div class="col-xs-6">
                    <form action="" method="post">
                        <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>"> 
                        <div class="form-group">
                            <input class="form-control" type="text" name="cat_title" value="<?php echo htmlspecialchars($cat_title); ?>" placeholder="Category Title" required>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="<?php echo $cat_id ? 'update_category' : 'submit'; ?>" value="<?php echo $cat_id ? 'Update Category' : 'Add Category'; ?>">
                        </div>
                    </form>
                </div>

                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Title</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM categories";
                            $select_categories = mysqli_query($connection, $query);
                            $categories = mysqli_fetch_all($select_categories, MYSQLI_ASSOC);

                            $counter = 1;
                            foreach ($categories as $category) {
                                echo "<tr>";
                                echo "<td>{$counter}</td>";
                                echo "<td>" . htmlspecialchars($category['cat_title']) . "</td>";
                                echo "<td><a href='categories.php?delete=" . intval($category['cat_id']) . "'>Delete</a></td>";
                                echo "<td><a href='categories.php?edit=" . intval($category['cat_id']) . "'>Edit</a></td>";
                                echo "</tr>";
                                $counter++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    
</div>


<?php include_once 'includes/footer.php'; ?>
