<?php
include_once 'includes/header.php';
include_once 'includes/nav.php';


$connection = $db->get_connection();

if (isset($_POST['create_user'])) { 
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']); 
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);

    
    $query = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role) 
              VALUES ('$user_firstname', '$user_lastname', '$username', '$user_email', '$user_password', '$user_role')";

    $create_user_query = mysqli_query($connection, $query);

    
    if (!$create_user_query) {
        echo "<div class='alert alert-danger'>QUERY FAILED: " . mysqli_error($connection) . "</div>";
    } else {
        echo "<script>
                window.location.href = 'view_all_users.php';
              </script>";
        exit; 
    }
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add User</h1>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="user_firstname">Firstname</label>
                        <input class="form-control" type="text" name="user_firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Lastname</label>
                        <input class="form-control" type="text" name="user_lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input class="form-control" type="email" name="user_email" required>
                    </div>

                    <div class="form-group">
                        <label for="user_password">Password</label>
                        <input class="form-control" type="password" name="user_password" required>
                    </div>

                    <div class="form-group">
                        <label for="user_role">Role</label>
                        <input class="form-control" type="text" name="user_role" required>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
