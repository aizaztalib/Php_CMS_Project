<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/nav.php'; ?>
<?php

if (isset($_SESSION['username'])) {
    $session_username = $_SESSION['username'];
    $connection = $db->get_connection();
    $query = "SELECT * FROM users WHERE username = '{$session_username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    
  
    if (mysqli_num_rows($select_user_profile_query) > 0) {
        $row = mysqli_fetch_assoc($select_user_profile_query);
        
        $user_id = $row['user_id'];
        $user_firstname = htmlspecialchars($row['user_firstname']);
        $user_lastname = htmlspecialchars($row['user_lastname']);
        $username = htmlspecialchars($row['username']);
        $user_email = htmlspecialchars($row['user_email']);
        $user_password = htmlspecialchars($row['user_password']);
        $user_role = htmlspecialchars($row['user_role']);
    } else {
        die("No user found.");
    }
}
?>

<?php
if (isset($_POST['submit'])) {
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);


    $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', username = '{$username}', user_email = '{$user_email}', user_password = '{$user_password}', user_role = '{$user_role}' WHERE user_id = {$user_id}";

    $update_query = mysqli_query($connection, $query);

    if (!$update_query) {
        die("QUERY FAILED: " . mysqli_error($connection));
    } else {
        echo "<script>window.location.href = 'view_all_users.php';</script>";
    }
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome To Dashboard
                    <small><?php echo $_SESSION["username"]; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a></li>
                    <li class="active"><i class="fa fa-file"></i> Edit Profile</li>
                </ol>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="user_firstname">Firstname</label>
                        <input class="form-control" type="text" name="user_firstname" value="<?php echo isset($user_firstname) ? htmlspecialchars($user_firstname) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Lastname</label>
                        <input class="form-control" type="text" name="user_lastname" value="<?php echo isset($user_lastname) ? htmlspecialchars($user_lastname) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input class="form-control" type="email" name="user_email" value="<?php echo isset($user_email) ? htmlspecialchars($user_email) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_password">Password</label>
                        <input class="form-control" type="password" name="user_password" value="<?php echo isset($user_password) ? htmlspecialchars($user_password) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_role">User Role</label>
                        <input class="form-control" type="text" name="user_role" value="<?php echo isset($user_role) ? htmlspecialchars($user_role) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update Profile">
                    </div>
                </form>

            </div>
        </div>
   
    </div>

</div>


<?php include_once 'includes/footer.php'; ?>
