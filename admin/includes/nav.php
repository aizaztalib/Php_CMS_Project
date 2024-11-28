<?php
global $count_user; 
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS Admin</a>
    </div>
    <ul class="nav navbar-right top-nav">
        <li><a href="../index.php">Users Online: <span id="online-user-count"><?php echo isset($count_user) ? htmlspecialchars($count_user) : 0; ?></span></a></li>
        <li><a href="../index.php">Home Site</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu message-dropdown">
                <li class="message-preview"><a href="#">
                        <div class="media"><span class="pull-left"><img class="media-object" src="http://placehold.it/50x50" alt=""></span>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Smith</strong></h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet...</p>
                            </div>
                        </div>
                    </a></li>
                <li class="divider"></li>
                <li class="message-footer"><a href="#">Read All New Messages</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li><a href="#">Alert Name <span class="label label-default">Alert Badge</span></a></li>
                <li class="divider"></li>
                <li><a href="#">View All</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                <?php
                if (isset($_SESSION["username"])) {
                    echo htmlspecialchars($_SESSION["username"]); 
                } else {
                    echo "Guest";
                }
                ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a></li>
                <li><a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
            </ul>
        </li>
    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li><a href="./posts.php">View All Posts</a></li>
                    <li><a href="add_post.php">Add Posts</a></li>
                </ul>
            </li>
            <li><a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a></li>
            <li><a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments</a></li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li><a href="view_all_users.php">View All Users</a></li>
                    <li><a href="add_users.php">Add Users</a></li>
                </ul>
            </li>
            <li><a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a></li>
        </ul>
    </div>
</nav>
