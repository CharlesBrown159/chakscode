<?php

require_once '../includes/config_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:../index');
}

if ($_SESSION['approval'] != "APPROVED") {
    echo "<script>alert('Your account needs to be approved by the admin.')</script>";

    session_unset();
    session_destroy();
    error_reporting(0);
?>
    <meta http-equiv="refresh" content="0;URL='../index'" />
<?php
    die();
}

if ($_SESSION['userlevel'] != "kitchen") {

    echo "<script>alert('Your account is not for kitchen.')</script>";

    session_unset();
    session_destroy();
    error_reporting(0);

?>
    <meta http-equiv="refresh" content="0;URL='../index'" />
<?php
    die();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Kitchen Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/image/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/adminstyle.css">


</head>

<body>

    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard">
                <img src="../assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Kitchen Dashboard</h1>


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" style="width: 300px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-header">

                    <img class="text-center" style="align-items: center;" src="../assets/image/chaks.png" alt="logo" height="200px" weight="200px">

                </div>

                <?php
                
                require_once 'navbar.php';

                ?>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top: 200px">

        <div class="row my-5">
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="../assets/image/gift.jpg" alt="" width="100%">
            </div>
        </div>

        <div class="row my-5">
            <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
        </div>

    </div>




    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>

</body>

</html>