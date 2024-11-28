<?php
session_start(); 
include_once "../includes/db.php"; 

if (isset($_POST['username']) && isset($_POST['user_password'])) {
    $data = (object) $_POST;

   
    $connection = $db->get_connection(); 
    $sql = "SELECT * FROM `users` WHERE username = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $data->username);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
    
    
    if ($results) {
        if ($row = mysqli_fetch_array($results)) {
            
            if (password_verify($data->user_password, $row['user_password'])) {
                
                $_SESSION["username"] = $row["username"];
                $_SESSION["user_role"] = $row["user_role"];

                
                echo '<script type="text/javascript">window.location.replace("../admin/index.php");</script>';
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "User does not exist!";
        }
    } else {
        echo "Query failed: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        body {
    background-color: #f8f9fa; 
    font-family: 'Arial', sans-serif; 
}

.container {
    max-width: 400px; 
    margin: 100px auto; 
    padding: 20px; 
    background-color: #fff; 
    border-radius: 8px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
}

h2 {
    text-align: center; 
    margin-bottom: 20px; 
    color: #333; 
}

.form-group {
    
    margin-bottom: 15px; 
}

input{
    width: 94%; 
    padding: 10px;
}
.form-control {

    border-radius: 5px; 
    border: 1px solid #ccc; 
    padding: 10px; 
}

.form-control:focus {
    border-color: #007bff; 
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
}

.btn {
    width: 100%; 
    padding: 10px; 
    border-radius: 5px; 
    font-weight: bold; 
}

.btn-primary {
    background-color: #007bff; 
    border: none; 
}

.btn-primary:hover {
    background-color: #0056b3; 
    transition: background-color 0.3s ease; 
}

    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="" method="post">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <input name="user_password" type="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button class="btn btn-primary" name="login" type="submit">Login</button>
    </form>
</div>
</body>
</html>
