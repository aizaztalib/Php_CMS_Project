<?php
ob_start();

include_once 'includes/header.php'; 
include_once 'includes/nav.php'; 

$connection = $db->get_connection();

if (isset($_GET['edit'])) {
    $user_id = intval($_GET['edit']);
    $user = fetch_user($connection, $user_id);
    
    if (!$user) {
        die("User not found.");
    }
}

if (isset($_POST['submit'])) {
    list($user_firstname, $user_lastname, $username, $user_email, $user_password) = validate_and_escape_user_input($connection);

    
    if (empty($user_password)) {
        $user_password = $user['user_password']; 
    }

    if (update_user($connection, $user_id, $user_firstname, $user_lastname, $username, $user_email, $user_password)) {
        echo "<script>window.location.href = 'view_all_users.php';</script>";
    } else {
        die("QUERY FAILED: " . mysqli_error($connection));
    }
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit User</h1>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="user_firstname">Firstname</label>
                        <input class="form-control" type="text" name="user_firstname" value="<?php echo htmlspecialchars($user['user_firstname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Lastname</label>
                        <input class="form-control" type="text" name="user_lastname" value="<?php echo htmlspecialchars($user['user_lastname']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input class="form-control" type="email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_password">Password</label>
                        <input class="form-control" type="password" name="user_password" placeholder="Leave blank to keep current password">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update User">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
include_once 'includes/footer.php';
?>
