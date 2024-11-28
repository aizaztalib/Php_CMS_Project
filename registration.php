<?php include_once "./includes/db.php"; ?>
<?php include_once "./includes/header.php"; 
$connection = $db->get_connection(); 
?>

<?php 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $username = mysqli_escape_string($connection, $username);
    $email = mysqli_escape_string($connection, $email);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, user_password, user_email, user_role) VALUES ('{$username}', '{$hashed_password}', '{$email}', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    if (!$register_user_query) {
        die("QUERY FAILED" . mysqli_error($connection) . '' . mysqli_errno($connection));
    } else {
        echo "<p>Registration successful!</p>";
    }
}
?>

<?php include_once "./includes/nav.php"; ?>

<div class="container">
    <section id="registration">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                    <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="registration-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
                        <input type="submit" name="submit" id="btn-register" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                </div>
            </div> 
        </div>
    </section>
</div>

<?php include_once "./includes/footer.php"; ?>
