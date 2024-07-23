<?php
session_name('user');
require_once 'uaincludes/auconfig_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:login');
}

if (isset($_POST['update_addons'])) {

    $addons = $_POST['addons'];
    $_SESSION['addons'] = $addons;

}

if (isset($_POST['update_addonsOff'])) {

    $addons = $_POST['addonsOFF'];
    $_SESSION['addons'] = $addons;

}

if (!isset($_SESSION['addons'])) {

    $_SESSION['addons'] = '';
}

if ($_SESSION['addons'] == 'ON') {

    $addons = $_SESSION['addons'];

} else {

    $addons = '';

}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .bodybg {
            background-image: url("assets/img/chaks bg2.jpg");
        }
    </style>

</head>

<body class="bodybg">
    <?php include('fnavbar.php'); ?>

    <div class="container-xl bg-white" style="padding-top: 150px">

        <div class="row my-5">

            <h1><?php echo $_SESSION['tableNo']; ?></h1>
            <h1><?php echo $addons; ?></h1>


            <img src="assets/img/gift.jpg" alt="" width="100%">
            <a type="button" href="menu/pork" class="btn btn-danger">Menu</a>

        </div>


        <div class="row bg-white my-5">
            <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
        </div>

    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>

    </script>

</body>

</html>