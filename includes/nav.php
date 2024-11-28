<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">Start Bootstrap</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $connection = $db->get_connection(); 
                $query = "SELECT cat_title FROM categories"; 
                $select_all_categories_query = mysqli_query($connection, $query);
                $categories = mysqli_fetch_all($select_all_categories_query, MYSQLI_ASSOC);
                foreach ($categories as $category) {
                    $cat_title = htmlspecialchars($category['cat_title']);
                    echo "<li><a href='#'>{$cat_title}</a></li>";
                }
                ?>
                <li><a href="/cms/admin/index.php">Admin</a></li> 
                <li><a href="/cms/registration.php">Register</a></li>
                <li><a href="/cms/contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
