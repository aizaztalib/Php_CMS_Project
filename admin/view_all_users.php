<?php
ob_start();
include_once 'includes/header.php';
include_once 'includes/nav.php';

handle_user_actions($connection); 

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Dashboard
                    <small>Admin</small>
                </h1>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = fetch_users($connection);
                        foreach ($users as $user) {
                            render_user_row($user);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush(); 
include_once 'includes/footer.php';
?>
