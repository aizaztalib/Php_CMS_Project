<?php
include_once "includes/db.php"; 

function getPostById($connection, $post_id) {
    $query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function incrementPostViews($connection, $post_id) {
    $increment_views_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $increment_views_query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    return mysqli_stmt_execute($stmt);
}
function submitComment($connection, $post_id, $comment_author, $comment_email, $comment_content) {
    $query = "INSERT INTO comments (post_id, comment_author, comment_email, comment_content, comment_date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "isss", $post_id, $comment_author, $comment_email, $comment_content);
    return mysqli_stmt_execute($stmt);
}
function fetchComments($connection, $post_id) {
    $comment_query = "SELECT * FROM comments WHERE post_id = ? ORDER BY comment_date DESC";
    $stmt = mysqli_prepare($connection, $comment_query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function handleLike($connection, $post_id, $user_id) {
    
    $query = "SELECT likes FROM posts WHERE post_id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_array($result);

    if ($post) {
        $likes = $post['likes'] + 1; 
        $update_likes_query = "UPDATE posts SET likes=? WHERE post_id=?";
        $stmt = mysqli_prepare($connection, $update_likes_query);
        mysqli_stmt_bind_param($stmt, "ii", $likes, $post_id);
        mysqli_stmt_execute($stmt);
        $insert_like_query = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($connection, $insert_like_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $post_id);
        mysqli_stmt_execute($stmt);
    }
}
function handleUnlike($connection, $post_id, $user_id) {
  
    $query = "SELECT likes FROM posts WHERE post_id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_array($result);

    if ($post) {
        $likes = $post['likes'] - 1;
        $delete_like_query = "DELETE FROM likes WHERE post_id=? AND user_id=?";
        $stmt = mysqli_prepare($connection, $delete_like_query);
        mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
        mysqli_stmt_execute($stmt);
        $update_likes_query = "UPDATE posts SET likes=? WHERE post_id=?";
        $stmt = mysqli_prepare($connection, $update_likes_query);
        mysqli_stmt_bind_param($stmt, "ii", $likes, $post_id);
        mysqli_stmt_execute($stmt);
    }
}
function handle_logout() {
    session_unset(); 
    session_destroy(); 
    header("Location: includes/login.php"); 
    exit();
}
function display_welcome_message() {
    if (isset($_SESSION["username"])) {
        return "<h2>Welcome, " . htmlspecialchars($_SESSION["username"]) . "!</h2>" .
               '<a href="?action=logout" class="btn btn-danger">Logout</a>'; 
    } else {
        return "<h2>Welcome, Guest!</h2>";
    }
}
function get_pagination($per_page) {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "";
    }
    if ($page == "" || $page == 1) {
        $page_1 = 0;
    } else {
        $page_1 = ($page * $per_page) - $per_page;
    }
    return [$page_1, $page];
}
function fetch_posts($connection, $page_1, $per_page) {
    $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
    return mysqli_query($connection, $query);
}
function fetch_post_count($connection, $per_page) {
    $post_query_count = "SELECT * FROM posts";
    $find_count = mysqli_query($connection, $post_query_count);
    
    if ($find_count) {
        return ceil(mysqli_num_rows($find_count) / $per_page); 
    } else {
       
        return 0; 
    }
}
function generate_pagination_links($count, $current_page) {
    $output = "";
    for ($i = 1; $i <= $count; $i++) {
        $activeClass = ($i == $current_page) ? 'active' : ''; 
        $output .= "<li class='$activeClass'><a href='index.php?page=$i'>$i</a></li>";
    }
    return $output;
}
function searchPostsByTags($connection, $search) {
    $query = "SELECT * FROM posts WHERE post_tags LIKE ?";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        die("Preparation failed: " . mysqli_error($connection));
    }
    $search_param = "%$search%";
    mysqli_stmt_bind_param($stmt, "s", $search_param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC); 
}
?>
