<?php
include_once 'includes/header.php';
$connection = $db->get_connection();


function execute_query($connection, $query, $types = null, $params = []) {
    $stmt = mysqli_prepare($connection, $query);
    
    if ($types && !empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    return $stmt;
}

function redirect_to($location) {
    echo "<script type='text/javascript'>window.location.href='$location';</script>";
    exit();
}


function insert_categories($connection) {
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if (empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUES(?)";
            $stmt = execute_query($connection, $query, "s", [$cat_title]);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Category added successfully!";
                redirect_to('categories.php'); 
            } else {
                echo "Failed to add category.";
            }
        }
    }
}



function delete_categories($connection) {
    if (isset($_GET['delete'])) {
        $the_cat_id = intval($_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = ?";
        execute_query($connection, $query, "i", [$the_cat_id]);

        redirect_to('categories.php');
    }
}


function edit_categories($connection, &$cat_id, &$cat_title) {
    if (isset($_GET['edit'])) {
        $cat_id = intval($_GET['edit']);
        $query = "SELECT * FROM categories WHERE cat_id = ?";
        $result = execute_query($connection, $query, "i", [$cat_id]);
        $category = mysqli_fetch_assoc(mysqli_stmt_get_result($result));
        
        if ($category) {
            $cat_title = $category['cat_title'];
        } else {
            die("QUERY FAILED: " . mysqli_error($connection));
        }
    }
}


function update_categories($connection) {
    if (isset($_POST['update_category'])) {
        $cat_id = intval($_POST['cat_id']);
        $cat_title = $_POST['cat_title'];

        if (empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $update_query = "UPDATE categories SET cat_title = ? WHERE cat_id = ?";
            $stmt = execute_query($connection, $update_query, "si", [$cat_title, $cat_id]);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Category updated successfully!";
            } else {
                echo "No changes made.";
            }
            redirect_to('categories.php');
        }
    }
}

