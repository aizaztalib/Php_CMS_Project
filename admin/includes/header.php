<?php
session_start();
include_once "../includes/db.php";
include_once "../admin/functions.php";
?>


<?php

if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<?php
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit; 
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Bootstrap Admin Template</title>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <div id="wrapper">