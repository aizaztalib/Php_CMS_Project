
<div class="col-md-4">

    
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

    

   
    <div class="well">
        <?php
        $connection = $db->get_connection();
        $query = "SELECT DISTINCT post_category FROM posts"; 
        $select_categories_sidebar = mysqli_query($connection, $query);

        if (!$select_categories_sidebar) {
            die("Query Failed: " . mysqli_error($connection));
        }

       
        $categories = mysqli_fetch_all($select_categories_sidebar, MYSQLI_ASSOC);
        ?>

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    foreach ($categories as $category) {
                        $cat_title = htmlspecialchars($category['post_category']);
                        echo "<li><a href='category.php?category={$cat_title}'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
    </div>
</div>