function handle_user_online($connection) {
   
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 5; 
    $time_out = $time - $time_out_in_seconds;

    
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    if (!$send_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    $count = mysqli_num_rows($send_query);

    if ($count === 0) {
        $insert_query = "INSERT INTO users_online(session, time) VALUES(?, ?)";
        execute_query($connection, $insert_query, "si", [$session, $time]);
    } else {
        $update_query = "UPDATE users_online SET time = ? WHERE session = ?";
        execute_query($connection, $update_query, "is", [$time, $session]);
    }

    return count_records($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
}



function count_records($connection, $query) {
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}


function render_panel($title, $count, $link, $icon, $panel_class) {
    echo "<div class='col-lg-3 col-md-6'>
            <div class='panel {$panel_class}'>
                <div class='panel-heading'>
                    <div class='row'>
                        <div class='col-xs-3'>
                            <i class='fa {$icon} fa-5x'></i>
                        </div>
                        <div class='col-xs-9 text-right'>
                            <div class='huge'>{$count}</div>
                            <div>{$title}</div>
                        </div>
                    </div>
                </div>
                <a href='{$link}'>
                    <div class='panel-footer'>
                        <span class='pull-left'>View Details</span>
                        <span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
                        <div class='clearfix'></div>
                    </div>
                </a>
            </div>
        </div>";
}


function fetch_users($connection) {
    $query = "SELECT * FROM users";
    $select_users = execute_query($connection, $query);
    return mysqli_fetch_all(mysqli_stmt_get_result($select_users), MYSQLI_ASSOC);
}

function render_user_row($user) {
    $user_id = $user['user_id'];
    $username = htmlspecialchars($user['username']);
    $user_firstname = htmlspecialchars($user['user_firstname']);
    $user_lastname = htmlspecialchars($user['user_lastname']);
    $user_email = htmlspecialchars($user['user_email']);
    $user_role = htmlspecialchars($user['user_role']);

    echo "<tr>";
    echo "<td>$user_id</td>";
    echo "<td>$username</td>";
    echo "<td>$user_firstname</td>";
    echo "<td>$user_lastname</td>";
    echo "<td>$user_email</td>";
    echo "<td>$user_role</td>";
    echo "<td>
            <a href='view_all_users.php?change_to_admin={$user_id}' class='btn btn-warning'>Admin</a>
            <a href='view_all_users.php?change_to_subscriber={$user_id}' class='btn btn-danger'>Subscriber</a>
            <a href='edit_user.php?edit={$user_id}' class='btn btn-info'>Edit</a>
            <a href='view_all_users.php?delete={$user_id}' class='btn btn-danger'>Delete</a>
          </td>";
    echo "</tr>";
}


function change_user_role($connection, $user_id, $role) {
    $query = "UPDATE users SET user_role = ? WHERE user_id = ?";
    execute_query($connection, $query, "si", [$role, $user_id]);
}


function delete_user($connection, $user_id) {
    $query = "DELETE FROM users WHERE user_id = ?";
    execute_query($connection, $query, "i", [$user_id]);
}


function handle_user_actions($connection) {
    if (isset($_GET['change_to_admin'])) {
        change_user_role($connection, intval($_GET['change_to_admin']), 'admin');
        redirect_to('view_all_users.php');
    }

    if (isset($_GET['change_to_subscriber'])) {
        change_user_role($connection, intval($_GET['change_to_subscriber']), 'subscriber');
        redirect_to('view_all_users.php');
    }

    if (isset($_GET['delete'])) {
        $user_id_to_delete = intval($_GET['delete']);
        echo "<script>
                if (confirm('Are you sure you want to delete this user?')) {
                    window.location.href='view_all_users.php?confirm_delete={$user_id_to_delete}';
                }
              </script>";
        exit();
    }

    if (isset($_GET['confirm_delete'])) {
        delete_user($connection, intval($_GET['confirm_delete']));
        redirect_to('view_all_users.php');
    }
}


function fetch_comments($connection) {
    $query = "SELECT comments.*, posts.post_title FROM comments JOIN posts ON comments.post_id = posts.post_id";
    $select_comments = mysqli_query($connection, $query);

    if (!$select_comments) {
        die("QUERY FAILED: " . mysqli_error($connection));
    }

    return mysqli_fetch_all($select_comments, MYSQLI_ASSOC);
}


function render_comment_row($comment) {
    $comment_id = $comment['comment_id'];
    $comment_author = htmlspecialchars($comment['comment_author']);
    $comment_content = htmlspecialchars($comment['comment_content']);
    $comment_email = htmlspecialchars($comment['comment_email']);
    $comment_status = htmlspecialchars($comment['comment_status']);
    $comment_date = htmlspecialchars($comment['comment_date']);
    $post_title = htmlspecialchars($comment['post_title']);
    $post_id = htmlspecialchars($comment['post_id']);

    echo "<tr>";
    echo "<td>$comment_id</td>";
    echo "<td>$comment_author</td>";
    echo "<td>$comment_content</td>";
    echo "<td>$comment_email</td>";
    echo "<td>$comment_status</td>";
    echo "<td>$post_title (ID: $post_id)</td>";
    echo "<td>$comment_date</td>";
    echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-warning'>Approve</a></td>";
    echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-danger'>Unapprove</a></td>";
    echo "<td><a href='comments.php?delete={$comment_id}' class='btn btn-danger'>Delete</a></td>";
    echo "</tr>";
}


function handle_comment_action($connection) {
    if (isset($_GET['approve'])) {
        update_comment_status($connection, $_GET['approve'], 'approved');
    }

    if (isset($_GET['unapprove'])) {
        update_comment_status($connection, $_GET['unapprove'], 'unapproved');
    }

    if (isset($_GET['delete'])) {
        delete_comment($connection, $_GET['delete']);
    }
}


function update_comment_status($connection, $comment_id, $status) {
    $query = "UPDATE comments SET comment_status = ? WHERE comment_id = ?";
    execute_query($connection, $query, "si", [$status, $comment_id]);
    redirect_to('comments.php');
}


function delete_comment($connection, $comment_id) {
    $delete_query = "DELETE FROM comments WHERE comment_id = ?";
    execute_query($connection, $delete_query, "i", [$comment_id]);
    redirect_to('comments.php');
}


function fetch_user($connection, $user_id) {
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = execute_query($connection, $query, "i", [$user_id]);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}


function update_user($connection, $user_id, $user_firstname, $user_lastname, $username, $user_email, $user_password) {
    $query = "UPDATE users SET user_firstname = ?, user_lastname = ?, username = ?, user_email = ?, user_password = ? WHERE user_id = ?";
    $stmt = execute_query($connection, $query, "sssssi", [$user_firstname, $user_lastname, $username, $user_email, $user_password, $user_id]);
    return mysqli_stmt_affected_rows($stmt) > 0;
}


function validate_and_escape_user_input($connection) {
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
    
    return [$user_firstname, $user_lastname, $username, $user_email, $user_password];
}




function fetch_post($connection, $post_id) {
    $query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = execute_query($connection, $query, "i", [$post_id]);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}


function update_post($connection, $post_id, $post_data) {
    $query = "UPDATE posts SET post_user = ?, post_title = ?, post_image = ?, post_tags = ?, post_category_id = ?, post_status = ?, post_comment_count = ?, post_date = ? WHERE post_id = ?";
    $stmt = execute_query($connection, $query, "ssssssisi", [
        $post_data['post_user'],
        $post_data['post_title'],
        $post_data['post_image'],
        $post_data['post_tags'],
        $post_data['post_category_id'],
        $post_data['post_status'],
        $post_data['post_comment_count'],
        $post_data['post_date'],
        $post_id
    ]);
    return mysqli_stmt_affected_rows($stmt) > 0;
}


function fetch_all_users($connection) {
    $query = "SELECT * FROM users";
    $select_users = execute_query($connection, $query);
    return mysqli_fetch_all(mysqli_stmt_get_result($select_users), MYSQLI_ASSOC);
}



?>
